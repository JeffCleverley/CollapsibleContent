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
namespace  Deftly\Module\FAQ\Custom;

add_action( 'init', __NAMESPACE__ . '\register_custom_post_types' );
/**
 * Register the custom FAQ post type.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_custom_post_types() {

	$my_custom_post_types_configs = [
		[   'slug'                  => 'faq',
		    'singular_name'         => 'FAQ',
		    'plural_name'           => 'FAQs',
		    'icon'                  => 'dashicons-format-chat',
		    'excluded_functions'    => array(
			    'excerpt',
			    'comments',
			    'trackbacks',
		    ) ],
	];

	foreach ( $my_custom_post_types_configs as $my_custom_post_type_config ) {

		$features = get_all_post_type_features_except_these( 'post', $my_custom_post_type_config['excluded_functions'] );

		$args = [
			'public'            => true,
			'labels'       		=> post_type_label_config(
				$my_custom_post_type_config['slug'],
				$my_custom_post_type_config['singular_name'],
				$my_custom_post_type_config['plural_name']
			),
			'supports'     		=> $features,
			'menu_icon'    		=> $my_custom_post_type_config['icon'],
			'hierarchical' 		=> false,
			'has_archive'  		=> true,
			'menu_position'		=> 5,
			'show_in_nav_menus'	=> true,
		];
		register_post_type( $my_custom_post_type_config['slug'], $args );
	}
}
/**
 * Get all the post type labels for the given post type.
 *
 * @since 	0.0.1
 *
 * @param   string  $post_type      provided by register_custom_post_types()
 * @param   string  $singular_label provided by register_custom_post_types()
 * @param   string  $plural_label   provided by register_custom_post_types()
 *
 * @return 	array
 */
function post_type_label_config( $post_type, $singular_label, $plural_label) {

	$text_domain = FAQ_MODULE_TEXT_DOMAIN;
	
	return [
		'name'                  => _x( $plural_label, 'post type general name', $text_domain ),
		'singular_name'      	=> _x( $singular_label, 'post type singular name', $text_domain ),
		'name_admin_bar'     	=> _x( $singular_label, 'add new on admin bar', $text_domain ),
		'add_new'            	=> _x( 'Add New ' . $singular_label, $post_type, $text_domain ),
		'add_new_item'       	=> __( 'Add New ' . $singular_label, $text_domain ),
		'new_item'           	=> __( 'New ' . $singular_label, $text_domain ),
		'edit_item'          	=> __( 'Edit ' . $singular_label, $text_domain ),
		'view_item'          	=> __( 'View ' . $singular_label, $text_domain ),
		'all_items'          	=> __( 'All ' . $plural_label, $text_domain ),
		'search_items'       	=> __( 'Search ' . $plural_label, $text_domain ),
		'parent_item_colon'  	=> __( 'Parent ' .  $plural_label . ':', $text_domain ),
		'not_found'          	=> __( 'No ' . $plural_label . ' found.', $text_domain ),
		'not_found_in_trash' 	=> __( 'No ' . $plural_label . ' found in Trash.', $text_domain ),
		'featured_image'        => __( $singular_label . ' Image', $text_domain ),
		'set_featured_image'    => __( 'Set ' . $singular_label . ' Image', $text_domain ),
		'remove_featured_image' => __( 'Remove ' . $singular_label . ' Image', $text_domain ),
		'use_featured_image'    => __( 'Use ' . $singular_label . ' Image', $text_domain ),
	];
}
/**
 * Get all the post type features for the given post type.
 *
 * @since 	0.0.1
 *
 * @param 	string 	$post_type 			Given post type
 * @param 	array 	$excluded_features 	Array of features to exclude
 *
 * @return 	array
 */
function get_all_post_type_features_except_these( $post_type = 'post', $excluded_features = array() ) {
	$configured_features = array_keys( get_all_post_type_supports( $post_type ) );

	if ( ! $excluded_features ) {
		return $configured_features;
	}

	return array_diff( $configured_features, $excluded_features );
}

add_filter( 'post_updated_messages', __NAMESPACE__ . '\update_custom_post_type_messages' );
/**
 * Update custom FAQ post type messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @since 	0.0.1
 *
 * @param 	array 	$messages Existing post update messages.
 *
 * @return 	array 	Amended post update messages with new CPT update messages.
 */
function update_custom_post_type_messages( $messages ) {

	$my_custom_post_types_slugs = [ 'faq', ];

	$post             = get_post();
	$post_type        = get_post_type( $post );

	if ( ! in_array( $post_type, $my_custom_post_types_slugs ) ) {
		return $messages;
	}

	foreach ( $my_custom_post_types_slugs as $key => $my_custom_post_type ) {

		$post_type_object = get_post_type_object( $post_type );
		$post_type_labels = $post_type_object->labels;
		$post_type_name   = $post_type_labels->singular_name;
		$text_domain = FAQ_MODULE_TEXT_DOMAIN;

		$messages[ $post_type ] = [
			0  => '', // Unused. Messages start at index 1.
			1  => __( $post_type_name . ' updated.', $text_domain ),
			2  => __( 'Custom field updated.', $text_domain ),
			3  => __( 'Custom field deleted.', $text_domain ),
			4  => __( $post_type_name . ' updated.', $text_domain ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( $post_type_name . ' restored to revision from %s', $text_domain ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( $post_type_name . ' published.', $text_domain ),
			7  => __( $post_type_name . ' saved.', $text_domain ),
			8  => __( $post_type_name . ' submitted.', $text_domain ),
			9  => sprintf(
				__( $post_type_name . ' scheduled for: <strong>%1$s</strong>.', $text_domain ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', $text_domain ), strtotime( $post->post_date ) )
			),
			10 => __( $post_type_name . ' draft updated.', $text_domain )
		];

		if ( $post_type_object->publicly_queryable ) {

			$permalink = get_permalink( $post->ID );
			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View ' . $post_type_name, $text_domain ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview ' . $post_type_name, $text_domain ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}
		return $messages;
	}
}
add_action('admin_head', __NAMESPACE__ . '\add_help_text_to_custom_post_type');
/**
 * Add help tab for custom post types
 * Remember to create the necessary views!
 *
 * Using add_help_tab method from WP_Screen comment_class
 * https://codex.wordpress.org/Class_Reference/WP_Screen/add_help_tab
 *
 * @since 	0.0.1
 *
 * @return 	void
 */
function add_help_text_to_custom_post_type() {

	$screen = get_current_screen();
	$post_type = $screen->post_type;

	$my_custom_post_types = [
		array(
			'slug'          => 'faq',
			'singular_name' => 'FAQ',
		),
	];

	if ( ! in_array( $post_type, array_column( $my_custom_post_types, 'slug' ) ) ) {
		return;
	}

	foreach( $my_custom_post_types as $key => $my_custom_post_type ) {
		if ( $my_custom_post_type['slug'] == $screen->post_type ) {

			$help_content = load_help_content(
				$my_custom_post_type['slug'],
				$my_custom_post_type['singular_name']
			);

			$config = array(
				'id'      => $my_custom_post_type['slug'] . '-help',
				'title'   => $my_custom_post_type['singular_name'] . ' Help',
				'content' => $help_content,
			);

			$screen->add_help_tab( $config );
		}
	}
}
/**
 * Function to load view into $configuration_content array as 'content' ^
 *
 * Loads html from separate views - remember to make them!
 *
 * @param   string  $custom_post_type       The custom post type slug from the add_help_text_to_custom_post_type() above.
 * @param   string  $custom_post_type_name  The custom post type singular name from the add_help_text_to_custom_post_type() above.
 *
 * @since 	0.0.1
 *
 * @return 	string 	$help_content 	HTML and Text from help view
 */
function load_help_content( $custom_post_type, $custom_post_type_name ) {

		$help_content = '';

		include( dirname( __FILE__ ) . '/../templates/views/' . $custom_post_type .'-help-view.php' );

		return $help_content;

}