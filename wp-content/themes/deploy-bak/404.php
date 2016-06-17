<?php get_header(); ?>

	<?php deploy_mikado_get_title(); ?>

	<div class="mkdf-container">
	<?php do_action('deploy_mikado_after_container_open'); ?>
		<div class="mkdf-container-inner mkdf-404-page">
			<div class="mkdf-page-not-found">
				<div class="mkdf-404-image">
					<img src="<?php echo esc_url(get_template_directory_uri().'/assets/img/404.png') ?>" alt="<?php esc_attr_e('404', 'deploy'); ?>" />
				</div>
				<h2>
					<?php if(deploy_mikado_options()->getOptionValue('404_title')){
						echo esc_html(deploy_mikado_options()->getOptionValue('404_title'));
					}
					else{
						esc_html_e('Page Not Found.', 'deploy');
					} ?>
				</h2>
				<p>
					<?php if(deploy_mikado_options()->getOptionValue('404_text')){
						echo esc_html(deploy_mikado_options()->getOptionValue('404_text'));
					}
					else{
						esc_html_e('Keep Calm. Drink Coffee and Return to the Previous Page.', 'deploy');
					} ?>
				</p>
				<?php
					$params = array();
					if (deploy_mikado_options()->getOptionValue('404_back_to_home')){
						$params['text'] = deploy_mikado_options()->getOptionValue('404_back_to_home');
					}
					else{
						$params['text'] = "Back to Home Page";
					}
					$params['link'] = esc_url(home_url('/'));
					$params['target'] = '_self';
				echo deploy_mikado_execute_shortcode('mkdf_button',$params);?>
			</div>
		</div>
		<?php do_action('deploy_mikado_before_container_close'); ?>
	</div>
<?php get_footer(); ?>