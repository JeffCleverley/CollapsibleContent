<?php
/**
 * FAQ module handler
 *
 * @package     Deftly\Module\FAQ
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\Module\FAQ;

// REMEMBER TO REDEFINE INTO NEW CONTEXT WHEN MODULE IS MOVED
define( 'FAQ_MODULE_TEXT_DOMAIN', COLLAPSIBLE_CONTENT_TEXT_DOMAIN );
define( 'FAQ_MODULE_DIR', __DIR__ );

/**
 * Autoload Module Files
 *
 * @since   0.0.1
 *
 * @return  void
 */
function autoload() {
	$files = [
  	    'custom/taxonomy.php',
		'custom/post-type.php',
		'shortcode/shortcode.php',
		'templates/helpers.php',
	];

	foreach( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}
autoload();

register_activation_hook( COLLAPSIBLE_CONTENT_PLUGIN, __NAMESPACE__ . '\flush_module_rewrite_rules');
/**
 * Initialize the rewrites for the new custom post type upon module activation.
 *
 * @since   0.0.1
 *
 * @return  void
 */
function flush_module_rewrite_rules() {
	Custom\register_custom_post_types();
	Custom\register_custom_taxonomy();
	flush_rewrite_rules();
}

register_deactivation_hook( COLLAPSIBLE_CONTENT_PLUGIN, __NAMESPACE__ . '\delete_module_rewrite_rules');
/**
 * Cleanup
 * Flush the rewrites for the new custom post type upon module deactivation.
 *
 * @since   0.0.1
 *
 * @return  void
 */
function delete_module_rewrite_rules() {
	delete_option( 'rewrite_rules' );
}

register_uninstall_hook( COLLAPSIBLE_CONTENT_PLUGIN, __NAMESPACE__ . '\uninstall_module');
/**
 * Cleanup
 * Flush the rewrites for the new custom post type upon module uninstall.
 *
 * @since   0.0.1
 *
 * @return  void
 */
function uninstall_module() {
	delete_option( 'rewrite_rules' );
}