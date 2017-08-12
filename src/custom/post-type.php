<?php
/**
 * FAQ Custom Post Types Generator
 *
 * @package     Deftly\Module\Custom
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace Deftly\Module\Custom;

add_action( 'init', __NAMESPACE__ . '\register_custom_post_types' );
/**
 * Register the custom post types hooked in with runtime config.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_custom_post_types() {
	/*
	 * Add custom post type runtime configurations from generating and registering
	 * each with WordPress
	 *
	 * @since   0.0.1
	 *
	 * @param   array   Array of configurations
	 */
	$user_cpt_configs = (array) apply_filters( 'add_custom_post_type_runtime_config', array() );
	if ( ! $user_cpt_configs ) {
		return;
	}
	foreach ( $user_cpt_configs as $post_type => $user_cpt_config ) {
		register_custom_post_type( $post_type, $user_cpt_config );
	}
}

/**
 * Register each custom post type
 *
 * @since   0.0.1
 *
 * @param   string  $post_type
 * @param   array   $user_cpt_config
 */
function register_custom_post_type( $post_type, array $user_cpt_config ) {

	$args = $user_cpt_config['args'];
	$user_features = $user_cpt_config['features'];

	if ( $args['hierarchical'] ) {
		$user_features['base_post_type'] = 'page';
	}

	$features = generate_all_post_type_features(
		$user_features['excluded_features'],
		$user_features['additional_features'],
		$user_features['base_post_type']
	);
	$args['supports'] = $features;

	$labels = post_type_label_config( $user_cpt_config['labels'] );
	$args['labels'] = $labels;

	register_post_type( $post_type, $args );
}

/**
 * Generate all the post type features for the given post type.
 *
 * @since 	0.0.1
 *
 * @param 	array 	$excluded_features 	    Array of features to exclude
 * @param   array   $additional_features    Array of additional features to include
 * @param 	string 	$post_type 			    Given post type
 *
 * @return 	array
 */
function generate_all_post_type_features( $excluded_features = array(), $additional_features = array(), $post_type = 'post' ) {
	$base_post_type_features = array_keys( get_all_post_type_supports( $post_type ) );

	if ( ! $excluded_features && ! $additional_features ) {
		return $base_post_type_features;
	}

	$features = $base_post_type_features;

	if ( $excluded_features ) {
		$features = array_diff( $features, $excluded_features );
	}
	if ( $additional_features ) {
		$features  = array_merge( $features, $additional_features );
	}

	return $features ;
}

/**
 * Get all the post type labels for the given post type.
 *
 * @since 	0.0.1
 *
 * @param   array  $labels      provided by register_custom_post_types() from custom_configs.php
 *
 * @return 	array
 */
function post_type_label_config( $labels ) {
	$plural_label = $labels['plural_name'];
	$singular_label = $labels['singular_name'];
	$post_type = $labels['slug'];
	$text_domain = $labels['text_domain'];
	$in_sentence_singular = $singular_label;
	$in_sentence_plural = $plural_label;

	if ( $labels ['lowercase_in_sentence'] ) {
		$in_sentence_singular = mb_strtolower( $singular_label, 'UTF-8' );
		$in_sentence_plural = mb_strtolower( $plural_label, 'UTF-8' );
	}

	return [
		'name'                  => _x( $plural_label, 'post type general name', $text_domain ),
		'singular_name'      	=> _x( $singular_label, 'post type singular name', $text_domain ),
		'name_admin_bar'     	=> _x( $singular_label, 'add new on admin bar', $text_domain ),
		'add_new'            	=> _x( "Add New {$singular_label}", $post_type, $text_domain ),
		'add_new_item'       	=> __( "Add New {$singular_label}", $text_domain ),
		'new_item'           	=> __( "New {$singular_label}", $text_domain ),
		'edit_item'          	=> __( "Edit {$singular_label}", $text_domain ),
		'view_item'          	=> __( "View {$singular_label}", $text_domain ),
		'view_items'          	=> __( "View {$plural_label}", $text_domain ),
		'all_items'          	=> __( "All {$plural_label}", $text_domain ),
		'archives'          	=> __( "{$singular_label} Archives", $text_domain ),
		'attributes'          	=> __( "{$singular_label} Attributes", $text_domain ),
		'insert_into_item'      => __( "Insert in to {$in_sentence_singular}", $text_domain ),
		'uploaded_to_this_item' => __( "Uploaded to this {$in_sentence_singular}", $text_domain ),
		'search_items'       	=> __( "Search {$in_sentence_plural}", $text_domain ),
		'parent_item_colon'  	=> __( "Parent {$in_sentence_plural}:", $text_domain ),
		'not_found'          	=> __( "No {$in_sentence_plural} found.", $text_domain ),
		'not_found_in_trash' 	=> __( "No {$in_sentence_plural} found in Trash.", $text_domain ),
		'featured_image'        => __( "{$singular_label} Image", $text_domain ),
		'set_featured_image'    => __( "Set {$in_sentence_singular} image", $text_domain ),
		'remove_featured_image' => __( "Remove {$in_sentence_singular} image", $text_domain ),
		'use_featured_image'    => __( "Use {$in_sentence_singular} image", $text_domain ),
	];
}

add_filter( 'post_updated_messages', __NAMESPACE__ . '\update_custom_post_type_messages' );
/**
 * Update custom post type messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @since 	0.0.1
 *
 * @param 	array 	$messages   Existing post update messages.
 *
 * @return 	array 	$messages   Amended post update messages with new CPT update messages.
 */
function update_custom_post_type_messages( $messages ) {
	/*
	 * Add custom post type runtime configurations from generating and registering
	 * each with WordPress
	 *
	 * @since   0.0.1
	 *
	 * @param   array   Array of configurations
	 */
	$user_cpt_configs = apply_filters( 'add_custom_post_type_runtime_config', array() );

	if ( ! $user_cpt_configs ) {
		return $messages;
	}

	$post       = get_post();
	$post_type  = get_post_type( $post );
	$slug_array = array();
	foreach ($user_cpt_configs as $user_cpt_config) {
		$slug_array[] = $user_cpt_config['labels']['slug'];
	}
	if ( ! in_array( $post_type, $slug_array ) ) {
		return $messages;
	}

	foreach ( $user_cpt_configs as $key => $user_cpt_config ) {
		$post_type_object   =   get_post_type_object( $post_type );
		$post_type_labels   =   $post_type_object->labels;
		$post_type_name     =   $post_type_labels->singular_name;
		$text_domain        =   $user_cpt_config['labels']['text_domain'];

		$messages[ $post_type ] = [
			0   =>  '', // Unused. Messages start at index 1.
			1   =>   __( "{$post_type_name} updated.", $text_domain ),
			2   =>  __( 'Custom field updated.', $text_domain ),
			3   =>  __( 'Custom field deleted.', $text_domain ),
			4   =>  __( "{$post_type_name} updated.", $text_domain ),
			/* translators: %s: date and time of the revision */
			5   =>  isset( $_GET['revision'] ) ? sprintf( __( "{$post_type_name} restored to revision from %s", $text_domain ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6   =>  __( "{$post_type_name} published.", $text_domain ),
			7   =>  __( "{$post_type_name} saved.", $text_domain ),
			8   =>  __( "{$post_type_name} submitted.", $text_domain ),
			9   =>  sprintf(
					__( $post_type_name . ' scheduled for: <strong>%1$s</strong>.', $text_domain ),
					// translators: Publish box date format, see http://php.net/date
					date_i18n( __( 'M j, Y @ G:i', $text_domain ), strtotime( $post->post_date ) )
					),
			10  =>  __( "{$post_type_name} draft updated.", $text_domain )
		];

		if ( $post_type_object->publicly_queryable ) {
			$permalink  =   get_permalink( $post->ID );
			$view_link  =   sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( "View {$post_type_name}", $text_domain ) );
			$messages[ $post_type ][1]  .=  $view_link;
			$messages[ $post_type ][6]  .=  $view_link;
			$messages[ $post_type ][9]  .=  $view_link;

			$preview_permalink  =   add_query_arg( 'preview', 'true', $permalink );
			$preview_link       =   sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( "Preview {$post_type_name}", $text_domain ) );
			$messages[ $post_type ][8]  .=  $preview_link;
			$messages[ $post_type ][10] .=  $preview_link;
		}
	}
	return $messages;
}

add_filter( 'bulk_post_updated_messages', __NAMESPACE__ . '\update_custom_post_type_bulk_messages', 10, 2 );
/**
 * Update custom post type bulk action messages.
 *
 * See /wp-admin/edit.php
 *
 * @since   0.0.1
 *
 * @param   array   $bulk_messages
 * @param   array   $bulk_counts
 *
 * @return mixed
 */
function update_custom_post_type_bulk_messages( $bulk_messages, $bulk_counts ) {
	/*
	 * Add custom post type runtime configurations from generating and registering
	 * each with WordPress
	 *
	 * @since   0.0.1
	 *
	 * @param   array   Array of configurations
	 */
	$user_cpt_configs = (array) apply_filters( 'add_custom_post_type_runtime_config', array() );
	if ( ! $user_cpt_configs ) {
		return $bulk_messages;
	}

	$post      = get_post();
	$post_type = get_post_type( $post );
	foreach ( $user_cpt_configs as $user_cpt_config ) {
		$slug_array[] = $user_cpt_config['labels']['slug'];
	}
	if ( ! in_array( $post_type, $slug_array ) ) {
		return $bulk_messages;
	}

	foreach ( $user_cpt_configs as $key => $user_cpt_config ) {
		$post_type_object      = get_post_type_object( $post_type );
		$post_type_labels      = $post_type_object->labels;
		$post_type_name        = $post_type_labels->singular_name;
		$post_type_plural_name = $post_type_labels->plural_name;
		$text_domain           = $user_cpt_config['labels']['text_domain'];

		$bulk_messages[ $post_type ] = array(
			'updated'   => _n( "%s {$post_type_name} updated.", "%s {$post_type_plural_name} updated.", $bulk_counts["updated"], $text_domain ),
			'locked'    => _n( "%s {$post_type_name} not updated, somebody is editing it.", "%s {$post_type_plural_name} not updated, somebody is editing them.", $bulk_counts["locked"], $text_domain ),
			'deleted'   => _n( "%s {$post_type_name} permanently deleted.", "%s {$post_type_plural_name} permanently deleted.", $bulk_counts["deleted"], $text_domain ),
			'trashed'   => _n( "%s {$post_type_name} moved to the Trash.", "%s {$post_type_plural_name} moved to the Trash.", $bulk_counts["trashed"], $text_domain ),
			'untrashed' => _n( "%s {$post_type_name} restored from the Trash.", "%s {$post_type_plural_name} restored from the Trash.", $bulk_counts["untrashed"], $text_domain ),
		);
	}

	return $bulk_messages;
}

add_filter( 'enter_title_here', __NAMESPACE__ . '\change_add_title_placeholder');
/**
 * Change placeholder text in Title field.
 *
 * since    0.0.1
 *
 * @param   string  $title
 *
 * @return  string   $title  placeholder text
 */
function change_add_title_placeholder( $title ) {
	/*
	 * Add custom post type runtime configurations from generating and registering
	 * each with WordPress
	 *
	 * @since   0.0.1
	 *
	 * @param   array   Array of configurations
	 */
	$user_cpt_configs = apply_filters( 'add_custom_post_type_runtime_config', array() );
	if ( ! $user_cpt_configs ) {
		return $title;
	}

	$screen     = get_current_screen();
	$post_type  = $screen->post_type;

	foreach( $user_cpt_configs as $key => $user_cpt_config ) {
		if ( $user_cpt_config['labels']['slug'] == $post_type && ! $user_cpt_config['labels']['title_placeholder'] ) {
			$title = "Enter a new {$user_cpt_config['labels']['singular_name']} title here...";
		} elseif ( $user_cpt_config['labels']['slug'] == $post_type && $user_cpt_config['labels']['title_placeholder']) {
			$title = $user_cpt_config['labels']['title_placeholder'];
		}
	}
	return $title;
};

add_action('admin_head', __NAMESPACE__ . '\add_help_tab_to_custom_post_type');
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
function add_help_tab_to_custom_post_type() {
	/*
	 * Add custom post type runtime configurations from generating and registering
	 * each with WordPress
	 *
	 * @since   0.0.1
	 *
	 * @param   array   Array of configurations
	 */
	$user_cpt_configs = apply_filters( 'add_custom_post_type_runtime_config', array() );
	if ( ! $user_cpt_configs ) {
		return;
	}

	$screen     = get_current_screen();
	$post_type  = $screen->post_type;

	foreach( $user_cpt_configs as $key => $user_cpt_config ) {
		$user_help_configs = $user_cpt_config['help'];
		$configs_array_to_test_if_empty = array_filter( $user_help_configs );
		if ( empty( $configs_array_to_test_if_empty ) ) {
			continue;
		}
		if ( $user_cpt_config['labels']['slug'] == $post_type ) {
			generate_help_tab_content( $user_help_configs, $user_cpt_config, $screen );
		}
	}
}

/**
 * Generate the content for the help tab
 *
 * @param $user_help_configs
 * @param $user_cpt_config
 * @param $screen
 *
 * @return void
 */
function generate_help_tab_content( $user_help_configs, $user_cpt_config, $screen ) {
	foreach ($user_help_configs as $user_help_config) {
		$help_content = load_help_content(
			$user_cpt_config['labels']['slug'],
			$user_cpt_config['labels']['singular_name'],
			$user_cpt_config['labels']['text_domain'],
			$user_help_config['help_title'],
			$user_help_config['help_content'],
			$user_help_config['help_link']
		);
		$config = array(
			'id'      => "{$user_help_config['help_tab_id']}",
			'title'   => "{$user_help_config['help_title']}",
			'content' => $help_content,
		);
		$screen->add_help_tab( $config );
	}
}

/**
 * Function to load view into $configuration_content array as 'content' ^
 *
 * Loads html from separate views - remember to make them!
 *
 * @param   string  $custom_post_type       The custom post type slug from the add_help_text_to_custom_post_type() above.
 * @param   string  $custom_post_type_name  The custom post type singular name from the add_help_text_to_custom_post_type() above.
 * @parem   string  $text_domain            Text domain for internationalisation.
 *
 * @since 	0.0.1
 *
 * @return 	string 	$help_content 	HTML and Text from help view
 */
function load_help_content( $custom_post_type, $custom_post_type_name, $text_domain, $help_title, $help_content, $help_link ) {
	$obj = get_post_type_object( $custom_post_type );
	$description = esc_html( $obj->description );
	$help_top_header        = __("{$help_title}", $text_domain );
	$help_description       = __( $description, $text_domain );
	$help_content           = __( $help_content, $text_domain );
	$more_information_header = __('For more information:', $text_domain );
	$help_link = __('<a href="' . $help_link . '" target="_blank">' . $custom_post_type_name . ' Module Documentation</a>', $text_domain );

	ob_start();
	include( dirname( __FILE__ ) . "/views/help-view.php" );
	return ob_get_clean();
}


