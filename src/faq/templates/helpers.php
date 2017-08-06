<?php
/**
 * Template Archive Helper
 *
 * @package     Deftly\Module\FAQ\Templates
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\Module\FAQ\Templates;

add_filter( 'archive_template', __NAMESPACE__ . '\load_the_faq_archive_template' );
/**
 * Load the new Custom Post Type archives from the theme.
 *
 * @since   0.0.1
 *
 * @param   string   $archive_template
 *
 * @return  string
 */
function load_the_faq_archive_template( $archive_template ) {
	if ( ! is_post_type_archive( 'faq' ) ) {
		return $archive_template;
	}

	$plugin_archive_template = __DIR__ . '/archive-faq.php';

	if ( ! $archive_template ) {
		return $plugin_archive_template;
	}

	if ( strpos( $archive_template, '/_archive-faq.php') === false ) {
		return $plugin_archive_template;
	}

	return $archive_template;
}