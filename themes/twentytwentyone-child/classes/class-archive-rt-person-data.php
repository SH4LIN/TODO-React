<?php
/**
 * This file contains the class which provides the functionality of fetching archive rt-person data.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

require_once get_stylesheet_directory() . '/classes/trait-singleton.php';
use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Person;
use MovieLib\admin\classes\taxonomies\Person_Career;



if ( ! class_exists( 'Archive_RT_Person_Data' ) ) :

	/**
	 * This class is used to fetch the single rt person data.
	 */
	class Archive_RT_Person_Data {
		use Singleton;

		/**
		 * Archive_RT_Person_Data init function to initialize the class.
		 *
		 * @return void
		 */
		protected function init(): void {}

		/**
		 * This function is used to fetch the all person data.
		 *
		 * @param int $movie_id The current post id.
		 * @return array $hero_data The hero data for the single rt-person post.
		 */
		public function get_movie_person_archive_data( $movie_id ): array {
			$persons_details = array();

			$actors = get_post_meta( $movie_id, 'rt-movie-meta-crew-actor' );

			if ( $actors && ! empty( $actors ) && ! empty( $actors[0] ) ) {

				foreach ( $actors[0] as $actor ) {
					$person = array();

					$person['id']   = $actor['person_id'];
					$thumbnail_id   = get_post_thumbnail_id( $actor['person_id'] );
					$attachment_url = wp_get_attachment_url( $thumbnail_id );

					$person['profile_picture'] = get_stylesheet_directory_uri() . '/assets/images/placeholder.webp';

					if ( $attachment_url ) {
						$person['profile_picture'] = $attachment_url;
					}

					if ( ! empty( $actor['character_name'] ) ) {
						$character_name_html  = '<span class="st-ap-cast-crew-character-name-text">';
						$character_name_html .= '(' . $actor['character_name'] . ')';
						$character_name_html .= '</span>';
						$person['name']       = sprintf( '%1$s%2$s', $actor['person_name'], $character_name_html, );
					} else {
						$person['name'] = sprintf( '%1$s', $actor['person_name'] );
					}

					$birth_date_str       = get_post_meta( $actor['person_id'], RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG, true );
					$person['birth_date'] = '';

					if ( ! empty( $birth_date_str ) ) {
						$birth_date           = DateTime::createFromFormat( 'Y-m-d', $birth_date_str )->format( 'd F Y' );
						$born_birth_date_str  = sprintf( __( 'Born - %1$s', 'screen-time' ), $birth_date );
						$person['birth_date'] = $born_birth_date_str;
					}

					$excerpt           = get_the_excerpt( $actor['person_id'] );
					$person['excerpt'] = '';

					if ( ! empty( $excerpt ) ) {
						$person['excerpt'] = $excerpt;
					}

					$persons_details[] = $person;
				}
			}

			return $persons_details;
		}

		/**
		 * This function is used to fetch person data related to some specific movie.
		 *
		 * @param int $current_id The current post id.
		 * @return array $about_data The about data for the single rt-person post.
		 */
		public function get_person_archive_data(): array {
			$persons_details = array();
			$person_args     = array(
				'post_type'      => RT_Person::SLUG,
				'posts_per_page' => '12',
			);

			$person_query = new WP_Query( $person_args );
			$persons      = $person_query->posts;

			if ( $persons && is_array( $persons ) && count( $persons ) > 0 ) {
				foreach ( $persons as $person_data ) {
					$person = array();

					$person['id'] = $person_data->ID;

					$thumbnail_id   = get_post_thumbnail_id( $person_data->ID );
					$attachment_url = wp_get_attachment_url( $thumbnail_id );

					$person['profile_picture'] = get_stylesheet_directory_uri() . '/assets/images/placeholder.webp';

					if ( $attachment_url ) {
						$person['profile_picture'] = $attachment_url;
					}

					$person['name'] = $person_data->post_title;

					$birth_date_str       = get_post_meta( $person_data->ID, RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG, true );
					$person['birth_date'] = '';

					if ( ! empty( $birth_date_str ) ) {
						$birth_date           = DateTime::createFromFormat( 'Y-m-d', $birth_date_str )->format( 'd F Y' );
						$born_birth_date_str  = sprintf( __( 'Born - %1$s', 'screen-time' ), $birth_date );
						$person['birth_date'] = $born_birth_date_str;
					}

					$excerpt           = $person_data->post_excerpt;
					$person['excerpt'] = '';

					if ( ! empty( $excerpt ) ) {
						$person['excerpt'] = $excerpt;
					}

					$persons_details[] = $person;
				}
			}
			return $persons_details;
		}

	}

endif;

