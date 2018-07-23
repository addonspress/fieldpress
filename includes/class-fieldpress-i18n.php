<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.0.1
 * @package    FieldPress
 * @subpackage fieldpress/includes
 * @author     AddonsPress <addonspress@gmail.com>
 * @link       https://addonspress.com/
 * 
 */
class FieldPress_i18n {

	/**
	 * Load the plugin text domain for translation.
	 * create language file
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'fieldpress',
			false,
			FIELDPRESS_PATH. '/languages/'
		);
	}
}