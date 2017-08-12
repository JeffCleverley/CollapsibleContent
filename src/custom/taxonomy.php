<?php
/**
 * FAQ Custom Taxonomy Handler
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
 * @param $config
 *
 * @return void
 */
function register_custom_taxonomies( $config ) {
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
	$args['labels'] = taxonomy_label_config( $config['labels'] );

	register_taxonomy( $taxonomy, $config['post_types'], $args );
}

/**
 * Generate the labels for the Custom Taxonomy
 *
 * @param $taxonomy_labels
 *
 * @return array
 */
function taxonomy_label_config( $taxonomy_labels ) {
	$text_domain = $taxonomy_labels['text_domain'];
	$plural_label = $taxonomy_labels['plural_name'];
	$singular_label = $taxonomy_labels['singular_name'];
	$in_sentence_singular = $singular_label;
	$in_sentence_plural = $plural_label;

	if ( $labels ['lowercase_in_sentence'] ) {
		$in_sentence_singular = mb_strtolower( $singular_label, 'UTF-8' );
		$in_sentence_plural = mb_strtolower( $plural_label, 'UTF-8' );
	}

	$labels = [
		'name'              => _x( $plural_label, 'taxonomy general name', $text_domain ),
		'singular_name'     => _x( $singular_label, 'taxonomy singular name', $text_domain ),
		'search_items'      => __( "Search {$plural_label}", $text_domain ),
		'all_items'         => __( "All {$plural_label}", $text_domain ),
		'edit_item'         => __( "Edit {$singular_label}", $text_domain ),
		'view_item'         => __( "View {$singular_label}", $text_domain ),
		'update_item'       => __( "Update {$singular_label}", $text_domain ),
		'add_new_item'      => __( "Add New {$singular_label}", $text_domain ),
		'new_item_name'     => __( "New {$in_sentence_singular} Name", $text_domain ),
		'not_found'         => __( "No {$in_sentence_plural} found.", $text_domain ),
	];

	if ( $taxonomy_labels['hierarchical'] === false ) {
		$non_hierarchical_labels = array(
			'popular_items'                 =>  __( "Most popular {$plural_label}", $text_domain ),
			'separate_items_with_commas'    =>  __( "Separate {$plural_label} with commas", $text_domain ),
			'add_or_remove_items'           =>  __( "Add or remove {$plural_label}", $text_domain ),
			'choose_from_most_used'         =>  __( "Choose from the most used {$plural_label}", $text_domain ),
		);

		$non_hierarchical_labels = array_merge( $labels, $non_hierarchical_labels );
		return $non_hierarchical_labels;
	}

	$hierarchical_labels = array(
		'parent_item'       =>  __( "Parent {$singular_label}", $text_domain),
		'parent_item_colon' =>  __( "Parent {$singular_label}: ", $text_domain),
	);

	$hierarchical_labels = array_merge( $labels, $hierarchical_labels );
	return $hierarchical_labels;
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
 * @return  string              default with custom taxonomies concatenated on in shortcode form.
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

