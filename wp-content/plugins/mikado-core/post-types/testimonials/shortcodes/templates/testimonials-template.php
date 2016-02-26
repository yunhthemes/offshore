<div id="mkdf-testimonials<?php echo esc_attr($current_id) ?>" class="mkdf-testimonial-content">
	<?php if (has_post_thumbnail($current_id)) { ?>
		<div class="mkdf-testimonial-image-holder">
			<?php esc_html(the_post_thumbnail($current_id)) ?>
		</div>
	<?php } ?>
	<div class="mkdf-testimonial-content-inner">
		<div class="mkdf-testimonial-text-holder">
			<div class="mkdf-testimonial-text-inner">
				<p class="mkdf-testimonial-text"><?php echo trim($text) ?></p>
				<?php if ($show_author == "yes") { ?>
					<div class = "mkdf-testimonial-author">
						<p class="mkdf-testimonial-author-text"><?php echo esc_attr($author)?>
						</p>	
					</div>
				<?php } ?>				
			</div>
		</div>
	</div>	
</div>
