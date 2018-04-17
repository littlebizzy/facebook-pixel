<?php
/*
Plugin Name: Facebook Pixel
Plugin URI: https://www.littlebizzy.com/plugins/facebook-pixel
Description: Inserts the Facebook Pixel site-wide just above the closing body tag to ensure fastest performance and to avoid conflicting with any other scripts.
Version: 1.0.0
Author: LittleBizzy
Author URI: https://www.littlebizzy.com
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: FBKPXL
*/

// Plugin namespace
namespace LittleBizzy\FacebookPixel;

// Block direct calls
if (!function_exists('add_action'))
	die;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'fbkpxl';
const VERSION = '1.0.0';

// Loader
require_once dirname(FILE).'/helpers/loader.php';

// Run the main class
Helpers\Runner::start('Core\Core', 'instance');