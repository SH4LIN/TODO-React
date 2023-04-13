<?php
/**
 * This file is used to register custom endpoint for rt-person.
 *
 * @package MovieLib\admin\classes\custom-endpoints
 */

namespace MovieLib\admin\classes\custom_endpoints;

use DateTime;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;
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

if ( ! class_exists( 'MovieLib\admin\classes\custom_endpoints\Custom_Endpoint_Person' ) ) {

	/**
	 * This class is used to register custom endpoint for rt-person.
	 */
	class Custom_Endpoint_Person {
		use Singleton;

		/**
		 * Custom_Endpoint_Person init method.
		 *
		 * @return void
		 */
		protected function init(): void {
			add_action( 'rest_api_init', array( $this, 'register' ) );
		}

		/**
		 * This function is used to register custom endpoint for rt-person.
		 *
		 * @return void
		 */
		public function register(): void {
			register_rest_route(
				'movielib/v1',
				'/persons',
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_persons' ),
					'permission_callback' => array( $this, 'get_persons_permissions_check' ),
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
				'/person',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_update_person' ),
					'permission_callback' => array( $this, 'create_person_permission_check' ),
					'validate_callback'   => array( $this, 'create_person_validate' ),
					'sanitize_callback'   => array( $this, 'create_person_sanitize' ),
				),
			);

			register_rest_route(
				'movielib/v1',
				'/person/(?P<id>\d+)',
				array(
					'methods'             => 'GET, PUT, DELETE',
					'callback'            => array( $this, 'person_by_id' ),
					'permission_callback' => array( $this, 'person_by_id_permissions_check' ),
					'validate_callback'   => array( $this, 'person_by_id_validate' ),
					'sanitize_callback'   => function ( $request ) {
						if ( 'PUT' === $request->get_method() ) {
							return $this->create_person_sanitize( $request );
						}
						return $request;
					},
				),
			);
		}

		/**
		 * This function is used to get persons.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return \WP_REST_Response
		 */
		public function get_persons( WP_REST_Request $request ): WP_REST_Response {

			$posts_per_page   = $request->get_param( 'per_page' );
			$page             = $request->get_param( 'page' );
			$order            = $request->get_param( 'order' );
			$orderby          = $request->get_param( 'orderby' );
			$can_read_private = current_user_can( 'read_private_posts' );

			$person_args = array(
				'post_type'   => RT_Person::SLUG,
				'order'       => $order,
				'orderby'     => $orderby,
				'post_status' => $can_read_private ? array( 'publish', 'private' ) : 'publish',
			);

			$ids = sanitize_text_field( $request->get_param( 'ids' ) );
			if ( ! empty( $ids ) ) {
				$ids         = explode( ',', $ids );
				$person_args = array_merge(
					$person_args,
					array(
						'post__in' => $ids,
					),
				);
			} else {
				$person_args = array_merge(
					$person_args,
					array(
						'posts_per_page' => $posts_per_page,
						'paged'          => $page,
					),
				);
			}

			$persons = get_posts( $person_args );

			// Get Person meta.
			foreach ( $persons as $person ) {
				$person->post_meta = get_person_meta( $person->ID );
			}

			$taxonomies = get_object_taxonomies( RT_Person::SLUG, 'object' );

			$persons = array_map(
				function( $person ) use ( $taxonomies ) {
					$person->taxonomies = array();
					foreach ( $taxonomies as $taxonomy ) {
						if ( $taxonomy->public && true === $taxonomy->show_in_rest ) {
							$person->taxonomies[ $taxonomy->name ] = wp_get_post_terms( $person->ID, $taxonomy->name );
						}
					}
					return $person;
				},
				$persons,
			);

			$response = new stdClass();

			$response->status  = __( 'success', 'movie-library' );
			$response->message = __( 'Persons fetched successfully.', 'movie-library' );
			$response->page    = $page;
			$response->posts   = count( $persons );
			$response->total   = wp_count_posts( RT_Person::SLUG )->publish;
			$response->data    = $persons;

			return rest_ensure_response( (array) $response );
		}

		/**
		 * This function is used to check permission for get persons.
		 *
		 * @return true|\WP_Error
		 */
		public function get_persons_permissions_check() {
			if ( ! current_user_can( 'read' ) ) {
				return new WP_Error(
					'401',
					__( 'Sorry, you cannot view the persons.', 'movie-library' ),
					array( 'status' => rest_authorization_required_code() ),
				);
			}
			return true;
		}

		/**
		 * This function is used to create or update a new person.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return \WP_REST_Response|\WP_Error
		 */
		public function create_update_person( WP_REST_Request $request ) {
			$person_details = $request->get_params();

			$person = $person_details['data'];

			if ( isset( $request['id'] ) ) {
				$person['ID'] = $request['id'];
				$person_id    = wp_update_post( $person );
			} else {
				if ( current_user_can( 'publish_posts' ) ) {
					$person['post_status'] = 'publish';
				} else {
					$person['post_status'] = 'pending';
				}
				$person['post_type'] = RT_Person::SLUG;

				$person_id = wp_insert_post( $person );
			}

			// Featured Image.
			if ( ! empty( $person_details['featured_image'] ) ) {
				set_post_thumbnail( $person_id, $person_details['featured_image'] );
			}

			if ( is_wp_error( $person_id ) || 0 === $person_id ) {
				return new WP_Error(
					'500',
					__( 'Something went wrong.', 'movie-library' ),
					array( 'status' => 500 ),
				);
			}

			$person['ID'] = $person_id;

			// Save meta.
			foreach ( $person_details['meta'] as $key => $value ) {
				update_person_meta( $person_id, $key, $value );
			}

			// Save taxonomies.
			foreach ( $person_details['taxonomies'] as $taxonomy => $terms ) {
				wp_set_post_terms( $person_id, $terms, $taxonomy );
			}

			if ( isset( $request['id'] ) ) {
				$message = __( 'Person updated successfully.', 'movie-library' );
			} else {
				$message = __( 'Person created successfully.', 'movie-library' );
			}

			return new WP_REST_Response(
				array(
					'status'  => __( 'success', 'movie-library' ),
					'message' => $message,
					'data'    => array(
						'person_id' => $person_id,
					),
				),
				200
			);
		}

		/**
		 * This function is used to check the permission to create person.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return bool|\WP_Error
		 */
		public function create_person_permission_check( WP_REST_Request $request ) {
			if ( ! current_user_can( 'edit_posts' ) ) {
				return new WP_Error(
					'401',
					__( 'Sorry, you are not allowed to create person.', 'movie-library' ),
					array(
						'status' => 401,
					)
				);
			}
			return true;
		}

		/**
		 * This function is used to validate data to create person.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return bool|\WP_Error
		 */
		public function create_person_validate( WP_REST_Request $request ) {
			$person = $request->get_params();

			if ( empty( $person['data'] ) || empty( $person['data']['post_title'] ) ) {
				return new WP_Error(
					'400',
					__( 'Person Name is required.', 'movie-library' ),
					array(
						'status' => 400,
					)
				);
			}

			$person_meta = $person['meta'];

			if ( isset( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG ] ) &&
				! empty( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG ] )
			) {
				if ( ! is_string( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Birth date should be in string format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$date_str    = $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG ];
				$date_format = 'Y-m-d';

				$date = DateTime::createFromFormat( $date_format, $date_str );

				if ( false === $date ) {
					return new WP_Error(
						'400',
						__( 'Birth date should be in 1967-12-22 (Y-m-d) format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
			}

			if ( isset( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_START_YEAR_SLUG ] ) &&
				! empty( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_START_YEAR_SLUG ] )
			) {
				if ( ! is_string( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_START_YEAR_SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Career start year should be in string format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$date_str    = $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_START_YEAR_SLUG ];
				$date_format = 'Y-m-d';

				$date = DateTime::createFromFormat( $date_format, $date_str );

				if ( false === $date ) {
					return new WP_Error(
						'400',
						__( 'Career start date should be in 1967-12-22 (Y-m-d) format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
			}

			if ( isset( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_PLACE_SLUG ] ) &&
				! empty( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_PLACE_SLUG ] )
			) {
				if ( ! is_string( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_PLACE_SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Birth place should be in string format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
			}

			if ( isset( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_FULL_NAME_SLUG ] ) &&
				! empty( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_FULL_NAME_SLUG ] )
			) {
				if ( ! is_string( $person_meta[ RT_Person_Meta_Box::PERSON_META_BASIC_FULL_NAME_SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Full Name should be in string format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
			}

			if ( isset( $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_TWITTER_SLUG ] ) &&
				! empty( RT_Person_Meta_Box::PERSON_META_SOCIAL_TWITTER_SLUG )
			) {
				if ( ! is_string( $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_TWITTER_SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Twitter URL should be in string format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$twitter_url = $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_TWITTER_SLUG ];
				if ( ! filter_var( $twitter_url, FILTER_VALIDATE_URL ) ) {
					return new WP_Error(
						'400',
						__( 'Twitter URL should be in valid format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
			}

			if ( isset( $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_FACEBOOK_SLUG ] ) &&
				! empty( RT_Person_Meta_Box::PERSON_META_SOCIAL_FACEBOOK_SLUG )
			) {
				if ( ! is_string( $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_FACEBOOK_SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Facebook URL should be in string format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$facebook_url = $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_FACEBOOK_SLUG ];
				if ( ! filter_var( $facebook_url, FILTER_VALIDATE_URL ) ) {
					return new WP_Error(
						'400',
						__( 'Facebook URL should be in valid format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
			}

			if ( isset( $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_INSTAGRAM_SLUG ] ) &&
				! empty( RT_Person_Meta_Box::PERSON_META_SOCIAL_INSTAGRAM_SLUG )
			) {
				if ( ! is_string( $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_INSTAGRAM_SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Instagram URL should be in string format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$instagram_url = $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_INSTAGRAM_SLUG ];
				if ( ! filter_var( $instagram_url, FILTER_VALIDATE_URL ) ) {
					return new WP_Error(
						'400',
						__( 'Instagram URL should be in valid format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
			}

			if ( isset( $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_WEB_SLUG ] ) &&
				! empty( RT_Person_Meta_Box::PERSON_META_SOCIAL_WEB_SLUG )
			) {
				if ( ! is_string( $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_WEB_SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Web URL should be in string format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				// Validate twitter url.
				$web_url = $person_meta[ RT_Person_Meta_Box::PERSON_META_SOCIAL_WEB_SLUG ];
				if ( ! filter_var( $web_url, FILTER_VALIDATE_URL ) ) {
					return new WP_Error(
						'400',
						__( 'Web URL should be in valid format.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
			}

			if ( isset( $person_meta[ RT_Media_Meta_Box::IMAGES_SLUG ] ) &&
				! empty( $person_meta[ RT_Media_Meta_Box::IMAGES_SLUG ] )
			) {
				if ( ! is_array( $person_meta[ RT_Media_Meta_Box::IMAGES_SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Images should be an array.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$images = $person_meta[ RT_Media_Meta_Box::IMAGES_SLUG ];
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

			if ( isset( $person_meta[ RT_Media_Meta_Box::VIDEOS_SLUG ] ) &&
				! empty( $person_meta[ RT_Media_Meta_Box::VIDEOS_SLUG ] )
			) {
				if ( ! is_array( $person_meta[ RT_Media_Meta_Box::VIDEOS_SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Videos should be an array.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$videos = $person_meta[ RT_Media_Meta_Box::VIDEOS_SLUG ];
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

			$person_taxonomy = $person['taxonomies'];
			if ( isset( $person_taxonomy[ Person_Career::SLUG ] ) &&
				! empty( $person_taxonomy[ Person_Career::SLUG ] )
			) {
				if ( ! is_array( $person_taxonomy[ Person_Career::SLUG ] ) ) {
					return new WP_Error(
						'400',
						__( 'Career should be an array.', 'movie-library' ),
						array(
							'status' => 400,
						)
					);
				}
				$careers = $person_taxonomy[ Person_Career::SLUG ];
				foreach ( $careers as $career ) {
					if ( ! is_numeric( $career ) ) {
						return new WP_Error(
							'400',
							__( 'Career ID should be numeric.', 'movie-library' ),
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
		 * This function is used to sanitize data to create person.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return \WP_REST_Request
		 */
		public function create_person_sanitize( WP_REST_Request $request ) {
			$person = $request->get_params();

			$person_meta = $person['meta'];
			foreach ( $person_meta as $key => $value ) {
				$key = sanitize_key( $key );
				if ( RT_Person_Meta_Box::PERSON_META_SOCIAL_INSTAGRAM_SLUG === $key ||
					RT_Person_Meta_Box::PERSON_META_SOCIAL_FACEBOOK_SLUG === $key ||
					RT_Person_Meta_Box::PERSON_META_SOCIAL_TWITTER_SLUG === $key ||
					RT_Person_Meta_Box::PERSON_META_SOCIAL_WEB_SLUG === $key
				) {
					$person_meta[ $key ] = esc_url_raw( $value );
				} else {
					$person_meta[ $key ] = sanitize_text_field( $value );
				}
			}

			$person_tax = $person['taxonomies'];
			foreach ( $person_tax as $key => $value ) {
				$key                = sanitize_key( $key );
				$person_tax[ $key ] = sanitize_term( $value, $key );
			}

			$request->set_param( 'meta', $person_meta );
			$request->set_param( 'taxonomies', $person_tax );

			return $request;
		}

		/**
		 * This function is an wrapper callback for GET, POST, PUT, DELETE methods.
		 * According to the request method, it will call the respective function.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return \WP_Error|\WP_REST_Response
		 */
		public function person_by_id( WP_REST_Request $request ) {
			if ( 'DELETE' === $request->get_method() ) {
				return $this->delete_person( $request );
			} elseif ( 'PUT' === $request->get_method() ) {
				return $this->create_update_person( $request );
			} else {
				return $this->get_person_by_id( $request );
			}
		}

		/**
		 * This function is used to check the permission to view, edit, create and delete single person.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return bool|\WP_Error
		 */
		public function person_by_id_permissions_check( WP_REST_Request $request ) {
			$id = $request['id'];
			if ( 'DELETE' === $request->get_method() ) {
				if ( ! current_user_can( 'delete_post', $id ) ) {
					return new WP_Error(
						'401',
						__( 'Sorry, you are not allowed to delete person.', 'movie-library' ),
						array(
							'status' => 401,
						)
					);
				}
			} elseif ( 'PUT' === $request->get_method() ) {
				if ( ! current_user_can( 'edit_post', $id ) ) {
					return new WP_Error(
						'401',
						__( 'Sorry, you are not allowed to update person.', 'movie-library' ),
						array(
							'status' => 401,
						)
					);
				}
			} else {
				if ( ! current_user_can( 'read' ) ) {
					return new WP_Error(
						'401',
						__( 'Sorry, you are not allowed to view person.', 'movie-library' ),
						array(
							'status' => 401,
						)
					);
				}
			}

			return true;
		}

		/**
		 * This function is used to validate the request that was sent using the person_by_id endpoint.
		 *
		 * @param \WP_REST_Request $request Request object.
		 * @return bool|\WP_Error
		 */
		public function person_by_id_validate( WP_REST_Request $request ) {
			$id = $request['id'];

			$person = get_post( $id );
			if ( ! $person || RT_Person::SLUG !== $person->post_type ) {
				return new WP_Error(
					'404',
					__( 'Sorry, person not found.', 'movie-library' ),
					array(
						'status' => 404,
					)
				);
			}

			if ( 'PUT' === $request->get_method() ) {
				return $this->create_person_validate( $request );
			}

			return true;
		}

		/**
		 * This function is used to delete person.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return \WP_REST_Response|\WP_Error
		 */
		public function delete_person( WP_REST_Request $request ): WP_Error|WP_REST_Response {
			$person_id    = $request['id'];
			$force_delete = sanitize_text_field( $request->get_param( 'force' ) ?? false );

			$deleted = wp_delete_post( $person_id, $force_delete );

			if ( ! $deleted ) {
				return new WP_Error(
					'500',
					__( 'Something went wrong.', 'movie-library' ),
					array( 'status' => 500 ),
				);
			}

			$person_meta = get_person_meta( $person_id );
			foreach ( $person_meta as $meta_key => $meta_value ) {
				delete_person_meta( $person_id, $meta_key );
			}

			return new WP_REST_Response(
				array(
					'status'  => __( 'success', 'movie-library' ),
					'message' => __( 'Person deleted successfully.', 'movie-library' ),
					'data'    => $deleted,
				),
				200
			);
		}

		/**
		 * This function is used to get person by id.
		 *
		 * @param \WP_REST_Request $request Request object.
		 *
		 * @return \WP_REST_Response|\WP_Error
		 */
		public function get_person_by_id( WP_REST_Request $request ) {
			$id = $request['id'];

			$person = get_post( $id );

			$person->featured_image = get_the_post_thumbnail_url( $person->ID, 'full' );

			// Get person meta.
			$person->post_meta = get_person_meta( $person->ID );

			$taxonomies = get_object_taxonomies( RT_Person::SLUG, 'object' );

			$person->taxonomies = array();
			foreach ( $taxonomies as $taxonomy ) {
				if ( $taxonomy->public && true === $taxonomy->show_in_rest ) {
					$person->taxonomies[ $taxonomy->name ] = wp_get_post_terms( $person->ID, $taxonomy->name );
				}
			}

			return new WP_REST_Response(
				array(
					'status'  => __( 'success', 'movie-library' ),
					'message' => __( 'Person fetched successfully.', 'movie-library' ),
					'data'    => $person,
				),
				200
			);
		}
	}
}

