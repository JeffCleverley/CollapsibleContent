<?php
/**
 * Configs for DRY custom post type and taxonomy creation.
 *
 * @package     Deftly\Module\FAQ\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\Module\FAQ\Custom;
/**
 * Configure Custom Post Types.
 * Enter an additional array for each new post type
 *
 * REMEMBER - also need to create a view file in /templates/views for each CPT's help tab content.
 *
 * @return array
 */
function custom_post_type_configs() {
	return array(
		[
			'slug'                  => 'faq',
			'singular_name'         => 'FAQ',
			'plural_name'           => 'FAQs',
			'icon'                  => 'dashicons-editor-help',
			'description'           => 'Frequently Asked Questions - provide your users with quick and easy to answers to the most commonly asked questions.',
			'public'                => true,
			'hierarchical' 		    => false,
			'has_archive'  		    => true,
			'menu_position'		    => 5,
			'show_in_rest'          => false,
			'text_domain'           => FAQ_MODULE_TEXT_DOMAIN,
			'excluded_features'     => array(
				'excerpt',
				'comments',
				'trackbacks',
				'custom-fields',
			)
		],
	);
}
/**
 * Configure Custom Taxonomies.
 * Enter an additional array for each new taxonomy.
 *
 * @return array
 */
function custom_taxonomies_configs() {
	return array(
		[
			'slug'                  => 'topic',
			'singular_name'         => 'Topic',
			'plural_name'           => 'Topics',
			'public'                => true,
			'hierarchical'          => true,
			'show_in_quick_edit'    => true,
			'show_admin_column'     => true,
			'show_in_rest'          => false,
			'text_domain'           => FAQ_MODULE_TEXT_DOMAIN,
			'post_types'            => array(
				'faq',
			)
		],
	);
}