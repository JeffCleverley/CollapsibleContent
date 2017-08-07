<?php
use \Deftly\Module\FAQ\Templates as Templates;
use \Deftly\Module\FAQ\Shortcode as Shortcode;
?>

<?php if ( isset( $use_term_container ) && $use_term_container ) : ?>
<section class ="collapisible-content--term-container faq faq-topic--<?php esc_attr_e( $term_slug )?>">
<?php endif; ?>

<?php if ( isset( $show_term_name ) && $show_term_name ) : ?>
    <span class="collapsible-content--visible">
		<h2>
			<span class="collapsible-content--icon <?php echo $attributes['show_icon']; ?>" aria-hidden="true" data-show-icon="<?php echo $attributes['show_icon']; ?>" data-hide-icon="<?php esc_attr_e( $attributes['hide_icon'] ); ?>">
				<span class="screen-reader-text">Click to reveal the answer</span>
			</span>
			<?php esc_html_e( $record['term_name'] ); ?>
		</h2>
    </span>
<?php endif; ?>

	<dl class="collapsible-content--container faq">
        <?php
        if ( $is_calling_source === 'template' ) {
	        Templates\loop_and_render_faqs( $record['posts'] );

        } elseif ( $is_calling_source === 'shortcode-by-topic' ) {
	        Shortcode\loop_and_render_faqs_by_topic( $query, $attributes, $config );

        } else {
	        include( __DIR__ . '/faq.php' );
        }
        ?>
	</dl>

<?php if ( isset( $use_term_container ) && $use_term_container ) : ?>
</section>
<?php endif; ?>