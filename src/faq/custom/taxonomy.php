<?php
/**
 * FAQ Custom Taxonomiy Handler
 *
 * @package     Deftly\Module\FAQ\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\Module\FAQ\Custom;

add_action( 'init', __NAMESPACE__ . '\register_custom_taxonomy' );
/**
 * Register the custom taxonomy.
 *
 * @since   0.0.1
 *
 * @return  void
 */
function register_custom_taxonomy() {
	$taxonomy_configs = custom_taxonomies_configs();
	if ( ! $taxonomy_configs ) {
		return;
	}

	foreach( $taxonomy_configs as $taxonomy_config ) {

		$labels = taxonomy_label_config( $taxonomy_config );

		$args = array(
			'labels'                => $labels,
			'public'                => $taxonomy_config['public'],
			'hierarchical'          => $taxonomy_config['hierarchical'],
			'show_in_quick_edit'    => $taxonomy_config['show_in_quick_edit'],
			'show_admin_column'     => $taxonomy_config['show_admin_column'],
			'show_in_rest'          => $taxonomy_config['show_in_rest'],
		);

		register_taxonomy( $taxonomy_config['slug'], $taxonomy_config['post_types'], $args );

	};
}
function taxonomy_label_config( $taxonomy_config ) {
	$text_domain = $taxonomy_config['text_domain'];
	$plural_label = $taxonomy_config['plural_name'];
	$singular_label = $taxonomy_config['singular_name'];

	$labels = [
		'name'              => _x( $plural_label, 'taxonomy general name', $text_domain ),
		'singular_name'     => _x( $singular_label, 'taxonomy singular name', $text_domain ),
		'search_items'      => __( 'Search ' . $plural_label, $text_domain ),
		'all_items'         => __( 'All' . $plural_label, $text_domain ),
		'edit_item'         => __( 'Edit ' . $singular_label, $text_domain ),
		'view_item'         => __( 'View ' . $singular_label, $text_domain ),
		'update_item'       => __( 'Update ' . $singular_label, $text_domain ),
		'add_new_item'      => __( 'Add New ' . $singular_label, $text_domain ),
		'new_item_name'     => __( 'New ' . $singular_label . ' Name', $text_domain ),
		'not_found'         => __( 'No ' .  $plural_label . ' found.', $text_domain ),
	];

	if ( $taxonomy_config['hierarchical'] == false ) {

		$non_hierarchical_labels = array(
			'popular_items'                 =>  __( 'Most popular ' . $plural_label, $text_domain ),
			'separate_items_with_commas'    =>  __( 'Separate ' . $plural_label . ' with commas', $text_domain ),
			'add_or_remove_items'           =>  __( 'Add or remove ' . $plural_label, $text_domain ),
			'choose_from_most_used'         =>  __( 'Choose from the most used ' . $plural_label, $text_domain ),
		);

		$non_hierarchical_labels = array_merge( $labels, $non_hierarchical_labels );
		return $non_hierarchical_labels;
	}

	$hierarchical_labels = array(
		'parent_item'       =>  __( 'Parent ' . $singular_label, $text_domain),
		'parent_item_colon' =>  __( 'Parent ' . $singular_label . ':', $text_domain),
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
	$taxonomy_configs = custom_taxonomies_configs();
	if ( ! $taxonomy_configs ) {
		return $post_meta;
	}

	foreach ( $taxonomy_configs as $taxonomy_config ) {
		$text_domain = $taxonomy_config['text_domain'];
		$post_meta .= sprintf(
			' [post_terms taxonomy="' . $taxonomy_config['slug'] . '" before="%s" after="<br />"]',
			__( $taxonomy_config['singular_name'] . ': ', $text_domain )
		);
	}
	return $post_meta;
}