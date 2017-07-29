<div class="teaser--container" itemscope itemtype="http://schema.org/BlogPosting">
	<div class="teaser--visible_message" itemprop="headline" data-show-icon="<?php echo $attributes['show_icon']; ?>" data-hide-icon="<?php esc_attr_e( $attributes['hide_icon'] ); ?>">
		<span class="<?php echo $attributes['show_icon']; ?>" aria-hidden="true">
			<span class="screen-reader-text">Click to reveal the content</span>
		</span>
		<?php esc_html_e( $attributes['visible_message'] ); ?>
	</div>
	<div class="teaser--hidden-content" itemprop="description" style="display: none;">
		<?php echo $hidden_content; ?>
	</div>
</div>