<?php
/**
 * This file is used to register custom endpoint for rt-movie.
 *
 * @package MovieLib\admin\classes\custom-endpoints
 */

namespace MovieLib\admin\classes\custom_endpoints;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Genre;
use MovieLib\admin\classes\taxonomies\Movie_Label;
use MovieLib\admin\classes\taxonomies\Movie_Language;
use MovieLib\admin\classes\taxonomies\Movie_Person;
use MovieLib\admin\classes\taxonomies\Movie_Production_Company;
use MovieLib\admin\classes\taxonomies\Movie_Tag;
use MovieLib\admin\classes\taxonomies\Person_Career;
use MovieLib\includes\Singleton;
use stdClass;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\custom_endpoints\Custom_Endpoint_Movie' ) ) {

	/**
	 * This class is used to register custom endpoint for rt-movie.
	 */
	class Custom_Endpoint_Movie {
		use Singleton;

		/**
		 * Custom_Endpoint_Movie init method.
		 *
		 * @return void
		 */
		protected function init(): void {
			add_action( 'rest_api_init', array( $this, 'register' ) );
		}

		/**
		 * This function is used to register custom endpoint for rt-movie.
		 *
		 * @return void
		 */
		public function register(): void {
			register_rest_route(
				'movielib/v1',
				'/movies',
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_movies' ),
					'permission_callback' => array( $this, 'get_movies_permissions_check' ),
					'args'                => $this->get_movies_request_schema(),
				),
			);

			register_rest_route(
				'movielib/v1',
				'/movie',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_update_movie' ),
					'permission_callback' => array( $this, 'create_movie_permission_check' ),
					'args'                => array(
						'data'       => array(
							'required'   => true,
							'type'       => 'object',
							'properties' => array(
								'post_title' => array(
									'type'     => 'string',
									'required' => true,
								),
							),
						),
						'meta'       => $this->get_movie_meta_schema(),
						'taxonomies' => $this->get_movie_taxonomy_schema(),
					),

				),
			);

			register_rest_route(
				'movielib/v1',
				'/movie/(?P<id>\d+)',
				array(
					'methods'             => 'GET, PUT, DELETE',
					'callback'            => array( $this, 'movie_by_id' ),
					'permission_callback' => array( $this, 'movie_by_id_permissions_check' ),
					'args'                => array(
						'id'             => array(
							'required'          => true,
							'type'              => 'integer',
							'validate_callback' => function( $value ) {
								$movie = get_post( $value );
								if ( is_null( $movie ) || RT_Movie::SLUG !== $movie->post_type ) {
									return new WP_Error(
										'404',
										__( 'Sorry, movie not found.', 'movie-library' ),
										array(
											'status' => 404,
										)
									);
								}
								return true;
							},
						),
						'data'           => array(
							'type' => 'object',
						),
						'featured_image' => array(
							'type' => 'integer',
						),
						'meta'           => $this->get_movie_meta_schema(),
						'taxonomies'     => $this->get_movie_taxonomy_schema(),
					),
				),
			);
		}

		/**
		 * This function is used to get movies request schema.
		 *
		 * @return array[]
		 */
		public function get_movies_request_schema() {
			return array(
				'per_page' => array(
					'default'           => 10,
					'type'              => 'integer',
					'sanitize_callback' => array( $this, 'movie_sanitize' ),
					'validate_callback' => function( $value ) {
						return is_numeric( $value );
					},
				),
				'page'     => array(
					'default'           => 1,
					'type'              => 'integer',
					'sanitize_callback' => array( $this, 'movie_sanitize' ),
					'validate_callback' => function( $value ) {
						return is_numeric( $value );
					},
				),
				'order'    => array(
					'default'           => 'DESC',
					'type'              => 'string',
					'sanitize_callback' => array( $this, 'movie_sanitize' ),
					'validate_callback' => function( $value ) {
						return in_array( $value, array( 'ASC', 'DESC' ), true );
					},
				),
				'orderby'  => array(
					'default'           => 'date',
					'type'              => 'string',
					// Only Sanitizing the value.
					'sanitize_callback' => array( $this, 'movie_sanitize' ),
					'validate_callback' => function( $value ) {
						return is_string( $value );
					},
				),
				'ids'      => array(
					'type'  => 'array',
					'items' => array(
						'type'              => 'integer',
						'sanitize_callback' => array( $this, 'movie_sanitize' ),
						'validate_callback' => function( $value ) {
							return is_numeric( $value );
						},
					),

				),
			);
		}

		/**
		 * This function is used to get movies.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return \WP_REST_Response
		 */
		public function get_movies( WP_REST_Request $request ): WP_REST_Response {

			$posts_per_page = $request->get_param( 'per_page' );
			$page           = $request->get_param( 'page' );
			$order          = $request->get_param( 'order' );
			$orderby        = $request->get_param( 'orderby' );
			$ids            = $request->get_param( 'ids' );

			$can_read_private = current_user_can( 'read_private_posts' );

			$movie_args = array(
				'post_type'   => RT_Movie::SLUG,
				'order'       => $order,
				'orderby'     => $orderby,
				'post_status' => $can_read_private ? array( 'publish', 'private' ) : 'publish',
			);

			if ( ! empty( $ids ) ) {
				if ( ! is_array( $ids ) ) {
					$ids = explode( ',', $ids );
				}
				$movie_args = array_merge(
					$movie_args,
					array(
						'post__in' => $ids,
					),
				);
			} else {
				$movie_args = array_merge(
					$movie_args,
					array(
						'posts_per_page' => $posts_per_page,
						'paged'          => $page,
					),
				);
			}

			$movies = get_posts( $movie_args );

			// Get Movies meta.
			foreach ( $movies as $movie ) {
				$movie->post_meta = get_movie_meta( $movie->ID );
				if ( ! empty( $movie->post_meta ) ) {
					foreach ( $movie->post_meta as $key => $value ) {
						if ( ! empty( $value[0] ) ) {
							$movie->post_meta[ $key ] = maybe_unserialize( $value[0] );
						}
					}
				}
			}

			$taxonomies = get_object_taxonomies( RT_Movie::SLUG, 'object' );

			$movies = array_map(
				function( $movie ) use ( $taxonomies ) {
					$movie->taxonomies = array();
					foreach ( $taxonomies as $taxonomy ) {
						if ( $taxonomy->public && true === $taxonomy->show_in_rest ) {
							$movie->taxonomies[ $taxonomy->name ] = wp_get_post_terms( $movie->ID, $taxonomy->name );
						}
					}
					return $movie;
				},
				$movies,
			);

			$response = new stdClass();

			$response->status  = __( 'success', 'movie-library' );
			$response->message = __( 'Movies fetched successfully.', 'movie-library' );
			$response->page    = $page;
			$response->posts   = count( $movies );
			$response->total   = wp_count_posts( RT_Movie::SLUG )->publish;
			$response->data    = $movies;

			return rest_ensure_response( (array) $response );
		}

		/**
		 * This function is used to check permission for get movies.
		 *
		 * @return true|\WP_Error
		 */
		public function get_movies_permissions_check() {
			if ( ! current_user_can( 'read' ) ) {
				return new WP_Error(
					'401',
					__( 'Sorry, you cannot view the movies.', 'movie-library' ),
					array( 'status' => rest_authorization_required_code() ),
				);
			}
			return true;
		}

		/**
		 * This function is used to create a new movie.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return \WP_REST_Response|\WP_Error
		 */
		public function create_update_movie( WP_REST_Request $request ) {
			$movie_details = $request->get_json_params();
			$movie         = $movie_details['data'];

			if ( isset( $request['id'] ) ) {
				$movie['ID'] = $request['id'];
				$movie_id    = wp_update_post( $movie );
			} else {
				if ( current_user_can( 'publish_posts' ) ) {
					$movie['post_status'] = 'publish';
				} else {
					$movie['post_status'] = 'pending';
				}
				$movie['post_type'] = RT_Movie::SLUG;

				$movie_id = wp_insert_post( $movie );
			}

			// Featured Image.
			if ( ! empty( $movie_details['featured_image'] ) ) {
				set_post_thumbnail( $movie_id, $movie_details['featured_image'] );
			}

			if ( is_wp_error( $movie_id ) || 0 === $movie_id ) {
				return new WP_Error(
					'500',
					__( 'Something went wrong.', 'movie-library' ),
					array( 'status' => 500 ),
				);
			}

			$movie['ID'] = $movie_id;

			$rt_career_terms = get_terms(
				array(
					'taxonomy'   => Person_Career::SLUG,
					'hide_empty' => true,
				)
			);

			$movie_career_terms = array();
			foreach ( $rt_career_terms as $rt_career_term ) {
				$movie_career_terms[] = RT_Movie_Meta_Box::MOVIE_META_CREW_SLUG . '-' . $rt_career_term->slug;
			}

			$shadow_terms = array();
			// Save meta.
			foreach ( $movie_details['meta'] as $key => $value ) {
				if ( in_array( $key, $movie_career_terms, true ) ) {

					$value_in_int = array();
					foreach ( $value as $val ) {
						$details              = array();
						$shadow_terms[]       = $val['person_id'];
						$details['person_id'] = (int) $val['person_id'];

						if ( isset( $val['person_name'] ) ) {
							$details['person_name'] = $val['person_name'];
						}

						if ( isset( $val['character_name'] ) ) {
							$details['character_name'] = $val['character_name'];
						}

						$value_in_int[] = $details;
					}
					update_movie_meta( $movie_id, $key, $value_in_int );
				} else {
					update_movie_meta( $movie_id, $key, $value );
				}
			}

			wp_set_object_terms( $movie_id, $shadow_terms, Movie_Person::SLUG, true );

			// Save taxonomies.
			foreach ( $movie_details['taxonomies'] as $taxonomy => $terms ) {
				$terms = array_map(
					function( $term ) use ( $taxonomy ) {
						if ( is_numeric( $term ) ) {
							return (int) $term;
						}
						$term_id = term_exists( $term, $taxonomy );
						return (int) $term_id['term_id'];
					},
					$terms
				);
				wp_set_post_terms( $movie_id, $terms, $taxonomy );
			}
			if ( isset( $request['id'] ) ) {
				$message = __( 'Movie updated successfully.', 'movie-library' );
			} else {
				$message = __( 'Movie created successfully.', 'movie-library' );
			}
			return new WP_REST_Response(
				array(
					'status'  => __( 'success', 'movie-library' ),
					'message' => $message,
					'data'    => array(
						'movie_id' => $movie_id,
					),
				),
				200
			);
		}

		/**
		 * This function is used to check the permission to create movie.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return bool|\WP_Error
		 */
		public function create_movie_permission_check( WP_REST_Request $request ) {
			if ( ! current_user_can( 'edit_posts' ) ) {
				return new WP_Error(
					'401',
					__( 'Sorry, you are not allowed to create movie.', 'movie-library' ),
					array(
						'status' => 401,
					)
				);
			}
			return true;
		}

		/**
		 * This function is used to validate taxonomies to create movie.
		 *
		 * @param array            $value Value to validate.
		 * @param \WP_REST_Request $request Request object.
		 * @param string           $param Parameter name.
		 * @return bool|\WP_Error
		 */
		public function create_movie_taxonomies_validate( $value, $request, $param ) {
			$result = rest_validate_value_from_schema( $value, $this->get_movie_taxonomy_schema(), $param );
			if ( is_wp_error( $result ) ) {
				return $result;
			}
			foreach ( $value as $key => $values ) {
				if ( ! taxonomy_exists( $key ) ) {
					return new WP_Error(
						'400',
						// translators: %s is the taxonomy name.
						sprintf( __( '%s is not a valid taxonomy.', 'movie-library' ), $key ),
						array(
							'status' => 400,
						)
					);
				}
				foreach ( $values as $value ) {
					if ( ! term_exists( $value, $key ) ) {
						return new WP_Error(
							'400',
							// translators: %1$s is the term name and %2$s is the taxonomy name.
							sprintf( __( '%1$s term does not exist in %2$s', 'movie-library' ), $value, $key ),
							array(
								'status' => 400,
							)
						);
					}
				}
			}

			return true;
		}

		/**
		 * This function is an wrapper callback for GET, POST, PUT, DELETE methods.
		 * According to the request method, it will call the respective function.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return \WP_Error|\WP_REST_Response
		 */
		public function movie_by_id( WP_REST_Request $request ) {
			if ( 'DELETE' === $request->get_method() ) {
				return $this->delete_movie( $request );
			} elseif ( 'PUT' === $request->get_method() ) {
				return $this->create_update_movie( $request );
			} else {
				return $this->get_movie_by_id( $request );
			}
		}

		/**
		 * This function is used to check the permission to view, edit, create and delete single movie.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return bool|\WP_Error
		 */
		public function movie_by_id_permissions_check( WP_REST_Request $request ) {
			$id = $request['id'];
			if ( 'DELETE' === $request->get_method() ) {
				if ( ! current_user_can( 'delete_post', $id ) ) {
					return new WP_Error(
						'401',
						__( 'Sorry, you are not allowed to delete movie.', 'movie-library' ),
						array(
							'status' => 401,
						)
					);
				}
			} elseif ( 'PUT' === $request->get_method() ) {
				if ( ! current_user_can( 'edit_post', $id ) ) {
					return new WP_Error(
						'401',
						__( 'Sorry, you are not allowed to update movie.', 'movie-library' ),
						array(
							'status' => 401,
						)
					);
				}
			} else {
				if ( ! current_user_can( 'read' ) ) {
					return new WP_Error(
						'401',
						__( 'Sorry, you are not allowed to view movie.', 'movie-library' ),
						array(
							'status' => 401,
						)
					);
				}
			}

			return true;
		}

		/**
		 * This function is used to delete movie.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return \WP_REST_Response|\WP_Error
		 */
		public function delete_movie( WP_REST_Request $request ) {
			$movie_id     = $request['id'];
			$force_delete = sanitize_text_field( $request->get_param( 'force' ) ?? false );

			$deleted = wp_delete_post( $movie_id, $force_delete );

			if ( ! $deleted ) {
				return new WP_Error(
					'500',
					__( 'Something went wrong.', 'movie-library' ),
					array( 'status' => 500 ),
				);
			}

			$movie_meta = get_movie_meta( $movie_id );
			foreach ( $movie_meta as $meta_key => $meta_value ) {
				delete_movie_meta( $movie_id, $meta_key );
			}

			return new WP_REST_Response(
				array(
					'status'  => __( 'success', 'movie-library' ),
					'message' => __( 'Movie deleted successfully.', 'movie-library' ),
					'data'    => $deleted,
				),
				200
			);
		}

		/**
		 * This function is used to get movie by id.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return \WP_REST_Response|\WP_Error
		 */
		public function get_movie_by_id( WP_REST_Request $request ) {
			$id = $request['id'];

			$movie = get_post( $id );

			$movie->featured_image = get_the_post_thumbnail_url( $movie->ID, 'full' );

			// Get Movies meta.
			$movie->post_meta = get_movie_meta( $movie->ID );
			if ( ! empty( $movie->post_meta ) ) {
				foreach ( $movie->post_meta as $key => $value ) {
					if ( ! empty( $value[0] ) ) {
						$movie->post_meta[ $key ] = maybe_unserialize( $value[0] );
					}
				}
			}

			$taxonomies = get_object_taxonomies( RT_Movie::SLUG, 'object' );

			$movie->taxonomies = array();
			foreach ( $taxonomies as $taxonomy ) {
				if ( $taxonomy->public && true === $taxonomy->show_in_rest ) {
					$movie->taxonomies[ $taxonomy->name ] = wp_get_post_terms( $movie->ID, $taxonomy->name );
				}
			}

			return new WP_REST_Response(
				array(
					'status'  => __( 'success', 'movie-library' ),
					'message' => __( 'Movie fetched successfully.', 'movie-library' ),
					'data'    => $movie,
				),
				200
			);
		}

		/**
		 * This function specifies the schema for the movie meta.
		 *
		 * @return array
		 */
		public function get_movie_meta_schema(): array {
			return array(
				'type'              => 'object',
				'sanitize_callback' => array( $this, 'movie_sanitize' ),
				'validate_callback' => array( $this, 'create_movie_meta_validate' ),
				'properties'        => array(
					RT_Movie_Meta_Box::MOVIE_META_BASIC_RATING_SLUG => array(
						'type'    => 'number',
						'minimum' => 1,
						'maximum' => 10,
					),
					RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG => array(
						'type' => 'string',
					),
					RT_Movie_Meta_Box::MOVIE_META_BASIC_RUNTIME_SLUG => array(
						'type'    => 'number',
						'minimum' => 1,
						'maximum' => 1000,
					),
				),
				'patternProperties' => array(
					'^' . RT_Movie_Meta_Box::MOVIE_META_CREW_SLUG . '-[a-z-A-Z]+$' => array(
						'type'  => 'array',
						'items' => array(
							'type'       => 'object',
							'properties' => array(
								'person_id'      => array(
									'required' => true,
									'type'     => 'integer',
								),
								'person_name'    => array(
									'type' => 'string',
								),
								'character_name' => array(
									'type' => 'string',
								),
							),
						),
					),
					'^' . RT_Media_Meta_Box::SLUG . '-[a-z-A-Z]+$' => array(
						'type'        => 'array',
						'uniqueItems' => true,
						'items'       => array(
							'type' => 'integer',
						),
					),
				),
			);
		}

		/**
		 * This function gives the schema for the movie taxonomy.
		 *
		 * @return array
		 */
		public function get_movie_taxonomy_schema(): array {
			return array(
				'type'              => 'object',
				'validate_callback' => array( $this, 'create_movie_taxonomies_validate' ),
				'sanitize_callback' => array( $this, 'movie_sanitize' ),
				'patternProperties' => array(
					'^.*$' => array(
						'type'  => 'array',
						'items' => array(
							'type' => array( 'string', 'integer' ),
						),
					),
				),
			);
		}

		/**
		 * This function is used to sanitize the meta data and taxonomies.
		 *
		 * @param array            $value   Value to sanitize.
		 * @param \WP_REST_Request $request Request object.
		 * @param string           $param   Parameter name.
		 *
		 * @return array|string
		 */
		public function movie_sanitize( $value, $request, $param ) {
			return $this->mlb_sanitize_text_field_recursive( $value );
		}

		/**
		 * This function is used to sanitize the meta data and taxonomies.
		 *
		 * @param array            $value   Value to sanitize.
		 * @param \WP_REST_Request $request Request object.
		 * @param string           $param   Parameter name.
		 * @return array
		 */
		public function create_movie_meta_validate( $value, $request, $param ) {
			return rest_validate_value_from_schema( $value, $this->get_movie_meta_schema(), $param );
		}

		/**
		 * This is recursive function to sanitize any depth of the array.
		 *
		 * @param array $value array to be sanitized.
		 *
		 * @return array|string
		 */
		public function mlb_sanitize_text_field_recursive( $value ) {
			if ( is_array( $value ) ) {
				foreach ( $value as $key => $val ) {
					$key           = sanitize_key( $key );
					$value[ $key ] = $this->mlb_sanitize_text_field_recursive( $val );
				}
				return $value;
			} else {
				return sanitize_text_field( $value );
			}
		}
	}
}
