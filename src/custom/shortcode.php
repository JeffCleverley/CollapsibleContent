<?php
/**
 * Custom Shortcode Processing.
 *
 * @package     Deftly\Module\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\Module\Custom;

/**
 * Register your shortcode with the Custom Module.
 *
 * @since   0.0.1
 *
 * @param   string          $pathto_config_file    Absolute path to the configuration file's location
 *
 * @return  array|false
 */
function register_shortcode( $pathto_config_file ) {

	if ( ! is_readable( $pathto_config_file ) ) {
		return false;
	}

	$config = (array) include( $pathto_config_file );

	$config = array_merge(
		array(
			'shortcode_name'            => '',
			'shortcodes_within_content' => true,
			'processing_function'       => null,
			'view'                      => '',
			'defaults'                  => array(),
		),
		$config
	);

	if ( ! $config['shortcode_name'] || ! $config['view']  ) {
		return false;
	}

	add_shortcode( $config['shortcode_name'], __NAMESPACE__ . '\process_the_shortcode_callback' );
	return store_shortcode_configuration( $config['shortcode_name'], $config );

}

/**
 * Process and render the HTML for the Shortcode.
 *
 * @since 1.0.0
 *
 * @param   array|string  $user_defined_attributes  User defined attributes for this shortcode instance
 * @param   string|null   $content                  Content between the opening and closing shortcode elements
 * @param   string        $shortcode_name           Name of the shortcode
 *
 * @return string
 */
function process_the_shortcode_callback( $user_defined_attributes, $content, $shortcode_name ) {

	d( COLLAPSIBLE_CONTENT_DIR );

	$config = get_shortcode_configuration( $shortcode_name );

	$attributes = shortcode_atts(
		$config['defaults'],
		$user_defined_attributes,
		$shortcode_name
	);

	if ( $config['processing_function'] ) {
		$function_name = $config['processing_function'];
		return $function_name( $config, $attributes, $content, $shortcode_name );
	}

	if ( $content && $config['shortcodes_within_content'] ) {
		$content =  do_shortcode( $content );
	}


	ob_start();
	include( $config['view'] );
	return ob_get_clean();
}

/**
 * Get the runtime configuration parameters for the specified shortcode.
 *
 * @since   0.0.1
 * @param   string      $shortcode_name     The name of the shortcode
 *
 * @return  array|false
 */
function get_shortcode_configuration( $shortcode_name ) {
	return _shortcode_configuration_store( $shortcode_name );
}

/**
 * Store the runtime configuration parameters for the specified shortcode into the static store.
 *
 * @since   0.0.1
 * @param   string  $shortcode_name     The name of the shortcode
 * @param   array   $config             Array of runtime configurations to store.
 *
 * @return  array|false
 */
function store_shortcode_configuration( $shortcode_name, $config ) {
	return _shortcode_configuration_store( $shortcode_name, $config );
}

/**
 * Shortcode configurations store.
 *
 * 1. Stores the configurations into a static array.
 * 2. Gets the configurations out of the store.
 *
 * @since   0.0.1
 *
 * @param   string        $shortcode_name   Name of the shortcode to be used as a key.
 * @param   array|bool    $config           Array of runtime configurations to store. (optional)
 *
 * @return mixed
 */
function _shortcode_configuration_store( $shortcode_name, $config = false ) {
	static $configurations = array();

	if ( ! isset( $configurations[ $shortcode_name ] ) ) {
		$configurations[ $shortcode_name ] = $config;
	}

	return $configurations[ $shortcode_name ];
}