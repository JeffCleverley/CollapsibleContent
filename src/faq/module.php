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
define( 'FAQ_MODULE_DIR', __DIR__ );

/**
 * Autoload Module Files
 *
 * @since   0.0.1
 *
 * @return  void
 */
function autoload() {
	$files = [
  	    'custom/taxonomy.php',
		'custom/post-type.php',
		'shortcode/shortcode.php',
		'templates/helpers.php',
	];

	foreach( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}
autoload();

