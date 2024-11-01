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

class Simmer_Private_Admin_Factory extends Simmer_Private_Factory {
	/**
	 * A list of required admin plugin object names.
	 *
	 * @since 0.1.0
	 * @var   array
	 */
	protected $required = array(
		'admin-unregister-settings',
		'admin-flush-rewrites',
	);

	/**
	 * Constructor method.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		if ( is_admin() ) {
			$this->build_required_objects();
		}
	}
}
