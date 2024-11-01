<?php
/**
 * Plugin Name: Simmer Private
 * Plugin URI:  https://github.com/wpsitecare/simmer-private/
 * Description: Make Simmer recipes "private" so they must be embedded in a post or page to be displayed.
 * Version:     0.1.0
 * Author:      WP Site Care
 * Author URI:  http://www.wpsitecare.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: simmer-private
 * Domain Path: /languages
 */

// Prevent direct access.
defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . 'includes/class-autoload.php';
new Simmer_Private_Autoload( __FILE__ );

add_action( 'plugins_loaded', array( simmer_private(), 'init' ), 99 );
/**
 * Access a single instance of the main plugin class.
 *
 * Plugins and themes should use this function to access plugin properties and
 * methods. It's also a simple way to check whether or not the plugin is
 * currently activated.
 *
 * @since  0.1.0
 * @access public
 * @uses   Simmer_Private_Plugin::get_instance()
 * @return object Simmer_Private_Plugin A single instance of the plugin class.
 */
function simmer_private() {
	return Simmer_Private_Plugin::get_instance( __FILE__ );
}

/**
 * Grab an instance of one of the plugin class objects.
 *
 * If you need to reference a method in one of the plugin classes, you should
 * typically do it using this function.
 *
 * Example:
 *
 * <?php simmer_private_get( 'public-scripts' )->maybe_disable(); ?>
 *
 * @since  0.1.0
 * @access public
 * @see    Simmer_Private_Factory::get()
 * @return object
 */
function simmer_private_get( $object, $name = 'canonical', $args = array() ) {
	return Simmer_Private_Factory::get( $object, $name, $args );
}

register_activation_hook( __FILE__, 'simmer_private_activate' );
/**
 * Set up roles, options and required data on plugin activation.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function simmer_private_activate() {
	simmer_private_get( 'plugin-hooks' )->activate();
}

register_deactivation_hook( __FILE__, 'simmer_private_deactivate' );
/**
 * Remove unnecessary data on plugin deactivation.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function simmer_private_deactivate() {
	simmer_private_get( 'plugin-hooks' )->deactivate();
}

register_uninstall_hook( __FILE__, 'simmer_private_uninstall' );
/**
 * Clean up all leftover roles, options, and data on plugin removal.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function simmer_private_uninstall() {
	simmer_private_get( 'plugin-hooks' )->uninstall();
}
