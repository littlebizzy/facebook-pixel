<?php

// Subpackage namespace
namespace LittleBizzy\FacebookPixel\Core;

/**
 * Facebook Pixel - Front class
 *
 * @package Facebook Pixel
 * @subpackage Facebook Pixel Core
 */
class Front {



	// Properties
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Settings object
	 */
	private $settings;



	/**
	 * Facebook Pixel Id
	 */
	private $facebookPixelId;



	// Initialization
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Constructor
	 */
	public function __construct($plugin) {

		// Load current settings
		$settings = @json_decode(''.get_option($plugin->prefix.'_settings'), true);
		if (empty($settings) || !is_array($settings) || empty($settings['facebook-pixel-id']))
			return;

		// Copy data
		$this->settings = $settings;

		// Init hook
		add_action('init', [&$this, 'init']);
	}



	// WP Hooks
	// ---------------------------------------------------------------------------------------------------



	/**
	 * WP Users module started
	 */
	public function init() {

		// Decide if track logged users
		if (empty($this->settings['track-logged']) || 'on' != $this->settings['track-logged']) {
			$user = wp_get_current_user();
			if (!empty($user->ID))
				return;
		}

		// Footer hook
		$this->facebookPixelId = $this->settings['facebook-pixel-id'];
		add_action('wp_footer', [$this, 'code'], PHP_INT_MAX);
	}



	/**
	 * Show the Facebook Pixel code
	 */
	public function code() {
		echo "
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '".esc_attr($this->facebookPixelId)."');
  fbq('track', 'PageView');
</script>
<noscript>".'<img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id='.esc_attr($this->facebookPixelId).'&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->'."\n";
	}



}