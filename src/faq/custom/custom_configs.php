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
 * @return array
 */
function custom_post_type_configs() {
	return array(
		[ // Beginning of post type config.
			'labels'    => array(
				'slug'              => 'faq',
				'singular_name'     => 'FAQ',
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
				'show_in_rest'      => true,
			),
			'excluded_features' => array(
				'excerpt',
				'comments',
				'trackbacks',
				'custom-fields',
				'thumbnail',
			),
			'additional_features' => array(
				'page-attributes',
			),
			'help'              => array(
				array(
					'help_tab_id'       => 'faq-help',
					'help_title'        => 'FAQ Help',
					'help_content'      => 'Some help content to helpfully help people who need help!',
					'help_link'         => 'https://github.com/JeffCleverley/CollapsibleContent',
				),
				array(
					'help_tab_id'       => 'faq-support',
					'help_title'        => 'FAQ Support',
					'help_content'      => 'Some support content to support those in need of support.',
					'help_link'         => 'https://github.com/JeffCleverley/CollapsibleContent',
				),
			),
		], // End of post type config.
		[ // Beginning of post type config.
			'labels'    => array(
				'slug'              => 'test',
				'singular_name'     => 'Test',
				'plural_name'       => 'Tests',
				'text_domain'       => FAQ_MODULE_TEXT_DOMAIN,
				'title_placeholder' => '',
			),
			'args'  => array(
				'menu_icon'         => 'dashicons-editor-help',
				'description'       => 'Frequently Asked Questions - provide your users with quick and easy to answers to the most commonly asked questions.',
				'public'            => true,
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
			'supported_features' => array(
				'page_attributes',
			),
			'help'              => array(),
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