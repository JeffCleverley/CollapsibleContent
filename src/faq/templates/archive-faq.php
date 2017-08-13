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
 * NOTE: The variables are set to call the correct
 * HTML markup in the container.php view file
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

	$attributes = array(
		'show_icon' =>  'dashicons dashicons-plus',
		'hide_icon' =>  'dashicons dashicons-minus',
	);

	$use_term_container = true;
	$show_term_name = true;
	$is_calling_source = 'template';


	foreach ( $records as $key => $record ) {
		$term_slug = $record['term_slug'];
		include( FAQ_MODULE_DIR . '/views/container.php' );
	}
}

/**
 * Loop through and render out the FAQs.
 *
 * @since   0.0.1
 *
 * @param   array $faqs
 *
 * @return  voic
 */
function loop_and_render_faqs( array $faqs ) {
	$attributes = array(
		'show_icon' =>  'dashicons dashicons-editor-help',
		'hide_icon' =>  'dashicons dashicons-lightbulb',
	);

	foreach ( $faqs as $faq ) {
		$hidden_content = do_shortcode( $faq['post_content'] );
		$post_title     = $faq['post_title'];

		include( FAQ_MODULE_DIR . '/views/faq.php' );
	}
}

genesis();

