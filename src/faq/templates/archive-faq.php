<?php
/**
 * FAQ Shortcode handler
 *
 * @package     Deftly\Module\FAQ\Templates
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\Module\FAQ\Templates;

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', __NAMESPACE__ . '\do_faq_archive_loop');
/**
 * Do the FAQ Archive Loop and render out the HTML by loading appropriate view.
 *
 * @since 0.0.1
 *
 * @return void
 */
function do_faq_archive_loop() {
	$records = get_posts_grouped_by_term( 'faq', 'topic' );
	if ( ! records ) {
		echo '<p>Sorry, there are no FAQs</p>';
	}

	foreach ( $records as $key => $record ) {
		//Load the view file
		d( $record );
	}
}

genesis();

