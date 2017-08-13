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

	$labels = custom_label_generator( $user_cpt_config, $user_features['base_post_type'] );
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
function update_custom_post_type_messages( array $messages ) {
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

	foreach ( $user_cpt_configs as $key => $user_cpt_config ) {
		$post = get_post();
		$post_type = get_post_type( $post );
		if ( $post_type != $key ) {
			continue;
		}
		$messages = generate_messages_for_post_type( $key, $user_cpt_config, $post );
	}
	return $messages;
}

/**
 * Generate the messages for each post type.
 *
 * @since   0.0.1
 *
 * @param   string      $key                Post type slug
 * @param   array       $user_cpt_config    User configurations
 * @param   \WP_Post    $post               Post Object
 *
 * @return mixed
 */
function generate_messages_for_post_type( $key, array $user_cpt_config, \WP_post $post ) {

	$messages[ $key ] = [
		0   =>  '', // Unused. Messages start at index 1.
		1   =>   __( "{$user_cpt_config['labels']['singular_name']} updated.", $user_cpt_config['labels']['text_domain'] ),
		2   =>  __( 'Custom field updated.', $user_cpt_config['labels']['text_domain'] ),
		3   =>  __( 'Custom field deleted.', $user_cpt_config['labels']['text_domain'] ),
		4   =>  __( "{$user_cpt_config['labels']['singular_name']} updated.", $user_cpt_config['labels']['text_domain'] ),
		/* translators: %s: date and time of the revision */
		5   =>  isset( $_GET['revision'] ) ? sprintf( __( "{$user_cpt_config['labels']['singular_name']} restored to revision from %s", $user_cpt_config['labels']['text_domain'] ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6   =>  __( "{$user_cpt_config['labels']['singular_name']} published.", $user_cpt_config['labels']['text_domain'] ),
		7   =>  __( "{$user_cpt_config['labels']['singular_name']} saved.", $user_cpt_config['labels']['text_domain'] ),
		8   =>  __( "{$user_cpt_config['labels']['singular_name']} submitted.", $user_cpt_config['labels']['text_domain'] ),
		9   =>  sprintf(
			__( $user_cpt_config['labels']['singular_name'] . ' scheduled for: <strong>%1$s</strong>.', $user_cpt_config['labels']['text_domain'] ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', $user_cpt_config['labels']['text_domain'] ), strtotime( $post->post_date ) )
		),
		10  =>  __( "{$user_cpt_config['labels']['singular_name']} draft updated.", $user_cpt_config['labels']['text_domain'] )
	];

	$post_type_object = get_post_type_object( $key );
	if ( $post_type_object->publicly_queryable ) {
		$permalink  =   get_permalink( $post->ID );
		$view_link  =   sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( "View {$user_cpt_config['labels']['singular_name']}", $user_cpt_config['labels']['text_domain'] ) );
		$messages[ $key ][1]  .=  $view_link;
		$messages[ $key ][6]  .=  $view_link;
		$messages[ $key ][9]  .=  $view_link;

		$preview_permalink  =   add_query_arg( 'preview', 'true', $permalink );
		$preview_link       =   sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( "Preview {$user_cpt_config['labels']['singular_name']}", $user_cpt_config['labels']['text_domain'] ) );
		$messages[ $key ][8]  .=  $preview_link;
		$messages[ $key ][10] .=  $preview_link;
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
	$user_cpt_configs = apply_filters( 'add_custom_post_type_runtime_config', array() );
	if ( ! $user_cpt_configs ) {
		return $bulk_messages;
	}

	foreach ( $user_cpt_configs as $key => $user_cpt_config ) {
		$post_type = get_post_type( get_post() );
		if ( $post_type != $key ) {
			continue;
		}
		$bulk_messages = generate_bulk_messages_for_post_type( $key, $user_cpt_config, $bulk_counts );
	}

	return $bulk_messages;
}

/**
 * Generate bulk messages for each post type.
 *
 * @since   0.0.1
 *
 * @param   string  $key
 * @param   array   $user_cpt_config
 * @param   array   $bulk_counts
 *
 * @return mixed
 */
function generate_bulk_messages_for_post_type( $key, array $user_cpt_config, array $bulk_counts ) {

		$bulk_messages[ $key ] = array(
			'updated'   => _n( "%s {$user_cpt_config['labels']['singular_name']} updated.", "%s {$user_cpt_config['labels']['plural']} updated.", $bulk_counts["updated"], $user_cpt_config['labels']['text_domain'] ),
			'locked'    => _n( "%s {$user_cpt_config['labels']['singular_name']} not updated, somebody is editing it.", "%s {$user_cpt_config['labels']['plural']} not updated, somebody is editing them.", $bulk_counts["locked"], $user_cpt_config['labels']['text_domain'] ),
			'deleted'   => _n( "%s {$user_cpt_config['labels']['singular_name']} permanently deleted.", "%s {$user_cpt_config['labels']['plural']} permanently deleted.", $bulk_counts["deleted"], $user_cpt_config['labels']['text_domain'] ),
			'trashed'   => _n( "%s {$user_cpt_config['labels']['singular_name']} moved to the Trash.", "%s {$user_cpt_config['labels']['plural']} moved to the Trash.", $bulk_counts["trashed"], $user_cpt_config['labels']['text_domain'] ),
			'untrashed' => _n( "%s {$user_cpt_config['labels']['singular_name']} restored from the Trash.", "%s {$user_cpt_config['labels']['plural']} restored from the Trash.", $bulk_counts["untrashed"], $user_cpt_config['labels']['text_domain'] ),
		);
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

		if ( $key != $post_type ) {
			continue;
		}

		$user_cpt_config['labels']['title_placeholder'] == 0
			? $title = "Enter a new {$user_cpt_config['labels']['singular_name']} title here..."
			: $title = $user_cpt_config['labels']['title_placeholder'];

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
		$array_to_test_if_configs_empty = array_filter( $user_help_configs );
		if ( empty( $array_to_test_if_configs_empty ) ) {
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
 * @param   array   $user_help_configs
 * @param   array   $user_cpt_config
 * @param   string  $screen
 *
 * @return void
 */
function generate_help_tab_content( array $user_help_configs, array $user_cpt_config, $screen ) {
	foreach ($user_help_configs as $user_help_config) {
		$help_content = load_help_content( $user_cpt_config, $user_help_config );
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
 * @param   array  $user_cpt_config        The custom post type slug from the add_help_text_to_custom_post_type() above.
 * @param   array  $user_help_config       The custom post type singular name from the add_help_text_to_custom_post_type() above.
 * @parem   string  $text_domain            Text domain for internationalisation.
 *
 * @since 	0.0.1
 *
 * @return 	string 	$help_content 	HTML and Text from help view
 */
function load_help_content( array $user_cpt_config, array $user_help_config ) {
	$obj = get_post_type_object( $user_cpt_config['labels']['slug'] );
	$description = esc_html( $obj->description );
	$help_top_header        = __( $user_help_config['help_title'], $user_cpt_config['labels']['text_domain'] );
	$help_description       = __( $description, $user_cpt_config['labels']['text_domain'] );
	$help_content           = __( $user_help_config['help_content'], $user_cpt_config['labels']['text_domain'] );
	$more_information_header = __('For more information:', $user_cpt_config['labels']['text_domain'] );
	$help_link = __('<a href="' . $user_help_config['help_link'] . '" target="_blank">' . $user_cpt_config['labels']['singular_name'] . ' Module Documentation</a>', $user_cpt_config['labels']['text_domain'] );

	ob_start();
	include( dirname( __FILE__ ) . "/views/help-view.php" );
	return ob_get_clean();
}


