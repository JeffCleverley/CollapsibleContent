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

/**
 * Process the FAQ Shortcode to display FAQ by ID or by Topic
 *
 * @since 1.0.0
 *
 * @param   array           $config             Array of runtime configurations parameters
 * @param   array           $attributes         Attributes for this shortcode instance
 * @param   string|null     $content            Content between the opening and closing shortcode elements
 * @param   string          $shortcode_name     Name of the shortcode
 *
 * @return  string
 */
function process_the_faq_shortcode( array $config, array $attributes, $content, $shortcode_name ) {

	$attributes['post_id']  =  (int) $attributes['post_id'];

	if ( $attributes['post_id'] < 1 && ! $attributes['topic_slug'] ) {
		return '';
	}

	ob_start();
	$attributes['post_id'] > 0
		? render_single_faq( $attributes, $config )
		: render_topic_faqs( $attributes, $config );
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

	include( $config['view']['container'] );

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
		'post_type'         =>  'faq',
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

	include( $config['view']['container'] );

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

		include( $config['view']['faq'] );

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
