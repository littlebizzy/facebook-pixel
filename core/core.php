<?php

// Subpackage namespace
namespace LittleBizzy\FacebookPixel\Core;

/**
 * Core class
 *
 * @package Facebook Pixel
 * @subpackage Core
 */
final class Core {



	// Properties
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Single class instance
	 */
	private static $instance;



	// Initialization
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Create or retrieve instance
	 */
	public static function instance($plugin = null) {

		// Check instance
		if (!isset(self::$instance))
			self::$instance = new self($plugin);

		// Done
		return self::$instance;
	}



	/**
	 * Constructor
	 */
	private function __construct($plugin) {

		// Avoid some contexts
		if ((defined('DOING_CRON') && DOING_CRON) ||
			(defined('DOING_AJAX') && DOING_AJAX) ||
			(defined('XMLRPC_REQUEST') && XMLRPC_REQUEST)) {
			return;
		}

		// Init factory
		$factory = new Factory($plugin);

		// Admin area
		if (is_admin()) {
			$factory->admin();

		// Front
		} else {
			$factory->front();
		}
	}



}