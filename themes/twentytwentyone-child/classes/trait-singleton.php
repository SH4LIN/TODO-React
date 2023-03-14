<?php
/**
 * Singleton Trait
 *
 * This file is used to create singleton trait
 *
 * @package MovieLib\includes
 */


/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Trait Singleton
 */
trait Singleton {
	/**
	 * Instance
	 *
	 * @var null
	 */
	private static $instance = null;
	/**
	 * Get Instance
	 *
	 * @return null|self
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Singleton constructor.
	 */
	private function __construct() {
		$this->init();
	}
}
