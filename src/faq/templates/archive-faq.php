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

use function Composer\Autoload\includeFile;

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
		include( __DIR__ . '/views/container.php' );
	}
}

function loop_and_render_faqs( array $faqs ) {
	$attributes = array(
		'show_icon' =>  'dashicons dashicons-arrow-down-alt2 show-icon',
		'hide_icon' =>  'dashicons dashicons-arrow-up-alt2 hide-icon',
	);

	foreach ( $faqs as $faq ) {
		$hidden_content =  do_shortcode( $faq['post_content'] );

		include( __DIR__ . '/views/faq.php' );
	}
}

genesis();

