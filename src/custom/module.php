<?php
/**
 * Custom Module Handler - bootstrap file for the module
 *
 * @package     Deftly\Module\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/
 * @license     GNU General Public License 2.0+
 *
 */
namespace Deftly\Module\Custom;

// REMEMBER TO REDEFINE INTO NEW CONTEXT WHEN MODULE IS MOVED
define( 'CUSTOM_MODULE_TEXT_DOMAIN', COLLAPSIBLE_CONTENT_TEXT_DOMAIN );
define( 'CUSTOM_MODULE_DIR', __DIR__ );

/**
 * Autoload Module Files
 *
 * @since   0.0.1
 *
 * @return  void
 */
function autoload() {
	$files = [
		'taxonomy.php',
		'post-type.php',
	];

	foreach( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}
autoload();

/**
 * Function to register other plugins with the Custom Module.
 *
 * @since 0.0.1
 *
 * @param   $plugin
 *
 * @return  void
 */
function register_plugin_with_custom_module_rewrite_deletes( $plugin ) {
	register_activation_hook( $plugin, __NAMESPACE__ . '\delete_rewrite_rules_upon_plugin_state_change');
	register_deactivation_hook( $plugin, __NAMESPACE__ . '\delete_rewrite_rules_upon_plugin_state_change');
	register_uninstall_hook( $plugin, __NAMESPACE__ . '\delete_rewrite_rules_upon_plugin_state_change');
}
/**
 * Delete the rewrite rules upon a state change of the plugin containing the module
 * 1. Activation
 * 2. Deactivation
 * 3. Uninstall
 *
 * @since   0.0.1
 *
 * @return  void
 */
function delete_rewrite_rules_upon_plugin_state_change() {
	delete_option( 'rewrite_rules' );
}
