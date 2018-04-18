<?php

// Subpackage namespace
namespace LittleBizzy\FacebookPixel\Core;

// Aliased namespaces
use \LittleBizzy\FacebookPixel\Admin;
use \LittleBizzy\FacebookPixel\Helpers;

/**
 * Object Factory class
 *
 * @package Facebook Pixel
 * @subpackage Core
 */
class Factory extends Helpers\Factory {



	/**
	 * Admin object
	 */
	protected function createAdmin() {
		return new Admin\Admin($this->plugin);
	}



	/**
	 * Front object
	 */
	protected function createFront() {
		return new Front($this->plugin);
	}



}