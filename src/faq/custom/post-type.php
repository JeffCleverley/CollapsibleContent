<?php
/**
 * FAQ Custom Post Types
 *
 * @package     Deftly\Module\FAQ\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace Deftly\Module\FAQ\Custom;

add_action( 'init', __NAMESPACE__ . '\register_faq_custom_post_type' );
/**
 * Register the custom FAQ post types.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_faq_custom_post_type() {
	$config = include( COLLAPSIBLE_CONTENT_DIR . 'config/faq/post-type.php');

	if ( ! config ) {
		return;
	}

	\Deftly\Module\Custom\register_custom_post_types( $config );
}
