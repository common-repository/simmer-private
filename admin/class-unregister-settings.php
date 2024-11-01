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

class Simmer_Private_Admin_Unregister_Settings {
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
		add_action( 'simmer_register_settings', array( $this, 'unregister' ) );
	}

	/**
	 * Unregister settings sections for Simmer permalinks.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @global $wp_settings_sections
	 * @return void
	 */
	protected function unregister_sections() {
		global $wp_settings_sections;

		if ( is_array( $wp_settings_sections['simmer_advanced'] ) ) {
			unset( $wp_settings_sections['simmer_advanced']['simmer_permalinks'] );
		}
	}

	/**
	 * Unregister settings fields for Simmer permalinks.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @global $wp_settings_fields
	 * @return void
	 */
	protected function unregister_fields() {
		global $wp_settings_fields;

		$fields = $wp_settings_fields['simmer_advanced'];

		if ( is_array( $fields ) ) {
			foreach ( $fields as $key => $value ) {
				if ( 'simmer_permalinks' === $key ) {
					unset( $fields[ $key ] );
				}
			}
		}
	}

	/**
	 * Unregister settings for Simmer permalinks.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @global $wp_settings_fields
	 * @return void
	 */
	protected function unregister_settings() {
		unregister_setting( 'simmer_advanced', 'simmer_archive_base',  'esc_attr' );
		unregister_setting( 'simmer_advanced', 'simmer_recipe_base',   'esc_attr' );
		unregister_setting( 'simmer_advanced', 'simmer_category_base', 'esc_attr' );
	}

	/**
	 * Unregister all settings for Simmer permalinks.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function unregister() {
		$this->unregister_sections();
		$this->unregister_fields();
		$this->unregister_settings();
	}
}
