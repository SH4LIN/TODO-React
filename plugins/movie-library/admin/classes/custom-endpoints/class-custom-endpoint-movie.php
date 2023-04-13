<?php
/**
 * This file is used to register custom endpoint for rt-movie.
 *
 * @package MovieLib\admin\classes\custom-endpoints
 */

namespace MovieLib\admin\classes\custom_endpoints;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Person;
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
					'args'                => array(
						'per_page' => array(
							'default'           => 10,
							'sanitize_callback' => 'absint',
						),
						'page'     => array(
							'default'           => 1,
							'sanitize_callback' => 'absint',
						),
						'order'    => array(
							'default'           => 'DESC',
							'sanitize_callback' => 'sanitize_text_field',
						),
						'orderby'  => array(
							'default'           => 'date',
							'sanitize_callback' => 'sanitize_text_field',
						),
					),
				),
			);

			register_rest_route(
				'movielib/v1',
				'/movie',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_update_movie' ),
					'permission_callback' => array( $this, 'create_movie_permission_check' ),
					'validate_callback'   => array( $this, 'create_movie_validate' ),
					'sanitize_callback'   => array( $this, 'create_movie_sanitize' ),
				),
			);

			register_rest_route(
				'movielib/v1',
				'/movie/(?P<id>\d+)',
				array(
					'methods'             => 'GET, PUT, DELETE',
					'callback'            => array( $this, 'movie_by_id' ),
					'permission_callback' => array( $this, 'movie_by_id_permissions_check' ),
					'validate_callback'   => array( $this, 'movie_by_id_validate' ),
					'sanitize_callback'   => function ( $request ) {
						if ( 'PUT' === $request->get_method() ) {
							return $this->create_movie_sanitize( $request );
						} return $request;
					},
				),
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
		 * This function is used to validate data to create movie.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return bool|\WP_Error
		 */
		public function create_movie_validate( WP_REST_Request $request ) {
			$movie = $request->get_params();

			if ( empty( $movie['data'] ) || empty( $movie['data']['post_title'] ) ) {
				return new WP_Error(
					'400',
					__( 'Movie Title is required.', 'movie-library' ),
					array(
						'status' => 400,
					)
				);
			}

			$movie_meta = $movie['movie_meta'];
			if ( isset( $movie_meta['rt-movie-meta-basic-rating'] ) && ! empty( $movie_meta['rt-movie-meta-basic-rating'] ) ) {
				if ( ! is_numeric( $movie_meta['rt-movie-meta-basic-rating'] ) ) {
					return new WP_Error(
						'400',
						__( 'Rating should be numeric.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				} else {
					if ( $movie_meta['rt-movie-meta-basic-rating'] < 0 || $movie_meta['rt-movie-meta-basic-rating'] > 10 ) {
						return new WP_Error(
							'400',
							__( 'Rating should be between 0 and 10.', 'movie-library' ),
							array(
								'status' => 400,
							)
						);
					}
				}
			}

			if ( isset( $movie_meta['rt-movie-meta-basic-runtime'] ) && ! empty( $movie_meta['rt-movie-meta-basic-runtime'] ) ) {
				if ( ! is_numeric( $movie_meta['rt-movie-meta-basic-runtime'] ) ) {
					return new WP_Error(
						'400',
						__( 'Runtime should be numeric.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				} else {
					if ( $movie_meta['rt-movie-meta-basic-runtime'] < 0 || $movie_meta['rt-movie-meta-basic-runtime'] > 1000 ) {
						return new WP_Error(
							'400',
							__( 'Runtime should be between 0 and 1000.', 'movie-library' ),
							array(
								'status' => 400,
							)
						);
					}
				}
			}

			if ( isset( $movie_meta['rt-movie-meta-basic-release-date'] ) && ! empty( $movie_meta['rt-movie-meta-basic-release-date'] ) ) {
				$date_str    = $movie_meta['rt-movie-meta-basic-release-date'];
				$date_format = 'Y-m-d';

				$date = wp_date( $date_format, strtotime( $date_str ) );

				if ( ! $date ) {
					return new WP_Error(
						'400',
						__( 'Release Date should be in valid format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
			}

			if ( isset( $movie_meta['rt-media-meta-images'] ) && ! empty( $movie_meta['rt-media-meta-images'] ) ) {
				if ( ! is_array( $movie_meta['rt-media-meta-images'] ) ) {
					return new WP_Error(
						'400',
						__( 'Images should be an array.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$images = $movie_meta['rt-media-meta-images'];
				foreach ( $images as $image ) {
					if ( ! is_numeric( $image ) ) {
						return new WP_Error(
							'400',
							__( 'Image ID should be numeric.', 'movie-library' ),
							array(
								'status' => 400,
							)
						);
					}
				}
			}

			if ( isset( $movie_meta['rt-media-meta-videos'] ) && ! empty( $movie_meta['rt-media-meta-videos'] ) ) {
				if ( ! is_array( $movie_meta['rt-media-meta-videos'] ) ) {
					return new WP_Error(
						'400',
						__( 'Videos should be an array.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$videos = $movie_meta['rt-media-meta-videos'];
				foreach ( $videos as $video ) {
					if ( ! is_numeric( $video ) ) {
						return new WP_Error(
							'400',
							__( 'Video ID should be numeric.', 'movie-library' ),
							array(
								'status' => 400,
							)
						);
					}
				}
			}

			$movie_taxonomy = $movie['taxonomies'];
			if ( isset( $movie_taxonomy['rt-movie-genre'] ) && ! empty( $movie_taxonomy['rt-movie-genre'] ) ) {
				if ( ! is_array( $movie_taxonomy['rt-movie-genre'] ) ) {
					return new WP_Error(
						'400',
						__( 'Genre should be an array.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$genres = $movie_taxonomy['rt-movie-genre'];
				foreach ( $genres as $genre ) {
					if ( ! is_numeric( $genre ) ) {
						return new WP_Error(
							'400',
							__( 'Genre ID should be numeric.', 'movie-library' ),
							array(
								'status' => 400,
							)
						);
					}
				}
			}

			if ( isset( $movie_taxonomy['rt-movie-label'] ) && ! empty( $movie_taxonomy['rt-movie-label'] ) ) {
				if ( ! is_array( $movie_taxonomy['rt-movie-label'] ) ) {
					return new WP_Error(
						'400',
						__( 'Label should be an array.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$labels = $movie_taxonomy['rt-movie-label'];
				foreach ( $labels as $label ) {
					if ( ! is_numeric( $label ) ) {
						return new WP_Error(
							'400',
							__( 'Label ID should be numeric.', 'movie-library' ),
							array(
								'status' => 400,
							)
						);
					}
				}
			}

			if ( isset( $movie_taxonomy['rt-movie-language'] ) && ! empty( $movie_taxonomy['rt-movie-language'] ) ) {
				if ( ! is_array( $movie_taxonomy['rt-movie-language'] ) ) {
					return new WP_Error(
						'400',
						__( 'Language should be an array.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$languages = $movie_taxonomy['rt-movie-language'];
				foreach ( $languages as $language ) {
					if ( ! is_numeric( $language ) ) {
						return new WP_Error(
							'400',
							__( 'Language ID should be numeric.', 'movie-library' ),
							array(
								'status' => 400,
							)
						);
					}
				}
			}

			if ( isset( $movie_taxonomy['rt-movie-production-company'] ) && ! empty( $movie_taxonomy['rt-movie-production-company'] ) ) {
				if ( ! is_array( $movie_taxonomy['rt-movie-production-company'] ) ) {
					return new WP_Error(
						'400',
						__( 'Production Company should be an array.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$production_companies = $movie_taxonomy['rt-movie-production-company'];
				foreach ( $production_companies as $production_company ) {
					if ( ! is_numeric( $production_company ) ) {
						return new WP_Error(
							'400',
							__( 'Production Company ID should be numeric.', 'movie-library' ),
							array(
								'status' => 400,
							)
						);
					}
				}
			}

			if ( isset( $movie_taxonomy['rt-movie-tag'] ) && ! empty( $movie_taxonomy['rt-movie-tag'] ) ) {
				if ( ! is_array( $movie_taxonomy['rt-movie-tag'] ) ) {
					return new WP_Error(
						'400',
						__( 'Tag should be an array.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$tags = $movie_taxonomy['rt-movie-tag'];
				foreach ( $tags as $tag ) {
					if ( ! is_numeric( $tag ) ) {
						return new WP_Error(
							'400',
							__( 'Tag ID should be numeric.', 'movie-library' ),
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
		 * This function is used to sanitize the meta data and taxonomies.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return \WP_REST_Request
		 */
		public function create_movie_sanitize( WP_REST_Request $request ): WP_REST_Request {
			$movie = $request->get_params();

			$movie_meta = $movie['movie_meta'];
			foreach ( $movie_meta as $key => $value ) {
				$key                = sanitize_key( $key );
				$movie_meta[ $key ] = sanitize_text_field( $value );
			}

			$movie_tax = $movie['taxonomies'];
			foreach ( $movie_tax as $key => $value ) {
				$key               = sanitize_key( $key );
				$movie_tax[ $key ] = sanitize_term( $value, $key );
			}

			$request->set_param( 'movie_meta', $movie_meta );
			$request->set_param( 'taxonomies', $movie_tax );

			return $request;
		}

		/**
		 * This function is used to create a new movie.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return \WP_REST_Response|\WP_Error
		 */
		public function create_update_movie( WP_REST_Request $request ) {
			$movie_details = $request->get_json_params();

			$movie = $movie_details['data'];

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
			foreach ( $movie_details['movie_meta'] as $key => $value ) {
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
				wp_set_post_terms( $movie_id, $terms, $taxonomy );
			}
			if ( isset( $request['id'] ) ) {
				return new WP_REST_Response(
					array(
						'status'  => 'success',
						'message' => __( 'Movie updated successfully.', 'movie-library' ),
						'data'    => array(
							'movie_id' => $movie_id,
						),
					),
					200
				);
			} else {
				return new WP_REST_Response(
					array(
						'status'  => 'success',
						'message' => __( 'Movie created successfully.', 'movie-library' ),
						'data'    => array(
							'movie_id' => $movie_id,
						),
					),
					200
				);
			}
		}

		/**
		 * This function is used to validate the request that was sent using the movie_by_id endpoint.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return bool|\WP_Error
		 */
		public function movie_by_id_validate( WP_REST_Request $request ) {

			$id = $request['id'];

			$movie = get_post( $id );
			if ( ! $movie || RT_Movie::SLUG !== $movie->post_type ) {
				return new WP_Error(
					'404',
					__( 'Sorry, movie not found.', 'movie-library' ),
					array(
						'status' => 404,
					)
				);
			}

			if ( 'PUT' === $request->get_method() ) {
				$movie_data = $request->get_params();
				if ( isset( $movie_data['data']['post_title'] ) && empty( $movie_data['data']['post_title'] ) ) {
					return new WP_Error(
						'400',
						__( "Sorry, movie title can't be empty.", 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}

				return $this->create_movie_validate( $request );
			}

			return true;
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

			$taxonomies = get_object_taxonomies( RT_Movie::SLUG, 'object' );

			$movie->taxonomies = array();
			foreach ( $taxonomies as $taxonomy ) {
				if ( $taxonomy->public && true === $taxonomy->show_in_rest ) {
					$movie->taxonomies[ $taxonomy->name ] = wp_get_post_terms( $movie->ID, $taxonomy->name );
				}
			}

			return new WP_REST_Response(
				array(
					'status'  => 'success',
					'message' => 'Movie fetched successfully.',
					'data'    => $movie,
				),
				200
			);
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
					'message' => __( 'Movie deleted successfully.', 'movie-library' ),
					'data'    => $deleted,
				),
				200
			);
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
		 * This function is used to get movies.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return \WP_REST_Response
		 */
		public function get_movies( WP_REST_Request $request ): WP_REST_Response {

			$posts_per_page   = $request->get_param( 'per_page' );
			$page             = $request->get_param( 'page' );
			$order            = $request->get_param( 'order' );
			$orderby          = $request->get_param( 'orderby' );
			$can_read_private = current_user_can( 'read_private_posts' );

			$ids = sanitize_text_field( $request->get_param( 'ids' ) );
			if ( null !== $ids ) {
				$ids    = explode( ',', $ids );
				$movies = get_posts(
					array(
						'post_type'   => RT_Movie::SLUG,
						'order'       => $order,
						'orderby'     => $orderby,
						'post__in'    => $ids,
						'post_status' => $can_read_private ? array( 'publish', 'private' ) : 'publish',
					),
				);
			} else {
				$movies = get_posts(
					array(
						'post_type'      => RT_Movie::SLUG,
						'posts_per_page' => $posts_per_page,
						'paged'          => $page,
						'order'          => $order,
						'orderby'        => $orderby,
						'post_status'    => $can_read_private ? array( 'publish', 'private' ) : 'publish',
					),
				);
			}

			// Get Movies meta.
			foreach ( $movies as $movie ) {
				$movie->post_meta = get_movie_meta( $movie->ID );
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

			$response->status  = 'success';
			$response->message = 'Movies fetched successfully.';
			$response->page    = $page;
			$response->posts   = count( $movies );
			$response->total   = wp_count_posts( RT_Movie::SLUG )->publish;
			$response->data    = $movies;

			return rest_ensure_response( (array) $response );
		}
	}
}
