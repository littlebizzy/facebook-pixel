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



	/**
	 * Plugin object
	 */
	private $plugin;



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

		// Copy plugin object
		$this->plugin = $plugin;

		// Init factory
		$this->plugin->factory = new Factory($plugin);

		// Registrar handler object
		$this->plugin->factory->registrar->setHandler($this);

		// Admin area
		if (is_admin()) {
			$this->plugin->factory->admin();

		// Front
		} else {
			$this->plugin->factory->front();
		}
	}



	/**
	 * On plugin uninstall
	 */
	public function onUninstall() {
		delete_option($this->plugin->prefix.'_settings');
	}



}