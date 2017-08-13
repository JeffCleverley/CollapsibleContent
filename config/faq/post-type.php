<?php
/**
 * Description Here
 *
 * @package     ${NAMESPACE}
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/
 * @license     GNU General Public License 2.0+
 *
 */

return [
	'faq' =>    array(
		'labels'    => array(
			'slug'                  => 'faq',
			'singular_name'         => 'FAQ',
			'plural_name'           => 'FAQs',
			'lowercase_in_sentence' => false,
			'text_domain'           => FAQ_MODULE_TEXT_DOMAIN,
			'title_placeholder'     => 'Enter a title for your FAQ here...',
			'specific_labels'       => array(),
		),
		'args'  => array(
			'menu_icon'         => 'dashicons-editor-help',
			'description'       => 'Frequently Asked Questions - provide your users with quick and easy to answers to the most commonly asked questions.',
			'public'            => true,
			'has_archive'  		=> true,
			'menu_position'		=> 5,
			'show_in_rest'      => true,
			'taxonomies'        => array(
				'category',
				'post_tag',
			),
		),
		'features'  =>  array(
			'base_post_type'        => 'post',
			'excluded_features'     => array(
				'excerpt',
				'comments',
				'trackbacks',
				'custom-fields',
			),
			'additional_features'   => array(
				'page-attributes',
			),
		),
		'help'                      => array(
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
	),
	'portfolio' =>  array(
		'labels'    => array(
			'slug'                  => 'portfolio',
			'singular_name'         => 'Portfolio',
			'plural_name'           => 'Portfolios',
			'lowercase_in_sentence' => false,
			'text_domain'           => FAQ_MODULE_TEXT_DOMAIN,
			'title_placeholder'     => 'Enter a title for your Portfolio here...',
		),
		'args'  => array(
			'menu_icon'         => 'dashicons-images-alt',
			'description'       => 'Frequently Asked Questions - provide your users with quick and easy to answers to the most commonly asked questions.',
			'public'            => true,
			'has_archive'  		=> true,
			'menu_position'		=> 5,
			'show_in_rest'      => true,
			'taxonomies'        => array(
				'category',
				'post_tag',
			),
		),
		'features'  =>  array(
			'base_post_type'        => 'post',
			'excluded_features'     => array(
				'excerpt',
				'comments',
				'trackbacks',
				'custom-fields',
			),
			'additional_features'   => array(
				'page-attributes',
			),
		),
		'help'                      => array(
			array(
				'help_tab_id'       => 'portfolio-help',
				'help_title'        => 'Portfolio Help',
				'help_content'      => 'Some help content to helpfully help people who need help!',
				'help_link'         => 'https://github.com/JeffCleverley/CollapsibleContent',
			),
		),
	),
];
