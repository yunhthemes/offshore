<?php
class DeployMikadoLanguageDropdown extends WP_Widget {

	/**
	 * PiquantMikadoLanguageDropdown constructor.
	 */
	public function __construct() {
		parent::__construct(
			'mkdf_language_dropdown', // Base ID
			'Mikado Language Dropdown' // Name
		);
	}

	public function widget($args, $instance) {
		$languages       = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
		$active_language = '';

		if(is_array($languages) && count($languages)) {
			foreach($languages as $language_key => $language) {
				if($language['active'] == 1) {
					$active_language = $language;
					unset($languages[$language_key]);

					break;
				}
			} ?>

			<?php print $args['before_widget']; ?>

			<div class="mkdf-language-dropdown">
				<div class="mkdf-ld-current-lang-holder">
					<a class="mkdf-ld-current-lang" href="javascript: void(0)">
						<?php echo esc_html($active_language['code']); ?>
						<img width="18" height="12" src="<?php echo esc_url($active_language['country_flag_url']); ?>" alt="<?php echo esc_attr($active_language['translated_name']); ?>">
					</a>
				</div>
				<?php if(is_array($languages) && count($languages)) : ?>
					<ul class="mkdf-ld-lang-list">
						<?php foreach($languages as $language_key => $language) : ?>
							<li class="mkdf-ld-item">
								<a href="<?php echo esc_url($language['url']); ?>">
									<span class="mkdf-ld-item-image">
										<img width="18" height="12" src="<?php echo esc_url($language['country_flag_url']); ?>" alt="<?php echo esc_attr($language_key); ?>">
									</span>
									<?php echo esc_html($language['translated_name']); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php print $args['after_widget']; ?>
		<?php }
	}
}