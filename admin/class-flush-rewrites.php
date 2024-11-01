<?php
/**
 * Build and store references to our global plugin objects.
 *
 * @package    SimmerPrivate
 * @subpackage SimmerPrivate/Admin
 * @author     Robert Neu
 * @copyright  Copyright (c) 2015, WP Site Care
 * @license    GPL-2.0+
 * @since      0.1.0
 */

defined( 'ABSPATH' ) || exit;

class Simmer_Private_Admin_Flush_Rewrites {
	/**
	 * Placeholder for our plugin options object.
	 *
	 * @since 0.1.0
	 * @var   Simmer_Private_Options
	 */
	protected $options;

	/**
	 * Set up class properties.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->options = simmer_private_get( 'options' );
	}

	/**
	 * Run required object methods.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function run() {
		$this->hooks();
	}

	/**
	 * Fire our action and filter hooks.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @return void
	 */
	protected function hooks() {
		add_action( 'admin_init', array( $this, 'maybe_flush' ) );
	}

	/**
	 * Ensure rewrites have been flushed correctly.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return bool
	 */
	public function maybe_flush() {
		// Bail if rewrites have already been flushed successfully on activation.
		if ( $this->options->get_option( 'rewrites_flushed' ) ) {
			return false;
		}

		flush_rewrite_rules();

		return $this->options->set_option( 'rewrites_flushed', true );
	}
}
