<?php if(deploy_mikado_options()->getOptionValue('blog_single_navigation') == 'yes'){ ?>
	<?php $navigation_blog_through_category = deploy_mikado_options()->getOptionValue('blog_navigation_through_same_category') ?>
	<div class="mkdf-blog-single-navigation">
		<div class="mkdf-blog-single-navigation-inner clearfix">
			<?php if($has_prev_post) : ?>
				<div class="mkdf-blog-single-prev clearfix <?php if($prev_post_has_image) { echo esc_attr('mkdf-single-nav-with-image'); } ?>">
					<?php if($prev_post_has_image) : ?>
						<div class="mkdf-single-nav-image-holder">
							<a href="<?php echo esc_url($prev_post['link']); ?>">
								<?php echo deploy_mikado_kses_img($prev_post['image']); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="mkdf-single-nav-content-holder">
						<h6>
							<a href="<?php echo esc_url($prev_post['link']); ?>">
								<?php echo esc_html($prev_post['title']); ?>
							</a>
						</h6>
						<a href="<?php echo esc_url($prev_post['link']) ?>">
							<?php echo deploy_mikado_icon_collections()->renderIcon('icon-arrow-left-circle', 'simple_line_icons') ?>
							<span><?php esc_html_e('Previous', 'deploy') ?></span>
						</a>
					</div>
				</div> <!-- close div.blog_prev -->
			<?php endif; ?>
			<?php if($has_next_post) : ?>
				<div class="mkdf-blog-single-next clearfix <?php if($next_post_has_image) { echo esc_attr('mkdf-single-nav-with-image'); } ?>">
					<?php if($next_post_has_image) : ?>
						<div class="mkdf-single-nav-image-holder">
							<a href="<?php echo esc_url($next_post['link']); ?>">
								<?php echo deploy_mikado_kses_img($next_post['image']); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="mkdf-single-nav-content-holder">
						<h6>
							<a href="<?php echo esc_url($next_post['link']); ?>">
								<?php echo esc_html($next_post['title']); ?>
							</a>
						</h6>
						<a href="<?php echo esc_url($next_post['link']) ?>">
							<span><?php esc_html_e('Next', 'deploy') ?></span>
							<?php echo deploy_mikado_icon_collections()->renderIcon('icon-arrow-right-circle', 'simple_line_icons') ?>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php } ?>