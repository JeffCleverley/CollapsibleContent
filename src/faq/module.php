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

add_filter( 'add_custom_post_type_runtime_config', __NAMESPACE__ . '\register_faq_custom_configs' );
add_filter( 'add_custom_taxonomy_runtime_config', __NAMESPACE__ . '\register_faq_custom_configs' );
/**
 * Register the custom FAQ post type from a config file.
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
	$configurations = include( COLLAPSIBLE_CONTENT_DIR . 'config/faq/' . $filename .'.php');

	if ( ! $configurations ) {
		return $configs;
	}

	foreach ( $configurations as $config ) {
		$configs[ $config['labels']['slug'] ] = $config;
	}

	return $configs;
}

