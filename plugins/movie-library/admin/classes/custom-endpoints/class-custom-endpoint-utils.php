<?php
/**
 * This file provides a trait that contains the common methods for the custom endpoints.
 *
 * @package MovieLib\admin\classes\custom-endpoints
 */

namespace MovieLib\admin\classes\custom_endpoints;

use DateTime;
use WP_Error;


/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! trait_exists( 'MovieLib\admin\classes\custom_endpoints\Custom_Endpoints_Utils' ) ) :

	/**
	 * This trait contains the common methods for the custom endpoints.
	 */
	trait Custom_Endpoint_Utils {

		/**
		 * This function provides the schema to get post schema. (post means movie and person)
		 *
		 * @return array
		 */
		public function get_posts_request_schema() {
			return array(
				'per_page' => array(
					'default'           => 10,
					'type'              => 'integer',
					'sanitize_callback' => array( $this, 'mlb_sanitize' ),
					'validate_callback' => function( $value ) {
						return is_numeric( $value );
					},
				),
				'page'     => array(
					'default'           => 1,
					'type'              => 'integer',
					'sanitize_callback' => array( $this, 'mlb_sanitize' ),
					'validate_callback' => function( $value ) {
						return is_numeric( $value );
					},
				),
				'order'    => array(
					'default'           => 'DESC',
					'type'              => 'string',
					'sanitize_callback' => array( $this, 'mlb_sanitize' ),
					'validate_callback' => function( $value ) {
						return in_array( $value, array( 'ASC', 'DESC' ), true );
					},
				),
				'orderby'  => array(
					'default'           => 'date',
					'type'              => 'string',
					// Only Sanitizing the value.
					'sanitize_callback' => array( $this, 'mlb_sanitize' ),
					'validate_callback' => function( $value ) {
						return is_string( $value );
					},
				),
				'ids'      => array(
					'type'  => 'array',
					'items' => array(
						'type'              => 'integer',
						'sanitize_callback' => array( $this, 'mlb_sanitize' ),
						'validate_callback' => function( $value ) {
							return is_numeric( $value );
						},
					),

				),
			);
		}

		/**
		 * This function gives the schema for the movie taxonomy.
		 *
		 * @return array
		 */
		public function get_post_taxonomy_schema(): array {
			return array(
				'type'              => 'object',
				'validate_callback' => array( $this, 'create_post_taxonomies_validate' ),
				'sanitize_callback' => array( $this, 'mlb_sanitize' ),
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
		public function mlb_sanitize( $value, $request, $param ) {
			return $this->mlb_sanitize_text_field_recursive( $value );
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

		/**
		 * This function is used to validate taxonomies to create movie.
		 *
		 * @param array            $value Value to validate.
		 * @param \WP_REST_Request $request Request object.
		 * @param string           $param Parameter name.
		 * @return bool|\WP_Error
		 */
		public function create_post_taxonomies_validate( $value, $request, $param ) {
			$result = rest_validate_value_from_schema( $value, $this->get_post_taxonomy_schema(), $param );
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
							sprintf( __( '%1$s term-id does not exist in %2$s', 'movie-library' ), $value, $key ),
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
		 * This function is used to get the 401 error response.
		 *
		 * @param string $message Error message.
		 * @param int    $status_code Status code.
		 *
		 * @return WP_Error
		 */
		public function get_error_response( $message, $status_code ): WP_Error {
			return new WP_Error(
				$status_code,
				$message,
				array(
					'status' => $status_code,
				)
			);
		}

		/**
		 * This function is used to validate the date.
		 *
		 * @param string $date Date to validate.
		 * @param string $format Date format.
		 *
		 * @return false|\DateTime
		 */
		public function validate_date( $date, $format = 'Y-m-d' ) {
			$date_format = 'Y-m-d';

			return DateTime::createFromFormat( $date_format, $date );
		}
	}
endif;
