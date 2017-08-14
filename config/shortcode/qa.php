<?php
/**
 * Runtime configuration parameters for the [qa] shortcode.
 *
 * @package     Deftly\CollapsibleContent\Shortcode
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/
 * @license     GNU General Public License 2.0+
 *
 */
namespace Deftly\CollapsibleContent\Shortcode;

return [
	'shortcode_name'            => 'qa', // [qa] //
	'shortcodes_within_content' => true, // specify if you want to run shortcodes within this shortcode
	'processing_function'       => null,
	'view'                      =>  COLLAPSIBLE_CONTENT_DIR . 'src/shortcode/views/qa.php',
	'defaults'                  => array(  // Over-writable defaults for shortcode
		'show_icon' =>  'dashicons dashicons-arrow-down-alt2 show-icon',
		'hide_icon' =>  'dashicons dashicons-arrow-up-alt2 hide-icon',
		'question'  => '',
	),
];

