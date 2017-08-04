<?php
/**
 * FAQ module handler
 *
 * @package     Deftly\Module\FAQ
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\Module\FAQ;

// REMEMBER TO REDEFINE INTO NEW CONTEXT WHEN MODULE IS MOVED
define( 'FAQ_MODULE_TEXT_DOMAIN', COLLAPSIBLE_CONTENT_TEXT_DOMAIN );

/**
 * Autoload Module Files
 *
 * @since   0.0.1
 *
 * @return  void
 */
function autoload() {
	$files = [
		'custom/post-type.php',
		'custom/taxonomy.php',
		'shortcode/shortcode.php',
	];

	foreach( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}
autoload();