<?php
/**
 * FAQ Custom Post Types handler
 *
 * @package     Deftly\Module\FAQ\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace Deftly\Module\FAQ\Custom;

add_filter( 'add_custom_post_type_runtime_config',  __NAMESPACE__ . '\register_faq_custom_post_type' );
/**
 * Register the custom FAQ post type from a config file.
 *
 * @since   1.0.0
 *
 * @param   array   $configs    Array of all the custom post type configurations for this module.
 *
 * @return  array   $configs
 */
function register_faq_custom_post_type( array $configs ) {
	$config = include( COLLAPSIBLE_CONTENT_DIR . 'config/faq/faq-post-type.php');
	$configs[ $config['labels']['slug'] ] = $config;
	return $configs;
}

add_filter( 'add_custom_post_type_runtime_config',  __NAMESPACE__ . '\register_portfolio_custom_post_type' );
/**
 * Register the custom Portfolio post type from a config file.
 *
 * @since   1.0.0
 *
 * @param   array   $configs    Array of all the custom post type configurations for this module.
 *
 * @return  array   $configs
 */
function register_portfolio_custom_post_type( array $configs ) {
	$config = include( COLLAPSIBLE_CONTENT_DIR . 'config/faq/portfolio-post-type.php');
	$configs[ $config['labels']['slug'] ] = $config;
	return $configs;
}

