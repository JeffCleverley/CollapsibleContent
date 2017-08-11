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
	[ // Beginning of taxonomy config.
		'labels'    => array(
			'slug'                  => 'test',
			'singular_name'         => 'Test',
			'plural_name'           => 'Tests',
			'text_domain'           => FAQ_MODULE_TEXT_DOMAIN,
		),
		'args'  => array(
			'public'                => true,
			'hierarchical'          => false,
			'show_in_quick_edit'    => true,
			'show_admin_column'     => true,
			'show_in_rest'          => false,
		),
		'post_types'    => array(
			'faq',
		)
	], // End of taxonomy config.
);