<?php namespace  Deftly\Module\FAQ\Templates; ?>
<section class ="collapisible-content--term-container faq faq-topic--<?php esc_attr_e( $record['term_slug'] )?>">
	<span class="collapsible-content--visible">
		<h2>
			<span class="collapsible-content--icon <?php echo $attributes['show_icon']; ?>" aria-hidden="true" data-show-icon="<?php echo $attributes['show_icon']; ?>" data-hide-icon="<?php esc_attr_e( $attributes['hide_icon'] ); ?>">
				<span class="screen-reader-text">Click to reveal the answer</span>
			</span>
			<?php esc_html_e( $record['term_name'] ); ?>
		</h2>
	</span>
	<dl class="collapsible-content--container collapsible-content--hidden faq" style="display: none;">
		<?php loop_and_render_faqs( $record['posts'] ) ;?>
	</dl>
</section>