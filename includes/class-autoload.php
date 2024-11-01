<?php
/**
 * Autoload all plugin files.
 *
 * @package    SimmerPrivate
 * @subpackage SimmerPrivate/Includes
 * @author     Robert Neu
 * @copyright  Copyright (c) 2015, WP Site Care
 * @license    GPL-2.0+
 * @since      0.1.0
 */

defined( 'ABSPATH' ) || exit;

class Simmer_Private_Autoload {
	/**
	 * Plugin prefix which can be set within themes.
	 *
	 * @since 0.1.0
	 * @var   string
	 */
	protected $dir;

	/**
	 * Set up object properties and fire required methods.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $file Absolute path to the plugin's root file.
	 * @return void
	 */
	public function __construct( $file ) {
		$this->dir = plugin_dir_path( $file );
		$this->register_autoloaders();
	}

	/**
	 * Register all plugin autoloaders.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @return void
	 */
	protected function register_autoloaders() {
		spl_autoload_register( array( $this, 'autoloader' ) );
		spl_autoload_register( array( $this, 'admin_autoloader' ) );
	}

	/**
	 * Format a class' name string to facilitate autoloading.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @param  string $class the name of the class to replace.
	 * @param  string $prefix an optional prefix to replace in the class name.
	 * @return string
	 */
	protected function format_class( $class, $prefix = '' ) {
		return strtolower( str_replace( '_', '-', str_replace( "Simmer_Private_{$prefix}", '', $class ) ) );
	}

	/**
	 * Build a path to a file.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @param  string $path the relative path to the file to be formatted.
	 * @param  string $file the slug of the file to be formatted.
	 * @return string the formatted path to a file.
	 */
	protected function build_file( $path, $file ) {
		return "{$this->dir}{$path}class-{$file}.php";
	}

	/**
	 * Require a file if it exists.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @param  string $file the path of the file to be required.
	 * @return bool true if a file is loaded, false otherwise
	 */
	protected function require_file( $file ) {
		if ( file_exists( $file ) ) {
			require_once $file;
			return true;
		}
		return false;
	}

	/**
	 * Load all plugin classes when they're instantiated.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @param  string $class the name of the class to be autoloaded.
	 * @return string Absolute path of the file to be autoloaded.
	 */
	protected function autoloader( $class ) {
		return $this->require_file(
			$this->build_file( 'includes/', $this->format_class( $class ) )
		);
	}

	/**
	 * Load all admin plugin classes when they're instantiated.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @param  string $class the name of the class to be autoloaded.
	 * @return bool|string false if not an admin class, path of the file otherwise.
	 */
	protected function admin_autoloader( $class ) {
		if ( false === strpos( $class, 'Admin' ) ) {
			return false;
		}
		return $this->require_file(
			$this->build_file( 'admin/', $this->format_class( $class, 'Admin_' ) )
		);
	}
}
