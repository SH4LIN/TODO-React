<?php
/**
 * This class contains the wrapper functions to perform CRUD operation on the wp_moviemeta and wp_personxmeta table.
 *
 * @package MovieLib\includes
 */

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'add_movie_meta' ) ) {

	/**
	 * This function is wrapper function to add the movie meta to the database.
	 * It will call the add_metadata function from the wp-includes/meta.php file.
	 *
	 * @param int    $movie_id   Movie ID.
	 * @param string $meta_key   Metadata name.
	 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
	 * @param bool   $unique     Optional. Whether the same key should not be added.
	 *                           Default false.
	 * @return int|false Meta ID on success, false on failure.
	 */
	function add_movie_meta( $movie_id, $meta_key, $meta_value, $unique = false ) {
		// Make sure meta is added to the post, not a revision.
		$the_post = wp_is_post_revision( $movie_id );
		if ( $the_post ) {
			$movie_id = $the_post;
		}

		return add_metadata( 'movie', $movie_id, $meta_key, $meta_value, $unique );
	}
}

if ( ! function_exists( 'get_movie_meta' ) ) {
	/**
	 * This function is wrapper function to get the movie meta from the database.
	 * It will call the get_metadata function from the wp-includes/meta.php file.
	 *
	 * @param int    $movie_id Movie ID.
	 * @param string $key      Optional. The meta key to retrieve. By default,
	 *                         returns data for all keys. Default empty.
	 * @param bool   $single   Optional. Whether to return a single value.
	 *                         This parameter has no effect if `$key` is not specified.
	 *                         Default false.
	 * @return mixed An array of values if `$single` is false.
	 *               The value of the meta field if `$single` is true.
	 *               False for an invalid `$post_id` (non-numeric, zero, or negative value).
	 *               An empty string if a valid but non-existing post ID is passed.
	 */
	function get_movie_meta( $movie_id, $key = '', $single = false ) {
		$data = get_metadata( 'movie', $movie_id, $key, $single );
		if ( empty( $data ) ) {
			$data = get_post_meta( $movie_id, $key, $single );
		}
		return $data;
	}
}

if ( ! function_exists( 'update_movie_meta' ) ) {
	/**
	 * This function is wrapper function to update the movie meta to the database.
	 * It will call the update_metadata function from the wp-includes/meta.php file.
	 *
	 * @param int    $movie_id   Movie ID.
	 * @param string $meta_key   Metadata key.
	 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
	 * @param mixed  $prev_value Optional. Previous value to check before updating.
	 *                           If specified, only update existing metadata entries with
	 *                           this value. Otherwise, update all entries. Default empty.
	 *
	 * @return int|bool Meta ID if the key didn't exist, true on successful update,
	 *                  false on failure or if the value passed to the function
	 *                  is the same as the one that is already in the database.
	 */
	function update_movie_meta( $movie_id, $meta_key, $meta_value, $prev_value = '' ) {
		// Make sure meta is updated for the post, not for a revision.
		$the_post = wp_is_post_revision( $movie_id );
		if ( $the_post ) {
			$movie_id = $the_post;
		}

		$movie_data = get_post_meta( $movie_id, $meta_key );
		if ( ! empty( $movie_data ) ) {
			delete_post_meta( $movie_id, $meta_key );
		}

		return update_metadata( 'movie', $movie_id, $meta_key, $meta_value, $prev_value );
	}
}

if ( ! function_exists( 'delete_movie_meta' ) ) {
	/**
	 * This function is wrapper function to delete the movie meta from the database.
	 * It will call the delete_metadata function from the wp-includes/meta.php file.
	 *
	 * @param int    $movie_id   Movie ID.
	 * @param string $meta_key   Metadata name.
	 * @param mixed  $meta_value Optional. Metadata value. If provided,
	 *                           rows will only be removed that match the value.
	 *                           Must be serializable if non-scalar. Default empty.
	 * @return bool True on success, false on failure.
	 */
	function delete_movie_meta( $movie_id, $meta_key, $meta_value = '' ) {
		// Make sure meta is deleted from the post, not from a revision.
		$the_post = wp_is_post_revision( $movie_id );
		if ( $the_post ) {
			$movie_id = $the_post;
		}

		delete_post_meta( $movie_id, $meta_key, $meta_value );
		return delete_metadata( 'movie', $movie_id, $meta_key, $meta_value );
	}
}

if ( ! function_exists( 'add_person_meta' ) ) {

	/**
	 * This function is wrapper function to add the person meta to the database.
	 * It will call the add_metadata function from the wp-includes/meta.php file.
	 *
	 * @param int    $person_id  Person ID.
	 * @param string $meta_key   Metadata name.
	 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
	 * @param bool   $unique     Optional. Whether the same key should not be added.
	 *                           Default false.
	 * @return int|false Meta ID on success, false on failure.
	 */
	function add_person_meta( $person_id, $meta_key, $meta_value, $unique = false ) {
		// Make sure meta is added to the post, not a revision.
		$the_post = wp_is_post_revision( $person_id );
		if ( $the_post ) {
			$person_id = $the_post;
		}

		return add_metadata( 'person', $person_id, $meta_key, $meta_value, $unique );
	}
}

if ( ! function_exists( 'get_person_meta' ) ) {
	/**
	 * This function is wrapper function to get the person meta from the database.
	 * It will call the get_metadata function from the wp-includes/meta.php file.
	 *
	 * @param int    $person_id Person ID.
	 * @param string $key       Optional. The meta key to retrieve. By default,
	 *                          returns data for all keys. Default empty.
	 * @param bool   $single    Optional. Whether to return a single value.
	 *                          This parameter has no effect if `$key` is not specified.
	 *                          Default false.
	 * @return mixed An array of values if `$single` is false.
	 *               The value of the meta field if `$single` is true.
	 *               False for an invalid `$post_id` (non-numeric, zero, or negative value).
	 *               An empty string if a valid but non-existing post ID is passed.
	 */
	function get_person_meta( $person_id, $key = '', $single = false ) {
		$data = get_metadata( 'person', $person_id, $key, $single );
		if ( empty( $data ) ) {
			$data = get_post_meta( $person_id, $key, $single );
		}
		return $data;
	}
}

if ( ! function_exists( 'update_person_meta' ) ) {
	/**
	 * This function is wrapper function to update the person meta to the database.
	 * It will call the update_metadata function from the wp-includes/meta.php file.
	 *
	 * @param int    $person_id  Person ID.
	 * @param string $meta_key   Metadata key.
	 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
	 * @param mixed  $prev_value Optional. Previous value to check before updating.
	 *                           If specified, only update existing metadata entries with
	 *                           this value. Otherwise, update all entries. Default empty.
	 *
	 * @return int|bool Meta ID if the key didn't exist, true on successful update,
	 *                  false on failure or if the value passed to the function
	 *                  is the same as the one that is already in the database.
	 */
	function update_person_meta( $person_id, $meta_key, $meta_value, $prev_value = '' ) {
		// Make sure meta is updated for the post, not for a revision.
		$the_post = wp_is_post_revision( $person_id );
		if ( $the_post ) {
			$person_id = $the_post;
		}

		$movie_data = get_post_meta( $person_id, $meta_key );
		if ( ! empty( $movie_data ) ) {
			delete_post_meta( $person_id, $meta_key );
		}

		return update_metadata( 'person', $person_id, $meta_key, $meta_value, $prev_value );
	}
}

if ( ! function_exists( 'delete_person_meta' ) ) {
	/**
	 * This function is wrapper function to delete the person meta from the database.
	 * It will call the delete_metadata function from the wp-includes/meta.php file.
	 *
	 * @param int    $person_id  Person ID.
	 * @param string $meta_key   Metadata name.
	 * @param mixed  $meta_value Optional. Metadata value. If provided,
	 *                           rows will only be removed that match the value.
	 *                           Must be serializable if non-scalar. Default empty.
	 * @return bool True on success, false on failure.
	 */
	function delete_person_meta( $person_id, $meta_key, $meta_value = '' ) {
		// Make sure meta is deleted from the post, not from a revision.
		$the_post = wp_is_post_revision( $person_id );
		if ( $the_post ) {
			$person_id = $the_post;
		}

		delete_post_meta( $person_id, $meta_key, $meta_value );
		return delete_metadata( 'person', $person_id, $meta_key, $meta_value );
	}
}
