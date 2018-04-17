<?php

/**
 * Facebook Pixel - Admin class
 *
 * @package Facebook Pixel
 * @subpackage Facebook Pixel Admin
 */
class Admin {



	// Properties
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Object plugin
	 */
	private $plugin;



	// Initialization
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Constructor
	 */
	public function __construct($plugin) {

		// Set properties
		$this->plugin = $plugin;

		// Admin menu hook
		add_action('admin_menu', array(&$this, 'admin_menu'));
	}



	// Menus & Custom pages
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Admin menu
	 */
	public function admin_menu() {
		add_submenu_page('options-general.php', 'Facebook Pixel', 'Facebook Pixel', 'manage_options', 'facebook-pixel', [&$this, 'admin_page']);
	}



	/**
	 * Admin page
	 */
	public function admin_page() {

		// Check form submit
		if (isset($_POST[$this->plugin->prefix.'-nonce'])) {

			// Check valid nonce
			if (!wp_verify_nonce($_POST[$this->plugin->prefix.'-nonce'], $this->plugin->file)) {
				$error = 'Invalid security code, please try to submit the form again.';

			// Valid
			} else {

				// Initialize
				$settings = array(
					'facebook-pixel-id' => trim($_POST['tx-tracking-code']),
					'track-logged' 		=> (empty($_POST['ck-track-logged']) || 'on' != $_POST['ck-track-logged'])? '' : 'on',
				);

				// Save data
				update_option($this->plugin->prefix.'_settings', @json_encode($settings));

				// Check missing tracking code
				if (empty($settings['facebook-pixel-id']))
					$warning = 'No Facebook Pixel Id provided';

				// Done
				$success = true;
			}
		}

		// Load current settings
		$settings = @json_decode(''.get_option('fbkpxl_settings'), true);
		if (empty($settings) || !is_array($settings))
			$settings = [];

		?><div class="wrap">

			<h1>Facebook Pixel</h1>

			<form method="post" style="padding-top: 5px;">

				<?php if (isset($success)) : ?><div class="notice notice-success"><p>Data saved successfully. Please <strong>clear your cache</strong> if you are using a caching plugin.</p></div><?php endif; ?>

				<?php if (isset($error)) : ?><div class="notice notice-error"><p><?php echo $error; ?></p></div><?php endif; ?>

				<?php if (isset($warning)) : ?><div class="notice notice-warning"><p><?php echo $warning; ?></p></div><?php endif; ?>

				<input type="hidden" name="<?php echo $this->plugin->prefix; ?>-nonce" value="<?php echo wp_create_nonce($this->plugin->file); ?>" />

				<p style="margin-bottom: 25px;"><label for="tx-tracking-code" style="display: block; float: left; width: 200px; padding-top: 3px;"><strong style="font-size: 1.1em;">GA Tracking Code</strong></label><input type="text" name="tx-tracking-code" id="tx-tracking-code" value="<?php echo empty($settings['facebook-pixel-id'])? '' : esc_attr($settings['facebook-pixel-id']); ?>" placeholder="Your Facebook Pixel Id" /></p>

				<p style="margin-bottom: 35px;"><label for="ck-track-logged" style="display: block; float: left; width: 200px;"><strong style="font-size: 1.1em;">Track logged in users</strong></label><input type="checkbox" name="ck-track-logged" id="ck-track-logged" value="on" <?php echo (!empty($settings['track-logged']) && 'on' == $settings['track-logged'])? 'checked' : ''; ?> /></p>

				<p><input type="submit" class="button button-primary" value="Save settings" /></p>

			</form>

		</div><?php
	}



}