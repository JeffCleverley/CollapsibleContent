<?php
/**
 * Plugin Handler
 *
 * @package     Deftly\CollapsibleContent;
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\CollapsibleContent;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );
/**
 * Enqueue style and script assets
 *
 * @since   0.0.1
 *
 * @return  void
 */
function enqueue_assets() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_script(
		'collapsible-content-plugin-js',
		COLLAPSIBLE_CONTENT_URL . 'assets/dist/js/jquery.plugin.min.js',
		['jquery'],
		'0.0.1',
		true
		);

}

/**
 * Autoload Plugin Files
 *
 * @since   0.0.1
 *
 * @return  void
 */
function autoload() {
	$files = [
		'shortcode/shortcodes.php',
		'faq/module.php',
		'custom/module.php',
	];

	foreach( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}
autoload();