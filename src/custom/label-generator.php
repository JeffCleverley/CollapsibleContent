<?php
/**
 * Custom Label Handler
 *
 * @package     Deftly\Module\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace Deftly\Module\Custom;

/**
 * Generate all the labels for custom content.
 * Custom post types
 * Custom hierarchical taxonomies - ie Custom categories
 * Custom non-hierarchical taxonomies - ie Custom tags
 *
 * @since 	0.0.1
 *
 * @param   array   $config
 * @param   string  $custom_type
 *
 * @return  array   $labels
 */
function custom_label_generator( array $config, $custom_type = 'post' ) {

	$config['labels'] = array_merge(
		array( 'specific_labels'=> array() ),
		$config['labels']
	);

	$config['labels']['in_sentence_singular'] = $config['labels']['singular_name'];
	$config['labels']['in_sentence_plural'] = $config['labels']['plural_name'];
	if ( $config['labels']['lowercase_in_sentence'] ) {
		$config['labels']['in_sentence_singular'] = mb_strtolower( $config['labels']['singular_name'], 'UTF-8' );
		$config['labels']['in_sentence_plural'] = mb_strtolower( $config['labels']['plural_name'], 'UTF-8' );
	}

	$labels = [
		'name'                  => _x( $config['labels']['plural_name'], "{$custom_type} general name", $config['labels']['text_domain'] ),
		'singular_name'      	=> _x( $config['labels']['singular_name'], "{$custom_type} singular name", $config['labels']['text_domain'] ),
		'add_new_item'       	=> __( "Add New {$config['labels']['singular_name']}", $config['labels']['text_domain'] ),
		'edit_item'             => __( "Edit {$config['labels']['singular_name']}", $config['labels']['text_domain'] ),
		'view_item'          	=> __( "View {$config['labels']['singular_name']}", $config['labels']['text_domain'] ),
		'all_items'          	=> __( "All {$config['labels']['plural_name']}", $config['labels']['text_domain'] ),
		'search_items'       	=> __( "Search {$config['labels']['in_sentence_plural']}", $config['labels']['text_domain'] ),
		'not_found'          	=> __( "No {$config['labels']['in_sentence_plural']} found.", $config['labels']['text_domain'] ),
	];

	$custom_type_generator = __NAMESPACE__;
	$custom_type_generator .= $custom_type == 'post' || 'page'
		? '\generate_custom_labels_for_post_types'
		: '\generate_custom_labels_for_taxonomies';

	$labels = array_merge( $labels, $custom_type_generator( $config ) );

	if ( $config['labels']['specific_labels'] ) {
		$labels = array_merge( $labels, $config['labels']['specific_labels'] );
	}

	return $labels;
}

/**
 * Generate labels for post types.
 *
 * @since   0.0.1
 *
 * @param   array   $config
 *
 * @return  array
 */
function generate_custom_labels_for_post_types( array $config ) {
	return [
		'name_admin_bar'   	    => _x( $config['labels']['singular_name'], 'add new on admin bar', $config['labels']['text_domain'] ),
		'add_new'      	        => _x( "Add New {$config['labels']['singular_name']}", $config['features']['base_post_type'], $config['labels']['text_domain'] ),
		'new_item'           	=> __( "New {$config['labels']['singular_name']}", $config['labels']['text_domain'] ),
		'view_items'          	=> __( "View {$config['labels']['plural_name']}", $config['labels']['text_domain'] ),
		'archives'      	    => __( "{$config['labels']['singular_name']} Archives", $config['labels']['text_domain'] ),
		'attributes'          	=> __( "{$config['labels']['singular_name']} Attributes", $config['labels']['text_domain'] ),
		'insert_into_item'      => __( "Insert in to {$config['labels']['in_sentence_singular']}", $config['labels']['text_domain'] ),
		'uploaded_to_this_item' => __( "Uploaded to this {$config['labels']['in_sentence_singular']}", $config['labels']['text_domain'] ),
		'parent_item_colon'	    => __( "Parent {$config['labels']['in_sentence_plural']}:", $config['labels']['text_domain'] ),
		'not_found_in_trash' 	=> __( "No {$config['labels']['in_sentence_plural']} found in Trash.", $config['labels']['text_domain'] ),
		'featured_image'        => __( "{$config['labels']['singular_name']} Image", $config['labels']['text_domain'] ),
		'set_featured_image'    => __( "Set {$config['labels']['in_sentence_singular']} image", $config['labels']['text_domain'] ),
		'remove_featured_image' => __( "Remove {$config['labels']['in_sentence_singular']} image", $config['labels']['text_domain'] ),
		'use_featured_image'    => __( "Use {$config['labels']['in_sentence_singular']} image", $config['labels']['text_domain'] ),
	];
}

/**
 * Generate labels for taxonomies.
 *
 * @since   0.0.1
 *
 * @param   array   $config
 *
 * @return  array   $labels
 */
function generate_custom_labels_for_taxonomies( array $config ){

	$labels = [
		'update_item'      => __( "Update {$config['labels']['singular_name']}", $config['labels']['text_domain'] ),
		'new_item_name'    => __( "New {$config['labels']['in_sentence_singular']} Name", $config['labels']['text_domain'] ),
	];

	if ( ! $config['args']['hierarchical'] ) {
		$non_hierarchical_only_labels = [
			'popular_items'                 =>  __( "Most popular {$config['labels']['plural_name']}", $config['labels']['text_domain'] ),
			'separate_items_with_commas'    =>  __( "Separate {$config['labels']['plural_name']} with commas", $config['labels']['text_domain'] ),
			'add_or_remove_items'           =>  __( "Add or remove {$config['labels']['plural_name']}", $config['labels']['text_domain'] ),
			'choose_from_most_used'         =>  __( "Choose from the most used {$config['labels']['plural_name']}", $config['labels']['text_domain'] ),
		];
		$labels = array_merge( $labels, $non_hierarchical_only_labels );
	}

	if ( $config['args']['hierarchical'] ) {
		$hierarchical_only_labels = [
			'parent_item'   =>  __( "Parent {$config['labels']['singular_name']}", $config['labels']['text_domain']),
			'parent_item_colon' => __( "Parent {$config['labels']['singular_name']}: ", $config['labels']['text_domain']),
		];
		$labels = array_merge( $labels, $hierarchical_only_labels );
	}

	return $labels;
}