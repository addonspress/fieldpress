<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.0.1
 * @package    FieldPress
 * @subpackage FieldPress/includes
 * @author     Addons Press <addonspress@gmail.com>
 * @link       https://addonspress.com/
 */
class FieldPress {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      FieldPress_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * Main FieldPress Instance
	 *
	 * Insures that only one instance of FieldPress exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since    1.0.0
	 * @access   public
	 *
	 * @uses FieldPress::setup_globals() Setup the globals needed
	 * @uses FieldPress::load_dependencies() Include the required files
	 * @uses FieldPress::set_locale() Setup language
	 * @uses FieldPress::run() run
	 * @see bbpress()
	 * @return object
	 */
	public static function instance() {

		// Store the instance locally to avoid private static replication
		static $instance = null;

		// Only run these methods if they haven't been ran previously
		if ( null === $instance ) {
			$instance = new FieldPress;

			if ( defined( 'FIELDPRESS_VERSION' ) ) {
				$instance->version = FIELDPRESS_VERSION;
			} else {
				$instance->version = '0.0.1';
			}
			$instance->plugin_name = 'fieldpress';

			$instance->load_dependencies();
			$instance->set_locale();
			$instance->init();
			$instance->run();

		}

		// Always return the instance
		return $instance;
	}

	/**
	 * A dummy constructor to prevent FieldPress from being loaded more than once.
	 *
	 * @since    1.0.0
	 */
	private function __construct() { /* Do nothing here */ }

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - FieldPress_Loader. Orchestrates the hooks of the plugin.
	 * - FieldPress_i18n. Defines internationalization functionality.
	 * - FieldPress_Admin. Defines all hooks for the admin area.
	 * - FieldPress_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		fieldpress_load_file( 'includes/class-fieldpress-loader.php' );

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		fieldpress_load_file( 'includes/class-fieldpress-i18n.php' );

		/**
		 * The file is responsible for functions.
		 */
		fieldpress_load_file( 'includes/fieldpress-functions.php' );

		$this->loader = new FieldPress_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the FieldPress_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new FieldPress_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	function init() {

		/*Fields File*/
		fieldpress_load_file('fields/accordions.php');
		fieldpress_load_file('fields/box.php');
		fieldpress_load_file('fields/checkbox.php');
		fieldpress_load_file('fields/color.php');
		fieldpress_load_file('fields/date.php');
		fieldpress_load_file('fields/file.php');
		fieldpress_load_file('fields/gallery.php');
		fieldpress_load_file('fields/icon.php');
		fieldpress_load_file('fields/image.php');
		fieldpress_load_file('fields/map.php');
		fieldpress_load_file('fields/message.php');
		fieldpress_load_file('fields/orders.php');
		fieldpress_load_file('fields/radio.php');
		fieldpress_load_file('fields/repeater.php');
		fieldpress_load_file('fields/select.php');
		fieldpress_load_file('fields/select-image.php');
		fieldpress_load_file('fields/sortable.php');
		fieldpress_load_file('fields/switcher.php');
		fieldpress_load_file('fields/tabs.php');
		fieldpress_load_file('fields/text.php');
		fieldpress_load_file('fields/textarea.php');
		fieldpress_load_file('fields/wysiwyg.php');

		/*Framework file*/
		fieldpress_load_file('classes/fp-widget-base.php');
		fieldpress_load_file('classes/fp-menu-framework.php');
		fieldpress_load_file('classes/fp-meta-framework.php');

		/*Hooks File*/
		fieldpress_load_file('hooks/field-before.php');
		fieldpress_load_file('hooks/field-after.php');
		fieldpress_load_file('hooks/field-conditional.php');

	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.0.1
	 * @return    FieldPress_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}