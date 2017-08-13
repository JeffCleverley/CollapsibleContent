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
	'labels'    => array(
		'slug'                  => 'theory',
		'singular_name'         => 'Theory',
		'plural_name'           => 'Theories',
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
);