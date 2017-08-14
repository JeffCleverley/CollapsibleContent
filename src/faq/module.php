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

use Deftly\Module\Custom as CustomModule;

// REMEMBER TO REDEFINE INTO NEW CONTEXT WHEN MODULE IS MOVED
define( 'FAQ_MODULE_TEXT_DOMAIN', COLLAPSIBLE_CONTENT_TEXT_DOMAIN );
define( 'FAQ_MODULE_DIR', __DIR__ );

add_filter( 'add_custom_post_type_runtime_config', __NAMESPACE__ . '\register_faq_custom_configs' );
add_filter( 'add_custom_taxonomy_runtime_config', __NAMESPACE__ . '\register_faq_custom_configs' );
/**
 * Register the custom contents from a config file.
 * Custom Post Types
 * Custom Taxonomies
 *
 * @since   1.0.0
 *
 * @param   array   $configs    Array of all the custom post type configurations for this module.
 *
 * @return  array   $configs
 */
function register_faq_custom_configs( array $configs ) {
	$doing_post_type = current_filter() == 'add_custom_post_type_runtime_config';
	$filename = $doing_post_type ? 'post-type' : 'taxonomy';
	$configurations = include( FAQ_MODULE_DIR . '/config/' . $filename .'.php');

	if ( ! $configurations ) {
		return $configs;
	}

	foreach ( $configurations as $config ) {
		$configs[ $config['labels']['slug'] ] = $config;
	}

	return $configs;
}

/**
 * Autoload Module Files
 *
 * @since   0.0.1
 *
 * @return  void
 */
function autoload() {
	$files = [
		'shortcode/shortcode.php',
		'templates/helpers.php',
	];

	foreach( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\setup_module' );
/**
 * Setup the plugin
 *
 * @since   0.0.1
 *
 * @return  void
 */
function setup_module() {
	CustomModule\register_shortcode( FAQ_MODULE_DIR . '/config/shortcode.php' );
}

autoload();




