<?php
/**
 * FAQ Custom Taxonomiy Handler
 *
 * @package     Deftly\Module\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace Deftly\Module\FAQ\Custom;

add_action( 'add_custom_taxonomy_runtime_config', __NAMESPACE__ . '\register_faq_custom_taxonomy' );
/**
 * Register the custom FAQ taxonomies.
 *
 * @since   0.0.1
 *
 * @return  void
 */
function register_faq_custom_taxonomy() {
	$config = include( COLLAPSIBLE_CONTENT_DIR . 'config/faq/taxonomy.php' );

	if ( ! $config ) {
		return;
	}

	$configs[ $config['labels']['slug'] ] = $config;

	return $configs;
}
