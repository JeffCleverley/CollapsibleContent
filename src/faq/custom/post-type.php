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
 * @return  void
 */
function register_faq_custom_post_type( array $configs ) {
	$config = include( COLLAPSIBLE_CONTENT_DIR . 'config/faq/faq-post-type.php');

	if ( ! $config ) {
		return;
	}

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
 * @return  void
 */
function register_portfolio_custom_post_type( array $configs ) {
	$config = include( COLLAPSIBLE_CONTENT_DIR . 'config/faq/portfolio-post-type.php');

	if ( ! $config ) {
		return;
	}

	$configs[ $config['labels']['slug'] ] = $config;

	return $configs;
}


add_filter( 'add_custom_post_type_runtime_config',  __NAMESPACE__ . '\register_test_custom_post_type' );
/**
 * Register the custom Test post type from a config array.
 *
 * @since   1.0.0
 *
 * @param   array   $configs    Array of all the custom post type configurations for this module.
 *
 * @return  void
 */
function register_test_custom_post_type( array $configs ) {
	$config = array(
		'labels'    => array(
			'slug'              => 'test',
			'singular_name'     => 'Test',
			'plural_name'       => 'Tests',
			'text_domain'       => FAQ_MODULE_TEXT_DOMAIN,
			'title_placeholder' => '',
		),
		'args'  => array(
			'menu_icon'         => 'dashicons-welcome-learn-more',
			'description'       => 'Frequently Asked Questions - provide your users with quick and easy to answers to the most commonly asked questions.',
			'public'            => true,
			'has_archive'  		=> true,
			'menu_position'		=> 5,
			'taxonomies'        => array(
				'category',
				'post_tag',
				'topic',
			),
		),
		'features'  =>  array(
			'base_post_type'        => 'post',
			'excluded_features'     => array(
				'excerpt',
				'comments',
				'trackbacks',
			),
			'additional_features'   => array( ),
		),
		'help'              => array(),
	);

	$configs[ $config['labels']['slug'] ] = $config;
	return $configs;

}
