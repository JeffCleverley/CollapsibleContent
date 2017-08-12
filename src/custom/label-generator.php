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
 * Generate all the labels for custom post types.
 * Will be updated to be used for taxonomies too.
 *
 * @since 	0.0.1
 *
 * @param   array  $labels      provided by register_custom_post_types() from custom_configs.php
 *
 * @return 	array
 */
function custom_label_generator( $labels ) {
	$plural_label = $labels['plural_name'];
	$singular_label = $labels['singular_name'];
	$post_type = $labels['slug'];
	$text_domain = $labels['text_domain'];
	$in_sentence_singular = $singular_label;
	$in_sentence_plural = $plural_label;

	if ( $labels ['lowercase_in_sentence'] ) {
		$in_sentence_singular = mb_strtolower( $singular_label, 'UTF-8' );
		$in_sentence_plural = mb_strtolower( $plural_label, 'UTF-8' );
	}

	return [
		'name'                  => _x( $plural_label, 'post type general name', $text_domain ),
		'singular_name'      	=> _x( $singular_label, 'post type singular name', $text_domain ),
		'name_admin_bar'     	=> _x( $singular_label, 'add new on admin bar', $text_domain ),
		'add_new'            	=> _x( "Add New {$singular_label}", $post_type, $text_domain ),
		'add_new_item'       	=> __( "Add New {$singular_label}", $text_domain ),
		'new_item'           	=> __( "New {$singular_label}", $text_domain ),
		'edit_item'          	=> __( "Edit {$singular_label}", $text_domain ),
		'view_item'          	=> __( "View {$singular_label}", $text_domain ),
		'view_items'          	=> __( "View {$plural_label}", $text_domain ),
		'all_items'          	=> __( "All {$plural_label}", $text_domain ),
		'archives'          	=> __( "{$singular_label} Archives", $text_domain ),
		'attributes'          	=> __( "{$singular_label} Attributes", $text_domain ),
		'insert_into_item'      => __( "Insert in to {$in_sentence_singular}", $text_domain ),
		'uploaded_to_this_item' => __( "Uploaded to this {$in_sentence_singular}", $text_domain ),
		'search_items'       	=> __( "Search {$in_sentence_plural}", $text_domain ),
		'parent_item_colon'  	=> __( "Parent {$in_sentence_plural}:", $text_domain ),
		'not_found'          	=> __( "No {$in_sentence_plural} found.", $text_domain ),
		'not_found_in_trash' 	=> __( "No {$in_sentence_plural} found in Trash.", $text_domain ),
		'featured_image'        => __( "{$singular_label} Image", $text_domain ),
		'set_featured_image'    => __( "Set {$in_sentence_singular} image", $text_domain ),
		'remove_featured_image' => __( "Remove {$in_sentence_singular} image", $text_domain ),
		'use_featured_image'    => __( "Use {$in_sentence_singular} image", $text_domain ),
	];
}