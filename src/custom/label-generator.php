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
 * @param $config
 * @param string $custom_type
 *
 * @return array
 */
function custom_label_generator( $config, $custom_type = '' ) {
	$plural_label = $config['labels']['plural_name'];
	$singular_label = $config['labels']['singular_name'];
	$post_type = $config['labels']['slug'];
	$text_domain = $config['labels']['text_domain'];
	$in_sentence_singular = $singular_label;
	$in_sentence_plural = $plural_label;

	if ( $config['labels']['lowercase_in_sentence'] ) {
		$in_sentence_singular = mb_strtolower( $singular_label, 'UTF-8' );
		$in_sentence_plural = mb_strtolower( $plural_label, 'UTF-8' );
	}

	$labels_for_all = [
		'name'                  => _x( $plural_label, "{$custom_type} general name", $text_domain ),
		'singular_name'      	=> _x( $singular_label, "{$custom_type} singular name", $text_domain ),
		'add_new_item'       	=> __( "Add New {$singular_label}", $text_domain ),
		'edit_item'             => __( "Edit {$singular_label}", $text_domain ),
		'view_item'          	=> __( "View {$singular_label}", $text_domain ),
		'all_items'          	=> __( "All {$plural_label}", $text_domain ),
		'search_items'       	=> __( "Search {$in_sentence_plural}", $text_domain ),
		'not_found'          	=> __( "No {$in_sentence_plural} found.", $text_domain ),
		];

	$post_type_only_labels = [
		'name_admin_bar'   	    => _x( $singular_label, 'add new on admin bar', $text_domain ),
		'add_new'      	        => _x( "Add New {$singular_label}", $post_type, $text_domain ),
		'new_item'           	=> __( "New {$singular_label}", $text_domain ),
		'view_items'          	=> __( "View {$plural_label}", $text_domain ),
		'archives'      	    => __( "{$singular_label} Archives", $text_domain ),
		'attributes'          	=> __( "{$singular_label} Attributes", $text_domain ),
		'insert_into_item'      => __( "Insert in to {$in_sentence_singular}", $text_domain ),
		'uploaded_to_this_item' => __( "Uploaded to this {$in_sentence_singular}", $text_domain ),
		'parent_item_colon'	    => __( "Parent {$in_sentence_plural}:", $text_domain ),
		'not_found_in_trash' 	=> __( "No {$in_sentence_plural} found in Trash.", $text_domain ),
		'featured_image'        => __( "{$singular_label} Image", $text_domain ),
		'set_featured_image'    => __( "Set {$in_sentence_singular} image", $text_domain ),
		'remove_featured_image' => __( "Remove {$in_sentence_singular} image", $text_domain ),
		'use_featured_image'    => __( "Use {$in_sentence_singular} image", $text_domain ),
	];

	$post_type_and_hierarchical_taxonomy_labels = [
		'parent_item_colon' => __( "Parent {$singular_label}: ", $text_domain),
	];

	$either_taxonomy_only_labels = [
		'update_item'      => __( "Update {$singular_label}", $text_domain ),
		'new_item_name'    => __( "New {$in_sentence_singular} Name", $text_domain ),
	];

	$non_hierarchical_taxonomy_only_labels = [
		'popular_items'                 =>  __( "Most popular {$plural_label}", $text_domain ),
		'separate_items_with_commas'    =>  __( "Separate {$plural_label} with commas", $text_domain ),
		'add_or_remove_items'           =>  __( "Add or remove {$plural_label}", $text_domain ),
		'choose_from_most_used'         =>  __( "Choose from the most used {$plural_label}", $text_domain ),
	];

	$hierarchical_taxonomy_only_labels = [
		'parent_item'   =>  __( "Parent {$singular_label}", $text_domain),
	];

	if ( $custom_type == 'post' || $custom_type == 'page' ) {
		$post_type_labels = array_merge(
			$labels_for_all,
			$post_type_only_labels,
			$post_type_and_hierarchical_taxonomy_labels
		);
		return $post_type_labels;
	}

	if ( $custom_type == 'taxonomy' && $config['args']['hierarchical'] ) {
		$hierarchical_taxonomy_labels = array_merge(
			$labels_for_all,
			$post_type_and_hierarchical_taxonomy_labels,
			$either_taxonomy_only_labels,
			$hierarchical_taxonomy_only_labels
		);
		return $hierarchical_taxonomy_labels;
	}

	if ( $custom_type == 'taxonomy' && ! $config['args']['hierarchical'] ) {
		$hierarchical_taxonomy_labels = array_merge(
			$labels_for_all,
			$either_taxonomy_only_labels,
			$non_hierarchical_taxonomy_only_labels
		);
		return $hierarchical_taxonomy_labels;
	}
}