<?php
/**
 * Collapsible Content Plugin
 *
 * @package         Deftly\CollapsibleContent
 * @since           0.0.1
 * @author          Jeff Cleverley
 * @link            https://github.com/JeffCleverley/CollapsibleContent
 * @copyright       Jeff Cleverley
 * @license         GNU General Public License 2.0+
 *
 * @wordpress-plugin
 *
 * Plugin Name:     Collapsible Content
 * Plugin URI:      https://github.com/JeffCleverley/CollapsibleContent
 * Description:     Add collapsible content to your WordPress site - Includes Teaser and Q&A formats.
 * Version:         0.0.1
 * Author:          Jeff Cleverley
 * Author URI:      https://jeffcleverley.com
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     collapsible_content
 * Requires WP:     4.7.5
 * Requires PHP:    7.0
 *
*/
namespace  Deftly\CollapsibleContent;

use Deftly\Module\Custom as CustomModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit( "Nothing to see here, move along now...!" );
}

define( 'COLLAPSIBLE_CONTENT_PLUGIN', __FILE__ );
define( 'COLLAPSIBLE_CONTENT_DIR', plugin_dir_path( __FILE__ ) );
$plugin_url = plugin_dir_url( __FILE__ );
if ( is_ssl() ) {
	$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
}
define( 'COLLAPSIBLE_CONTENT_URL', $plugin_url );
define( 'COLLAPSIBLE_CONTENT_TEXT_DOMAIN', 'collapsible_content' );

include( __DIR__ . '/src/plugin.php' );

CustomModule\register_plugin_with_custom_module_rewrite_deletes( __FILE__ );



