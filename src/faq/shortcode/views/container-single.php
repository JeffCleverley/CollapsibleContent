<?php namespace  Deftly\Module\FAQ\Shortcode; ?>
<section class ="collapisible-content--term-container faq-id--<?php esc_attr_e( $attributes['post_id'] )?>">
    <dl class="collapsible-content--container faq">
		<?php include( $config['views']['faq'] ); ;?>
	</dl>
</section>