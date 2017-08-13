<?php
/**
 * FAQ Shortcode Processing.
 *
 * @package     Deftly\Module\FAQ\Shortcode
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/Modules
 * @license     GNU General Public License 2.0+
 *
 */
namespace  Deftly\Module\FAQ\Shortcode;

add_shortcode( 'custom', __NAMESPACE__ . '\process_the_shortcode' );
/**
 * Process the FAQ Shortcode to display FAQ by ID or by Topic
 *
 * @since 1.0.0
 *
 * @param   array|string  $user_defined_attributes  User defined attributes for this shortcode instance
 * @param   string|null   $content                  Content between the opening and closing shortcode elements
 * @param   string        $shortcode_name           Name of the shortcode
 *
 * @return  string
 */
function process_the_shortcode( $user_defined_attributes, $content, $shortcode_name ) {
	$config = get_shortcode_configuration();
	$attributes = shortcode_atts(
		$config['defaults'],
		$user_defined_attributes,
		$shortcode_name
	);

	$attributes['post_id']  =  (int) $attributes['post_id'];
	if ( $attributes['post_id'] < 1 && ! $attributes['topic_slug'] ) {
		return '';
	}

	ob_start();
	if ( $attributes['post_id'] > 0 ) {
		render_single_faq( $attributes, $config );
	} else {
		render_topic_faqs( $attributes, $config );
	}
	return ob_get_clean();
}

/**
 * Render the single FAQ.
 *
 * @since   0.0.1
 *
 * @param   array   $attributes
 * @param   array   $config
 *
 * @return  void
 */
function render_single_faq( array $attributes, array $config ) {
	$faq = get_post( $attributes['post_id'] );
	if ( ! $faq ) {
		return render_none_found_message( $attributes );
	}

	$is_calling_source  = 'shortcode-single-custom';
	$use_term_container = false;
	$post_title         = $faq->post_title;
	$hidden_content     = do_shortcode( $faq->post_content );

	include( $config['views']['container'] );

}

/**
 * Process the Topic FAQs
 *
 * @since   0.0.1
 *
 * @param   array $attributes
 * @param   array $config
 *
 * @return  void
 */
function render_topic_faqs( array $attributes, array $config ) {

	$config_args = array(
		'post_type'         =>  'custom',
		'posts_per_page'    =>  10,
		'order'             =>  $attributes['order'],
		'orderby'           =>  $attributes['orderby'],
		'nopaging'          =>  true,
		'no_found_rows'     =>  true,
		'tax_query'         =>  array(
			[
				'taxonomy'      =>  'topic',
				'field'         =>  'slug',
				'terms'         =>  $attributes['topic_slug'],
			],
		)

	);

	$query = new \WP_Query( $config_args );
	if ( ! $query->have_posts() ) :
		return render_none_found_message( $attributes, false );
	endif;

	$is_calling_source  = 'shortcode-by-topic';
	$use_term_container = true;
	$term_slug = $attributes['topic_slug'];

	include( $config['views']['container'] );

	wp_reset_postdata();
}

/**
 * Loop through the query and render out the FAQs by topic.
 *
 * @since   0.0.1
 *
 * @param   \WP_Query   $query
 * @param   array       $attributes
 * @param   array       $config
 *
 * @return  void
 */
function loop_and_render_faqs_by_topic( \WP_Query $query, array $attributes, array $config ) {
	while ( $query->have_posts() ) :
		$query->the_post();

		$post_title = get_the_title();
		$hidden_content = do_shortcode( get_the_content() );

		include( $config['views']['custom'] );

	endwhile;
}

/**
 * Render none found message handler
 *
 * @since   0.0.1
 *
 * @param   array   $attributes
 * @param   bool    $is_single_faq
 *
 * @return  void
 */
function render_none_found_message( array $attributes, $is_single_faq = true ) {

	if ( ! $attributes['show_none_found_message'] ) {
		return;
	}

	$message = $is_single_faq
		? $attributes['none_found_single']
		: $attributes['none_found_by_topic'];

	echo "<p>{$message}</p>";
}

/**
 * Get the runtime configuration parameters for the specified shortcode.
 *
 * @since   0.0.1
 *
 * @return  array
 */
function get_shortcode_configuration() {
	return array(
		'views'     =>  [
			'container' =>  FAQ_MODULE_DIR . '/views/container.php',
			'custom'       =>  FAQ_MODULE_DIR . '/views/custom.php',
		],
		'defaults'  =>  [
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
		],
	);
}