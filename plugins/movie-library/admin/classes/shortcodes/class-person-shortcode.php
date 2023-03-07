<?php
/**
 * This file is used to create person shortcode.
 *
 * @package MovieLib\admin\classes\shortcodes
 */

namespace MovieLib\admin\classes\shortcodes;

use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\taxonomies\Person_Career;
use MovieLib\includes\Singleton;
use WP_Query;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\shortcodes\Person_Shortcode' ) ) {

	/**
	 * This class is used to create person shortcode.
	 */
	class Person_Shortcode {

		use Singleton;

		/**
		 * Person_Shortcode init method.
		 *
		 * @return void
		 */
		protected function init(): void {

			add_action( 'init', array( $this, 'register' ) );

		}

		/**
		 * This function is used to register person shortcode.
		 *
		 * @return void
		 */
		public function register(): void {

			add_shortcode( 'person', array( $this, 'movie_library_person_shortcode' ) );

		}

		/**
		 * This function is callback function for the person shortcode.
		 * It will be called when the shortcode is used in the page.
		 * It will display the list of people.
		 *
		 * @param array  $attributes attributes from the shortcode.
		 * @param string $content content from the shortcode.
		 * @param string $tag shortcode name.
		 *
		 * @return string|false
		 */
		public function movie_library_person_shortcode( $attributes = array(), $content = null, $tag = '' ) {

			$attributes = array_change_key_case( (array) $attributes );

			$attributes = shortcode_atts(
				array(
					'career' => '',
				),
				$attributes,
				$tag
			);

			$search_query = array();

			if ( ! empty( $attributes['career'] ) ) {

				$terms          = sanitize_text_field( $attributes['career'] );
				$search_query[] = $this->get_search_query( $terms, Person_Career::SLUG );

			}

			if ( ! empty( $search_query ) ) {

				if ( count( $search_query ) > 1 ) {

					$search_query['relation'] = 'AND';

				}

				$query = new WP_Query(
					array(
						'post_type' => RT_Person::SLUG,
						'tax_query' => $search_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					)
				);

			} else {

				$query = new WP_Query(
					array(
						'post_type' => RT_Person::SLUG,
					)
				);

			}

			$people_details = array();

			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) {

					$person_details = array();
					$query->the_post();
					$person_id              = get_the_ID();
					$person_name            = get_the_title();
					$person_details['Name'] = $person_name;

					if ( has_post_thumbnail( $person_id ) ) {

						$person_poster                     =
							wp_get_attachment_image_src( get_post_thumbnail_id( $person_id ), 'full' );
						$person_poster                     = $person_poster[0];
						$person_details['Profile Picture'] = $person_poster;

					} else {

						$person_details['Profile Picture'] =
							'https://via.placeholder.com/500';

					}

					$person_career_details = get_the_terms( $person_id, Person_Career::SLUG );

					if ( ! empty( $person_career_details ) ) {

						if ( is_array( $person_career_details ) ) {

							$careers = array();

							foreach ( $person_career_details as $value ) {

								$careers[] = $value->name;

							}

							$person_details['Career'] = implode( ', ', $careers );

						} else {

							$person_details['Career'] = $person_career_details->title;

						}
					}

					$people_details[] = $person_details;

				}
			} else {

				return $this->show_no_people_found_message();

			}

			wp_reset_postdata();
			ob_start();

			?>

			<div class="movie-list-container">

				<?php $this->display_people( $people_details ); ?>

			</div>

			<?php

			return ob_get_clean();

		}

		/**
		 * This function is used to provide the HTML for the people list.
		 *
		 * @param array $people_details People details.
		 */
		private function display_people( array $people_details ): void {

			foreach ( $people_details as $person_detail ) {

				?>

				<div class="movie-list-item">

					<div class="movie-list-item-image">

						<img class="movie-image"
							src="<?php echo esc_url( $person_detail['Profile Picture'] ); ?>"
							alt="<?php echo esc_attr( $person_detail['Name'] ); ?>">

					</div>

					<div class="movie-list-item-details">

						<div class="movie-list-item-title">

							<?php

							// translators: %1$s is person name.
							printf( esc_html__( 'Name: %1$s', 'movie-library' ), esc_html( $person_detail['Name'] ) );

							?>

						</div>

						<?php if ( isset( $person_detail['Career'] ) ) : ?>

							<div class="movie-list-item-director">

								<?php

								// translators: %1$s is the career of person.
								printf( esc_html__( 'Career: %1$s', 'movie-library' ), esc_html( $person_detail['Career'] ) );

								?>

							</div>

						<?php endif; ?>

					</div>

				</div>

				<?php

			}

		}

		/**
		 * This function will display the message when no people are found.
		 *
		 * @return string|false
		 */
		private function show_no_people_found_message() {

			ob_start();

			?>

			<p>

				<?php esc_html_e( 'No people found.', 'movie-library' ); ?>

			</p>

			<?php

			return ob_get_clean();

		}

		/**
		 * This function is used to return the search query for the taxonomy.
		 *
		 * @param array|string $terms    Terms.
		 * @param string       $taxonomy Taxonomy.
		 * @return array
		 */
		private function get_search_query( $terms, $taxonomy ): array {

			return array(
				'relation' => 'OR',
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $terms,
				),
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $terms,
				),
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'name',
					'terms'    => $terms,
				),
			);

		}
	}
}
