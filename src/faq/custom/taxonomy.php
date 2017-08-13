<?php
/**
 * FAQ Custom Taxonomy Handler
 *
 * @package     Deftly\Module\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace Deftly\Module\FAQ\Custom;

//add_action( 'add_custom_taxonomy_runtime_config', __NAMESPACE__ . '\register_faq_topic_taxonomy' );
/**
 * Register the custom FAQ taxonomies.
 *
 * @since   0.0.1
 *
 * @param array $configs
 *
 * @return array $configs
 */
function register_faq_topic_taxonomy( array $configs) {
	$configurations = include( COLLAPSIBLE_CONTENT_DIR . 'config/faq/taxonomy.php' );

	foreach ( $configurations as $config ) {
		$configs[ $config['labels']['slug'] ] = $config;
	}

	return $configs;
}

