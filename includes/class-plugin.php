<?php
/**
 * Simmer Private main plugin class.
 *
 * @package    SimmerPrivate
 * @subpackage SimmerPrivate/Includes
 * @author     Robert Neu
 * @copyright  Copyright (c) 2015, WP Site Care
 * @license    GPL-2.0+
 * @since      0.1.0
 */

// Prevent direct access.
defined( 'ABSPATH' ) || exit;

/**
 * Main plugin class.
 */
class Simmer_Private_Plugin {
	/**
	 * Our plugin version number.
	 *
	 * @since 0.1.0
	 * @type  string
	 */
	const VERSION = '0.1.0';

	/**
	 * The main plugin file.
	 *
	 * @since 0.1.0
	 * @var   string
	 */
	private $file;

	/**
	 * The plugin's directory path with a trailing slash.
	 *
	 * @since 0.1.0
	 * @var   string
	 */
	private $dir;

	/**
	 * The plugin directory URI with a trailing slash.
	 *
	 * @since 0.1.0
	 * @var   string
	 */
	private $uri;

	/**
	 * Constructor method.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $file the path to the root plugin file.
	 * @return void
	 */
	public function __construct( $file ) {
		$this->setup_paths( $file );
	}

	/**
	 * Method for setting up the paths used throughout the plugin.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $file the path to the root plugin file.
	 * @return void
	 */
	public function setup_paths( $file ) {
		$this->file = $file;
		$this->dir  = plugin_dir_path( $file );
		$this->uri  = plugin_dir_url( $file );
	}

	/**
	 * Build and store references to all the plugin's global objects.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @return void
	 */
	protected function build() {
		Simmer_Private_Factory::get( 'admin-factory' );
		Simmer_Private_Factory::get( 'global-factory' );
	}

	/**
	 * Build and store references to all the plugin's global objects.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @return void
	 */
	protected function true_init() {
		/**
		 * Provide reliable access to the plugin's functions and methods before
		 * the plugin's global classes are initialized.
		 *
		 * This is meant for plugins and themes to execute code which depends
		 * on Simmer Private.
		 *
		 * @since  0.1.0
		 * @access public
		 * @param  string $version the current plugin version
		 */
		do_action( 'simmer_private_before_init', self::VERSION );

		$this->build();

		/**
		 * Provide reliable access to the plugin's functions and methods after
		 * the plugin's global classes are initialized.
		 *
		 * This is meant for plugins and themes to execute code which depends
		 * on Simmer Private.
		 *
		 * @since  0.1.0
		 * @access public
		 * @param  string $version the current plugin version
		 */
		do_action( 'simmer_private_after_init', self::VERSION );
	}

	/**
	 * Fire a notice explaining why the plugin has not been loaded.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @return void
	 */
	protected function compat_init() {
		add_action( 'admin_notices', array( $this, 'simmer_disabled' ) );
	}

	/**
	 * Load the plugin if Simmer is installed and activated.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function init() {
		if ( class_exists( 'Simmer', false ) ) {
			$this->true_init();
		} else {
			$this->compat_init();
		}
	}

	/**
	 * Output markup for a plugin notice.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @return void
	 */
	public function simmer_disabled() {
		simmer_private_get( 'language-loader' )->load();

		$options = simmer_private_get( 'options' );
		if ( $options->get_option( 'rewrites_flushed' ) ) {
			$options->set_option( 'rewrites_flushed', false );
		}

		printf( '<div class="error"><p>%s</p></div>',
			esc_html__( 'Simmer Private requires the Simmer plugin to be installed.', 'simmer-private' )
		);
	}

	/**
	 * Getter method for reading the protected version variable.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return string the plugin's current version number.
	 */
	public function get_version() {
		return self::VERSION;
	}

	/**
	 * Return the path to the main plugin file.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return string
	 */
	public function get_file() {
		return $this->file;
	}

	/**
	 * Return the path to the plugin directory with a trailing slash.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $path a path to append to the root plugin directory.
	 * @return string the plugin's root directory with an optional path appended.
	 */
	public function get_dir( $path = '' ) {
		return $this->dir . ltrim( $path );
	}

	/**
	 * Return the URI to the plugin directory with a trailing slash.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $path a path to append to the root plugin directory.
	 * @return string the plugin's root URI with an optional path appended.
	 */
	public function get_uri( $path = '' ) {
		return $this->uri . ltrim( $path );
	}

	/**
	 * Get a single instance of the main plugin class.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $file the path to the root plugin file.
	 * @return object Simmer_Private_Plugin
	 */
	public static function get_instance( $file ) {
		static $instance;
		if ( is_null( $instance ) ) {
			$instance = new self( $file );
		}
		return $instance;
	}
}
