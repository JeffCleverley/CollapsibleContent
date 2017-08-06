<?php
/**
 * Template Archive Helper
 *
 * @package     Deftly\Module\FAQ\Templates
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\Module\FAQ\Templates;
use Deftly\Module\FAQ\Custom;

add_filter( 'archive_template', __NAMESPACE__ . '\load_the_faq_archive_template' );
/**
 * Load the new Custom Post Type archives from the plugin.
 * Use configs from Custom\custom_post_type_configs().
 *
 * REMEMBER to make /arhive-{slug}.php templates for each CPT.
 *
 * @since   0.0.1
 *
 * @param   string   $archive_template
 *
 * @return  string
 */
function load_the_faq_archive_template( $archive_template ) {
	$cpt_configs = Custom\custom_post_type_configs();
	if ( ! $cpt_configs ) {
		return $archive_template;
	}

	foreach ( $cpt_configs as $cpt_config ) {
		if ( ! is_post_type_archive( $cpt_config['slug'] ) ) {
			return $archive_template;
		}

		$plugin_archive_template = __DIR__ . "/archive-{$cpt_config['slug']}.php";
		$is_in_archive_template = strpos( $archive_template, "/archive-{$cpt_config['slug']}.php");
		if ( ! $archive_template || ! $is_in_archive_template ) {
			return $plugin_archive_template;
		}

		return $archive_template;
	}
}