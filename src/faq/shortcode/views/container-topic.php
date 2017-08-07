<?php namespace  Deftly\Module\FAQ\Shortcode; ?>
<section class ="collapisible-content--term-container faq-topic--<?php esc_attr_e( $attributes['topic_slug'] )?>">
    <dl class="collapsible-content--container faq">
		<?php loop_and_render_faqs_by_topic( $query, $attributes, $config ) ;?>
	</dl>
</section>