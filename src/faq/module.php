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

/**
 * Autoload Module Files
 *
 * @since   0.0.1
 *
 * @return  void
 */
function autoload() {
	$files = [
		'custom/post-type.php',
		'custom/taxonomy.php',
		'shortcode/shortcode.php',
	];

	foreach( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}
autoload();

register_activation_hook( COLLAPSIBLE_CONTENT_PLUGIN, __NAMESPACE__ . '\flush_module_rewrite_rules');
/**
 * Initialize the rewrites for the new custom post type upon module activation
 *
 * @since   0.0.1
 *
 * @return  void
 */
function flush_module_rewrite_rules() {
	Custom\register_custom_post_types();
	flush_rewrite_rules();
}
/**
 * Flush the rewrites for the new custom post type upon module deactivation
 *
 * @since   0.0.1
 *
 * @return  void
 */
register_deactivation_hook( COLLAPSIBLE_CONTENT_PLUGIN, __NAMESPACE__ . '\delete_module_rewrite_rules');
function delete_module_rewrite_rules() {
	delete_option( 'rewrite_rules' );
}