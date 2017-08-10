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
 * REMEMBER - also need to create a view file for each CPT's help tab content.
 *
 * @return array
 */
function custom_post_type_configs() {
	return array(
		[ // Beginning of post type config.
			'labels'    => array(
				'singular_name'     => 'FAQ',
				'slug'              => 'faq',
				'plural_name'       => 'FAQs',
				'text_domain'       => FAQ_MODULE_TEXT_DOMAIN,
				'title_placeholder' => 'Enter a title for your FAQ here...',
			),
			'args'  => array(
				'menu_icon'         => 'dashicons-editor-help',
				'description'       => 'Frequently Asked Questions - provide your users with quick and easy to answers to the most commonly asked questions.',
				'public'            => true,
				'page_attributes'   => true,
				'has_archive'  		=> true,
				'menu_position'		=> 5,
			),
			'excluded_features' => array(
				'excerpt',
				'comments',
				'trackbacks',
				'custom-fields',
				'thumbnail',
			),
			'help'              => array(
				'help_content'      => 'Clearly explain the question and give context to your answers.<br> If you give examples of the sorts of situations the FAQ is intended to address, it will help the readers no end.',
				'help_link'         => 'https//:github.com/JeffCleverley/CollapsibleContent',
	)
		], // End of post type config.
		[ // Beginning of post type config.
				'labels'    => array(
					'singular_name'     => 'Test',
				'slug'              => 'test',
				'plural_name'       => 'Tests',
				'text_domain'       => FAQ_MODULE_TEXT_DOMAIN,
				'title_placeholder' => '',
			),
			'args'  => array(
				'menu_icon'         => 'dashicons-editor-help',
				'description'       => 'Frequently Asked Questions - provide your users with quick and easy to answers to the most commonly asked questions.',
				'public'            => true,
				'page_attributes'   => true,
				'has_archive'  		=> true,
				'menu_position'		=> 5,
			),
			'excluded_features' => array(
				'excerpt',
				'comments',
				'trackbacks',
				'custom-fields',
				'thumbnail',
			),
			'help'              => array(
				'help_content'      => '',
				'help_link'         => '',
			),
		], // End of post type config.
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
		[ // Beginning of taxonomy config.
			'labels'    => array(
				'slug'                  => 'topic',
				'singular_name'         => 'Topic',
				'plural_name'           => 'Topics',
				'text_domain'           => FAQ_MODULE_TEXT_DOMAIN,
			),
			'args'  => array(
				'public'                => true,
				'hierarchical'          => true,
				'show_in_quick_edit'    => true,
				'show_admin_column'     => true,
				'show_in_rest'          => false,
			),
			'post_types'    => array(
				'faq',
			)
		], // End of taxonomy config.
	);
}