<?php
/**
 *  Shortcode processors
 *
 * @package     Deftly\CollapsibleContent\Shortcode
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/
 * @license     GNU General Public License 2.0+
 *
 */
namespace Deftly\CollapsibleContent\Shortcode;

add_shortcode( 'qa', __NAMESPACE__ . '\process_the_shortcode' );
add_shortcode( 'teaser', __NAMESPACE__ . '\process_the_shortcode' );
/**
 * Process the FAQ Shortcode to build a list of FAQs.
 *
 * @since 1.0.0
 *
 * @param   array|string  $user_defined_attributes  User defined attributes for this shortcode instance
 * @param   string|null   $hidden_content           Content between the opening and closing shortcode elements
 * @param   string        $shortcode_name           Name of the shortcode
 *
 * @return string
 */
function process_the_shortcode( $user_defined_attributes, $hidden_content, $shortcode_name ) {
	$config = get_shortcode_configuration( $shortcode_name );

	$attributes = shortcode_atts(
		$config['defaults'],
		$user_defined_attributes,
		$shortcode_name
	);

	// Some processing
	$attributes['show_icon'] = esc_attr( $attributes['show_icon'] );
	if ( $hidden_content ) {
		$hidden_content =  do_shortcode( $hidden_content );
	}

	ob_start();
	include( $config['view'] );
	return ob_get_clean();
}
/**
 * Get the runtime configuration parameters for the specified shortcode.
 *
 * @since   0.0.1
 * @param   string  $shortcode_name     The name of the shortcode
 *
 * @return  array
 */
function get_shortcode_configuration( $shortcode_name ) {
	$config = [
		'view'      =>  __DIR__ . '/views/' . $shortcode_name . '.php',
		'defaults'  =>  [
			'show_icon' =>  'dashicons dashicons-arrow-down-alt2 show-icon',
			'hide_icon' =>  'dashicons dashicons-arrow-up-alt2 hide-icon',
		],
	];

	if ( $shortcode_name == 'qa' ) {
		$config['defaults']['question'] = '';
	} elseif ( $shortcode_name == 'teaser' ) {
		$config['defaults']['visible_message'] = '';
	}

	return $config;
}