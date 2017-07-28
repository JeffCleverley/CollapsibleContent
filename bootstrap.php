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

/*
GNU General Public License 2.0+

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

namespace  Deftly\CollapsibleContent;

use function Composer\Autoload\includeFile;

if ( ! defined( 'ABSPATH' ) ) {
	exit( "Nothing to see here, move along now...!" );
}

include( __DIR__ . '/src/shortcode/shortcodes.php' );

function plugin_launch() {

}