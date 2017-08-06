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
function load_the_faq_archive_template( $archive_template ) {
	if ( ! is_post_type_archive( 'faq' ) ) {
		return $archive_template;
	}

	return __DIR__ . '/archive-faq.php';
}