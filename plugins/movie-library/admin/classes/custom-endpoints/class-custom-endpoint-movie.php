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
				return new \WP_Error(
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
				return new \WP_Error(
					'400',
					__( 'Movie Title is required.', 'movie-library' ),
					array(
						'status' => 400,
					)
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
			$movie_details = $request->get_params();

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
				return new \WP_Error(
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
					),
					200
				);
			} else {
				return new WP_REST_Response(
					array(
						'status'  => 'success',
						'message' => __( 'Movie created successfully.', 'movie-library' ),
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
			$method = $request->get_method();

			$id = $request['id'];

			if ( 'PUT' === $method ) {
				$movie_data = $request->get_params();
				if ( isset( $movie_data['data']['post_title'] ) && empty( $movie_data['data']['post_title'] ) ) {
					return new \WP_Error(
						'400',
						__( "Sorry, movie title can't be empty.", 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
			}

			$movie = get_post( $id );
			if ( ! $movie ) {
				return new \WP_Error(
					'404',
					__( 'Sorry, movie not found.', 'movie-library' ),
					array(
						'status' => 404,
					)
				);
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
			$method = $request->get_method();
			$id     = $request['id'];
			if ( 'DELETE' === $method ) {
				if ( ! current_user_can( 'delete_post', $id ) ) {
					return new \WP_Error(
						'401',
						__( 'Sorry, you are not allowed to delete movie.', 'movie-library' ),
						array(
							'status' => 401,
						)
					);
				}
			} elseif ( 'PUT' === $method ) {
				if ( ! current_user_can( 'edit_post', $id ) ) {
					return new \WP_Error(
						'401',
						__( 'Sorry, you are not allowed to update movie.', 'movie-library' ),
						array(
							'status' => 401,
						)
					);
				}
			} else {
				if ( ! current_user_can( 'read' ) ) {
					return new \WP_Error(
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
			$method = $request->get_method();
			if ( 'DELETE' === $method ) {
				return $this->delete_movie( $request );
			} elseif ( 'PUT' === $method ) {
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

			return new WP_REST_Response( $movie, 200 );
		}

		/**
		 * This function is used to delete movie.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return \WP_REST_Response|\WP_Error
		 */
		public function delete_movie( WP_REST_Request $request ) {
			$movie_id = $request['id'];

			$movie = get_post( $movie_id );

			$deleted = wp_delete_post( $movie_id, true );

			if ( ! $deleted ) {
				return new \WP_Error(
					'500',
					__( 'Something went wrong.', 'movie-library' ),
					array( 'status' => 500 ),
				);
			}

			return new WP_REST_Response( $movie, 200 );
		}

		/**
		 * This function is used to check permission for get movies.
		 *
		 * @return true|\WP_Error
		 */
		public function get_movies_permissions_check() {
			if ( ! current_user_can( 'read' ) ) {
				return new \WP_Error(
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

			$posts_per_page   = $request->get_param( 'posts_per_page' ) ?? 10;
			$page             = $request->get_param( 'page' ) ?? 1;
			$order            = $request->get_param( 'order' ) ?? 'DESC';
			$orderby          = $request->get_param( 'orderby' ) ?? 'date';
			$can_read_private = current_user_can( 'read_private_posts' );

			if ( null !== $request->get_param( 'ids' ) ) {
				$ids    = explode( ',', $request->get_param( 'ids' ) );
				$movies = get_posts(
					array(
						'post_type'   => RT_Movie::SLUG,
						'order'       => $order,
						'orderby'     => $orderby,
						'post_status' => $can_read_private ? array( 'publish', 'private' ) : 'publish',
						'post__in'    => $ids,
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

			$response->page  = $page;
			$response->posts = count( $movies );
			$response->total = wp_count_posts( RT_Movie::SLUG )->publish;
			$response->data  = $movies;

			return rest_ensure_response( (array) $response );
		}
	}
}
