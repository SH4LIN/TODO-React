<?php
/**
 * This file is used to register custom endpoint for rt-person.
 *
 * @package MovieLib\admin\classes\custom-endpoints
 */

namespace MovieLib\admin\classes\custom_endpoints;

use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;
use MovieLib\includes\Singleton;
use stdClass;
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
		use Custom_Endpoint_Utils;

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
					'args'                => $this->get_posts_request_schema(),
				),
			);

			register_rest_route(
				'movielib/v1',
				'/person',
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_update_person' ),
					'permission_callback' => array( $this, 'create_person_permission_check' ),
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
						'meta'       => $this->create_person_meta_schema(),
						'taxonomies' => $this->get_post_taxonomy_schema(),
					),
				),
			);

			register_rest_route(
				'movielib/v1',
				'/person/(?P<id>\d+)',
				array(
					'methods'             => 'GET, PUT, DELETE',
					'callback'            => array( $this, 'person_by_id' ),
					'permission_callback' => array( $this, 'person_by_id_permissions_check' ),
					'args'                => array(
						'id'         => array(
							'required'          => true,
							'type'              => 'integer',
							'validate_callback' => function( $value ) {
								return is_numeric( $value );
							},
						),
						'meta'       => $this->create_person_meta_schema(),
						'taxonomies' => $this->get_post_taxonomy_schema(),
					),
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

			$posts_per_page = $request->get_param( 'per_page' );
			$page           = $request->get_param( 'page' );
			$order          = $request->get_param( 'order' );
			$orderby        = $request->get_param( 'orderby' );
			$ids            = $request->get_param( 'ids' );

			$can_read_private = current_user_can( 'read_private_posts' );

			$person_args = array(
				'post_type'   => RT_Person::SLUG,
				'order'       => $order,
				'orderby'     => $orderby,
				'post_status' => $can_read_private ? array( 'publish', 'private' ) : 'publish',
			);

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

			foreach ( $persons as $person ) {
				$person->post_meta = get_person_meta( $person->ID );
				foreach ( $person->post_meta as $key => $value ) {
					if ( ! empty( $value[0] ) ) {
						$person->post_meta[ $key ] = maybe_unserialize( $value[0] );
					}
				}
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
				return $this->get_error_response(
					__( 'Sorry, you cannot view the persons.', 'movie-library' ),
					rest_authorization_required_code()
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
				return $this->get_error_response(
					__( 'Something went wrong.', 'movie-library' ),
					500
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
				return $this->get_error_response(
					__( 'Sorry, you are not allowed to create person.', 'movie-library' ),
					rest_authorization_required_code()
				);
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
					return $this->get_error_response(
						__( 'Sorry, you are not allowed to delete person.', 'movie-library' ),
						rest_authorization_required_code()
					);
				}
			} elseif ( 'PUT' === $request->get_method() ) {
				if ( ! current_user_can( 'edit_post', $id ) ) {
					return $this->get_error_response(
						__( 'Sorry, you are not allowed to update person.', 'movie-library' ),
						rest_authorization_required_code()
					);
				}
			} else {
				if ( ! current_user_can( 'read' ) ) {
					return $this->get_error_response(
						__( 'Sorry, you are not allowed to view person.', 'movie-library' ),
						rest_authorization_required_code()
					);
				}
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
		public function delete_person( WP_REST_Request $request ) {
			$person_id    = $request['id'];
			$force_delete = sanitize_text_field( $request->get_param( 'force' ) ?? false );

			$deleted = wp_delete_post( $person_id, $force_delete );

			if ( ! $deleted ) {
				return $this->get_error_response(
					__( 'Something went wrong.', 'movie-library' ),
					500
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
			if ( ! empty( $person->post_meta ) ) {
				foreach ( $person->post_meta as $key => $value ) {
					if ( ! empty( $value[0] ) ) {
						$person->post_meta[ $key ] = maybe_unserialize( $value[0] );
					}
				}
			}

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

		/**
		 * This function specifies the schema for the movie meta.
		 *
		 * @return array
		 */
		public function create_person_meta_schema(): array {
			return array(
				'type'              => 'object',
				'sanitize_callback' => array( $this, 'mlb_sanitize' ),
				'validate_callback' => array( $this, 'create_person_meta_validate' ),
				'properties'        => array(
					RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG => array(
						'type' => 'string',
					),
					RT_Person_Meta_Box::PERSON_META_BASIC_START_YEAR_SLUG => array(
						'type' => 'string',
					),
					RT_Person_Meta_Box::PERSON_META_BASIC_FULL_NAME_SLUG => array(
						'type' => 'string',
					),
					RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_PLACE_SLUG => array(
						'type' => 'string',
					),
				),
				'patternProperties' => array(
					'^' . RT_Person_Meta_Box::PERSON_META_SOCIAL_WEB_SLUG . '-[a-z-A-Z]+$' => array(
						'type'   => 'string',
						'format' => 'uri',
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
		 * This function is used to sanitize the meta data and taxonomies.
		 *
		 * @param array            $value   Value to sanitize.
		 * @param \WP_REST_Request $request Request object.
		 * @param string           $param   Parameter name.
		 *
		 * @return true|\WP_Error
		 */
		public function create_person_meta_validate( $value, $request, $param ) {
			$result = rest_validate_value_from_schema( $value, $this->create_person_meta_schema(), $param );
			if ( is_wp_error( $result ) ) {
				return $result;
			}

			if ( false === $this->validate_date( $value[ RT_Person_Meta_Box::PERSON_META_BASIC_START_YEAR_SLUG ] ) ) {
				return $this->get_error_response(
					__( 'Career start date should be in 1967-12-22 (Y-m-d) format.', 'movie-library' ),
					400
				);
			}

			if ( false === $this->validate_date( $value[ RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG ] ) ) {
				return $this->get_error_response(
					__( 'Career start date should be in 1967-12-22 (Y-m-d) format.', 'movie-library' ),
					400
				);
			}

			return true;
		}
	}
}

