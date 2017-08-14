<?php
/**
 * FAQ shortcode's runtime configuration parameters.
 *
 * @package     Deftly\Module\FAQ\Shortcode
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\Module\FAQ\Shortcode;

return [
	'shortcode_name'            => 'faq', // [faq] //
	'shortcodes_within_content' => false, // specify if you want to run shortcodes within this shortcode
	'processing_function'       => __NAMESPACE__ . '\process_the_faq_shortcode',
	'view'                     =>  array(
		'container' =>  FAQ_MODULE_DIR . '/views/container.php',
		'faq'       =>  FAQ_MODULE_DIR . '/views/faq.php',
	),
	'defaults'                  => array(  // Over-writable defaults for shortcode
		'show_icon'                 =>  'dashicons dashicons-arrow-down-alt2 show-icon',
		'hide_icon'                 =>  'dashicons dashicons-arrow-up-alt2 hide-icon',
		'post_id'                   =>  0,
		'order'                     =>  'ASC',
		'orderby'                   =>  'menu_order',
		'topic_slug'                =>  '',
		'number_of_faqs'            =>  -1,
		'show_none_found_message'   =>  1,
		'none_found_by_topic'       =>  __('Sorry, no FAQs were found for that topic.', FAQ_MODULE_TEXT_DOMAIN ),
		'none_found_single'         =>  __('Sorry, no FAQ found.', FAQ_MODULE_TEXT_DOMAIN ),
	),
];