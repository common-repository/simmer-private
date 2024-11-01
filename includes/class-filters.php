<?php
/**
 * A class for filtering methods in Simmer.
 *
 * @package    SimmerPrivate
 * @subpackage SimmerPrivate/Includes
 * @author     Robert Neu
 * @copyright  Copyright (c) 2015, WP Site Care
 * @license    GPL-2.0+
 * @since      0.1.0
 */

defined( 'ABSPATH' ) || exit;

class Simmer_Private_Filters {
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
		add_filter( 'simmer_register_recipe_args',   array( $this, 'cpt_args' ), 99 );
		add_filter( 'simmer_register_category_args', array( $this, 'cat_args' ), 99 );
		add_filter( 'simmer_recipe_title',           array( $this, 'recipe_title' ), 10, 2 );
	}

	/**
	 * Filter the default Simmer recipe post type arguments.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array $args the default Simmer post type arguments.
	 * @return array $args the modified Simmer post type arguments.
	 */
	public function cpt_args( $args ) {
		$args['public']      = false;
		$args['has_archive'] = false;
		$args['rewrite']     = false;
		$args['show_ui']     = true;
		return $args;
	}

	/**
	 * Filter the default Simmer recipe category arguments.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array $args the default Simmer category arguments.
	 * @return array $args the modified Simmer category arguments.
	 */
	public function cat_args( $args ) {
		$args['public']  = false;
		$args['rewrite'] = false;
		$args['show_ui'] = true;
		return $args;
	}

	/**
	 * Filter the default Simmer recipe title to remove the permalink.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  string $title the default Simmer recipe title.
	 * @param  int    $id the ID of the post associated with the current title.
	 * @return string $title the modified Simmer recipe title.
	 */
	public function recipe_title( $title, $id ) {
		return get_the_title( $id );
	}
}
