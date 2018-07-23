<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 *
 * @link              https://addonspress.com/
 * @since             0.0.1
 * @package           FieldPress
 *
 * @wordpress-plugin
 * Plugin Name:       FieldPress
 * Plugin URI:        https://addonspress.com/item/fieldpress-framework/
 * Description:       FieldPress is WordPress Back-end builder framework to create advanced back-end section like meta-box,
 *                    widget and menu options in very short time
 * Version:           0.0.1
 * Author:            AddonsPress
 * Author URI:        https://addonspress.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fieldpress
 * Domain Path:       /languages
 */

defined('FIELDPRESS_VERSION') or define('FIELDPRESS_VERSION', '0.0.1');
defined('FIELDPRESS_PATH') or define('FIELDPRESS_PATH', plugin_dir_path( __FILE__ ));
defined('FIELDPRESS_URL') or define('FIELDPRESS_URL', plugin_dir_url( __FILE__ ));
defined('FIELDPRESS_SCRIPT_PREFIX') or define('FIELDPRESS_SCRIPT_PREFIX', ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '' );
defined('FIELDPRESS_TEMPLATE_PATH') or define('FIELDPRESS_TEMPLATE_PATH', 'fieldpress/');

/**
 * Possibilities to Load and override FieldPress
 * @param  $file_path
 * @return string
 */

function fieldpress_load_file( $file_path = '' ) {

	$fp_file = '';
	$template_path = FIELDPRESS_TEMPLATE_PATH;

	/**
	 * Look in yourtheme and child theme to override 
	 * @theme   	: yourtheme/fieldpress/$file_path
	 * @childtheme 	: childtheme/fieldpress/$file_path
	 */
	if ( $file_path ) {
		if ( file_exists(get_stylesheet_directory() . '/' .$template_path. $file_path)) {
			$fp_file = get_stylesheet_directory() . '/' . $template_path.$file_path;
		} elseif ( file_exists(get_template_directory() . '/' .$template_path. $file_path) ) {
			$fp_file = get_template_directory() . '/' . $template_path. $file_path;
		}
	}
	
	/**
	 * Look in pluign directory 
	 * @pluign   	: yourpluign/fieldpress/$file_path
	 */
	if ( ! $fp_file && $file_path && file_exists( FIELDPRESS_PATH . "/$file_path" ) ) {
		$fp_file = FIELDPRESS_PATH . "/$file_path";
	}

	/**
	 * Allow 3rd party plugins to filter template file from their plugin.
	 * 
	*/
	$fp_file = apply_filters( 'fieldpress_load_file', $fp_file, $file_path);
	
	if ( $fp_file ) {
		load_template( $fp_file, false );
	}
	return $fp_file;
}

/**
 * The core plugin class that is used to define internationalization and all the functions of plugin.
 */
fieldpress_load_file( 'includes/class-fieldpress.php' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fieldpress() {

	$plugin = new FieldPress();
	$plugin->run();
}
run_fieldpress();

/**
 * Example file, it gives general idea how the fieldPress actually works.
 * @delete this example files on production process.
 */
fieldpress_load_file('example/widget.php');
fieldpress_load_file('example/menu.php');
fieldpress_load_file('example/meta.php');