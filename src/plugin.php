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

use Deftly\Module\Custom as CustomModule;

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
		'http://wpsandbox.dev/wp-content/plugins/CollapsibleContent/assets/dist/js/jquery.plugin.min.js',
		['jquery'],
		'0.0.1'
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
		'faq/module.php',
		'custom/module.php',
	];

	foreach( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\setup_plugin' );
/**
 * Setup the plugin
 *
 * @since   0.0.1
 *
 * @return  void
 */
function setup_plugin() {
	foreach ( array( 'qa', 'teaser' ) as $shortcode ) {
		$pathto_config_file = sprintf( '%sconfig/shortcode/%s.php',
		COLLAPSIBLE_CONTENT_DIR,
		$shortcode
		);

		CustomModule\register_shortcode( $pathto_config_file );
	}
}

autoload();