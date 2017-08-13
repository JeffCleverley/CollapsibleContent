<?php
/**
 * Custom Taxonomy Handler
 *
 * @package     Deftly\Module\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace Deftly\Module\Custom;

add_action( 'init', __NAMESPACE__ . '\register_custom_taxonomies' );
/**
 * Register the custom taxonomies.
 *
 * @since   0.0.1
 *
 * @return void
 */
function register_custom_taxonomies() {
	/*
	 * Add custom taxonomy runtime configurations from generating and registering
	 * each with WordPress
	 *
	 * @since   0.0.1
	 *
	 * @param   array   Array of configurations
	 */
	$taxonomy_configs = (array) apply_filters( 'add_custom_taxonomy_runtime_config', array() );

	if ( ! $taxonomy_configs ) {
		return;
	}

	foreach( $taxonomy_configs as $taxonomy => $taxonomy_config ) {
		register_custom_taxonomy( $taxonomy, $taxonomy_config );
	};
}

/**
 * Register each Custom Taxonomy
 *
 * @since   0.0.1
 *
 * @param   string  $taxonomy
 * @param   array   $config
 *
 * @return  void
 */
function register_custom_taxonomy( $taxonomy, array $config ) {
	$args = $config['args'];
	$args['labels'] = custom_label_generator( $config, 'taxonomy' );
	register_taxonomy( $taxonomy, $config['post_types'], $args );
}

add_filter( 'genesis_post_meta', __NAMESPACE__ . '\filter_custom_taxonomies_to_genesis_footer_post_meta' );
/**
 * Filter the Genesis Footer Entry Post meta
 * to add the post terms for our custom taxonomy
 *
 * @since   0.0.1
 *
 * @param   string  $post_meta  default "[post_categories] [post_tags]".
 *
 * @return  string  $post_meta  default with custom taxonomies concatenated on in shortcode form.
 */
function filter_custom_taxonomies_to_genesis_footer_post_meta( $post_meta ) {
	/*
	 * Add custom taxonomy runtime configurations from generating and registering
	 * each with WordPress
	 *
	 * @since   0.0.1
	 *
	 * @param   array   Array of configurations
	 */
	$taxonomy_configs = (array) apply_filters( 'add_custom_taxonomy_runtime_config', array() );
	if ( ! $taxonomy_configs ) {
		return $post_meta;
	}

	foreach ( $taxonomy_configs as $taxonomy_config ) {
		$text_domain = $taxonomy_config['labels']['text_domain'];
		$post_meta   .= sprintf(
			"[post_terms taxonomy=\"{$taxonomy_config['labels']['slug']}\" before=\"%s\" after=\"<br />\"]",
			__( "{$taxonomy_config['labels']['singular_name']}: ", $text_domain )
		);
	}

	return $post_meta;
}

