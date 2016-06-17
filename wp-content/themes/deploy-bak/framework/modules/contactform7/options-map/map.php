<?php

if ( ! function_exists('deploy_mikado_contact_form_7_options_map') ) {

	function deploy_mikado_contact_form_7_options_map() {

		deploy_mikado_add_admin_page(array(
			'slug'	=> '_contact_form7_page',
			'title'	=> 'Contact Form 7',
			'icon'	=> 'fa fa-envelope-o'
		));

		$panel_contact_form_style_1 = deploy_mikado_add_admin_panel(array(
			'page'	=> '_contact_form7_page',
			'name'	=> 'panel_contact_form_style_1',
			'title'	=> 'Custom Style 1'
		));

		//Text Typography

		$typography_text_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'typography_text_group',
			'title'			=> 'Form Text Typography',
			'description'	=> 'Setup typography for form elements text',
			'parent'		=> $panel_contact_form_style_1
		));

		$typography_text_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_text_row1',
			'parent'	=> $typography_text_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_text_color',
			'default_value'	=> '',
			'label'			=> 'Text Color',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_focus_text_color',
			'default_value'	=> '',
			'label'			=> 'Focus Text Color',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_text_font_size',
			'default_value'	=> '',
			'label'			=> 'Font Size',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_text_line_height',
			'default_value'	=> '',
			'label'			=> 'Line Height',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		$typography_text_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_text_row2',
			'next'		=> true,
			'parent'	=> $typography_text_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'fontsimple',
			'name'			=> 'cf7_style_1_text_font_family',
			'default_value'	=> '',
			'label'			=> 'Font Family',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_1_text_font_style',
			'default_value'	=> '',
			'label'			=> 'Font Style',
			'options'		=>  deploy_mikado_get_font_style_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_1_text_font_weight',
			'default_value'	=> '',
			'label'			=> 'Font Weight',
			'options'		=> deploy_mikado_get_font_weight_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_1_text_text_transform',
			'default_value'	=> '',
			'label'			=> 'Text Transform',
			'options'		=> deploy_mikado_get_text_transform_array()
		));

		$typography_text_row3 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_text_row3',
			'next'		=> true,
			'parent'	=> $typography_text_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_text_letter_spacing',
			'default_value'	=> '',
			'label'			=> 'Letter Spacing',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Labels Typography

		$typography_label_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'typography_label_group',
			'title'			=> 'Form Label Typography',
			'description'	=> 'Setup typography for form elements label',
			'parent'		=> $panel_contact_form_style_1
		));

		$typography_label_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_label_row1',
			'parent'	=> $typography_label_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_label_color',
			'default_value'	=> '',
			'label'			=> 'Text Color',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_label_font_size',
			'default_value'	=> '',
			'label'			=> 'Font Size',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_label_line_height',
			'default_value'	=> '',
			'label'			=> 'Line Height',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'fontsimple',
			'name'			=> 'cf7_style_1_label_font_family',
			'default_value'	=> '',
			'label'			=> 'Font Family',
		));

		$typography_label_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_label_row2',
			'next'		=> true,
			'parent'	=> $typography_label_group
		));


		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_1_label_font_style',
			'default_value'	=> '',
			'label'			=> 'Font Style',
			'options'		=>  deploy_mikado_get_font_style_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_1_label_font_weight',
			'default_value'	=> '',
			'label'			=> 'Font Weight',
			'options'		=> deploy_mikado_get_font_weight_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_1_label_text_transform',
			'default_value'	=> '',
			'label'			=> 'Text Transform',
			'options'		=> deploy_mikado_get_text_transform_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_label_letter_spacing',
			'default_value'	=> '',
			'label'			=> 'Letter Spacing',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Form Elements Background and Border

		$background_border_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'background_border_group',
			'title'			=> 'Form Elements Background and Border',
			'description'	=> 'Setup form elements background and border style',
			'parent'		=> $panel_contact_form_style_1
		));

		$background_border_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'background_border_row1',
			'parent'	=> $background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_background_color',
			'default_value'	=> '',
			'label'			=> 'Background Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_background_transparency',
			'default_value'	=> '',
			'label'			=> 'Background Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_focus_background_color',
			'default_value'	=> '',
			'label'			=> 'Focus Background Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_focus_background_transparency',
			'default_value'	=> '',
			'label'			=> 'Focus Background Transparency'
		));

		$background_border_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'background_border_row2',
			'next'		=> true,
			'parent'	=> $background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_border_color',
			'default_value'	=> '',
			'label'			=> 'Border Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Border Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_focus_border_color',
			'default_value'	=> '',
			'label'			=> 'Focus Border Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_focus_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Focus Border Transparency'
		));

		$background_border_row3 = deploy_mikado_add_admin_row(array(
			'name'		=> 'background_border_row3',
			'next'		=> true,
			'parent'	=> $background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_border_width',
			'default_value'	=> '',
			'label'			=> 'Border Width',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_border_radius',
			'default_value'	=> '',
			'label'			=> 'Border Radius',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Form Elements Padding

		$padding_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'padding_group',
			'title'			=> 'Elements Padding',
			'description'	=> 'Setup form elements padding',
			'parent'		=> $panel_contact_form_style_1
		));

		$padding_row = deploy_mikado_add_admin_row(array(
			'name'		=> 'padding_row',
			'parent'	=> $padding_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_padding_top',
			'default_value'	=> '',
			'label'			=> 'Padding Top',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_padding_right',
			'default_value'	=> '',
			'label'			=> 'Padding Right',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_padding_bottom',
			'default_value'	=> '',
			'label'			=> 'Padding Bottom',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_padding_left',
			'default_value'	=> '',
			'label'			=> 'Padding Left',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Form Elements Margin

		$margin_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'margin_group',
			'title'			=> 'Elements Margin',
			'description'	=> 'Setup form elements margin',
			'parent'		=> $panel_contact_form_style_1
		));

		$margin_row = deploy_mikado_add_admin_row(array(
			'name'		=> 'margin_row',
			'parent'	=> $margin_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $margin_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_margin_top',
			'default_value'	=> '',
			'label'			=> 'Margin Top',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $margin_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_margin_bottom',
			'default_value'	=> '',
			'label'			=> 'Margin Bottom',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Textarea

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_1,
			'type'			=> 'text',
			'name'			=> 'cf7_style_1_textarea_height',
			'default_value'	=> '',
			'label'			=> 'Textarea Height',
			'description'	=> 'Enter height for textarea form element',
			'args'			=> array(
				'col_width' => '3',
				'suffix' => 'px'
			)
		));

		// Button Typography

		$button_typography_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'button_typography_group',
			'title'			=> 'Button Typography',
			'description'	=> 'Setup button text typography',
			'parent'		=> $panel_contact_form_style_1
		));

		$button_typography_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_typography_row1',
			'parent'	=> $button_typography_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_button_color',
			'default_value'	=> '',
			'label'			=> 'Text Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_button_hover_color',
			'default_value'	=> '',
			'label'			=> 'Text Hover Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_button_font_size',
			'default_value'	=> '',
			'label'			=> 'Font Size',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'fontsimple',
			'name'			=> 'cf7_style_1_button_font_family',
			'default_value'	=> '',
			'label'			=> 'Font Family'
		));

		$button_typography_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_typography_row2',
			'next'		=> true,
			'parent'	=> $button_typography_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_1_button_font_style',
			'default_value'	=> '',
			'label'			=> 'Font Style',
			'options'		=> deploy_mikado_get_font_style_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_1_button_font_weight',
			'default_value'	=> '',
			'label'			=> 'Font Weight',
			'options'		=> deploy_mikado_get_font_weight_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_1_button_text_transform',
			'default_value'	=> '',
			'label'			=> 'Text Transform',
			'options'		=> deploy_mikado_get_text_transform_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_button_letter_spacing',
			'default_value'	=> '',
			'label'			=> 'Letter Spacing',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Button Background and Border

		$button_background_border_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'button_background_border_group',
			'title'			=> 'Button Background and Border',
			'description'	=> 'Setup button background and border style',
			'parent'		=> $panel_contact_form_style_1
		));

		$button_background_border_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_background_border_row1',
			'parent'	=> $button_background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_button_background_color',
			'default_value'	=> '',
			'label'			=> 'Background Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_button_background_transparency',
			'default_value'	=> '',
			'label'			=> 'Background Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_button_hover_bckg_color',
			'default_value'	=> '',
			'label'			=> 'Background Hover Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_button_hover_bckg_transparency',
			'default_value'	=> '',
			'label'			=> 'Background Hover Transparency'
		));

		$button_background_border_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_background_border_row2',
			'next'		=> true,
			'parent'	=> $button_background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_button_border_color',
			'default_value'	=> '',
			'label'			=> 'Border Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_button_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Border Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_1_button_hover_border_color',
			'default_value'	=> '',
			'label'			=> 'Border Hover Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_button_hover_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Border Hover Transparency'
		));

		$button_background_border_row3 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_background_border_row3',
			'next'		=> true,
			'parent'	=> $button_background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_button_border_width',
			'default_value'	=> '',
			'label'			=> 'Border Width',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_1_button_border_radius',
			'default_value'	=> '',
			'label'			=> 'Border Radius',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Button Height

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_1,
			'type'			=> 'text',
			'name'			=> 'cf7_style_1_button_height',
			'default_value'	=> '',
			'label'			=> 'Button Height',
			'description'	=> 'Insert form button height',
			'args'			=> array(
				'col_width' => '3',
				'suffix' => 'px'
			)
		));

		// Button Padding

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_1,
			'type'			=> 'text',
			'name'			=> 'cf7_style_1_button_padding',
			'default_value'	=> '',
			'label'			=> 'Button Left/Right Padding',
			'description'	=> 'Enter value for button left and right padding',
			'args'			=> array(
				'col_width' => '3',
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_1,
			'type'			=> 'yesno',
			'name'			=> 'cf7_style_1_button_fullwidth',
			'default_value'	=> 'no',
			'label'			=> 'Make Button Full Width?',
			'description'	=> 'Enabling this option will make button full width'
		));

		$panel_contact_form_style_2 = deploy_mikado_add_admin_panel(array(
			'page'	=> '_contact_form7_page',
			'name'	=> 'panel_contact_form_style_2',
			'title'	=> 'Custom Style 2'
		));

		//Text Typography

		$typography_text_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'typography_text_group',
			'title'			=> 'Form Text Typography',
			'description'	=> 'Setup typography for form elements text',
			'parent'		=> $panel_contact_form_style_2
		));

		$typography_text_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_text_row1',
			'parent'	=> $typography_text_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_text_color',
			'default_value'	=> '',
			'label'			=> 'Text Color',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_focus_text_color',
			'default_value'	=> '',
			'label'			=> 'Focus Text Color',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_text_font_size',
			'default_value'	=> '',
			'label'			=> 'Font Size',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_text_line_height',
			'default_value'	=> '',
			'label'			=> 'Line Height',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		$typography_text_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_text_row2',
			'next'		=> true,
			'parent'	=> $typography_text_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'fontsimple',
			'name'			=> 'cf7_style_2_text_font_family',
			'default_value'	=> '',
			'label'			=> 'Font Family',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_2_text_font_style',
			'default_value'	=> '',
			'label'			=> 'Font Style',
			'options'		=>  deploy_mikado_get_font_style_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_2_text_font_weight',
			'default_value'	=> '',
			'label'			=> 'Font Weight',
			'options'		=> deploy_mikado_get_font_weight_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_2_text_text_transform',
			'default_value'	=> '',
			'label'			=> 'Text Transform',
			'options'		=> deploy_mikado_get_text_transform_array()
		));

		$typography_text_row3 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_text_row3',
			'next'		=> true,
			'parent'	=> $typography_text_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_text_letter_spacing',
			'default_value'	=> '',
			'label'			=> 'Letter Spacing',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Labels Typography

		$typography_label_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'typography_label_group',
			'title'			=> 'Form Label Typography',
			'description'	=> 'Setup typography for form elements label',
			'parent'		=> $panel_contact_form_style_2
		));

		$typography_label_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_label_row1',
			'parent'	=> $typography_label_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_label_color',
			'default_value'	=> '',
			'label'			=> 'Text Color',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_label_font_size',
			'default_value'	=> '',
			'label'			=> 'Font Size',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_label_line_height',
			'default_value'	=> '',
			'label'			=> 'Line Height',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'fontsimple',
			'name'			=> 'cf7_style_2_label_font_family',
			'default_value'	=> '',
			'label'			=> 'Font Family',
		));

		$typography_label_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_label_row2',
			'next'		=> true,
			'parent'	=> $typography_label_group
		));


		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_2_label_font_style',
			'default_value'	=> '',
			'label'			=> 'Font Style',
			'options'		=>  deploy_mikado_get_font_style_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_2_label_font_weight',
			'default_value'	=> '',
			'label'			=> 'Font Weight',
			'options'		=> deploy_mikado_get_font_weight_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_2_label_text_transform',
			'default_value'	=> '',
			'label'			=> 'Text Transform',
			'options'		=> deploy_mikado_get_text_transform_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_label_letter_spacing',
			'default_value'	=> '',
			'label'			=> 'Letter Spacing',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Form Elements Background and Border

		$background_border_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'background_border_group',
			'title'			=> 'Form Elements Background and Border',
			'description'	=> 'Setup form elements background and border style',
			'parent'		=> $panel_contact_form_style_2
		));

		$background_border_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'background_border_row1',
			'parent'	=> $background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_background_color',
			'default_value'	=> '',
			'label'			=> 'Background Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_background_transparency',
			'default_value'	=> '',
			'label'			=> 'Background Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_focus_background_color',
			'default_value'	=> '',
			'label'			=> 'Focus Background Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_focus_background_transparency',
			'default_value'	=> '',
			'label'			=> 'Focus Background Transparency'
		));

		$background_border_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'background_border_row2',
			'next'		=> true,
			'parent'	=> $background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_border_color',
			'default_value'	=> '',
			'label'			=> 'Border Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Border Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_focus_border_color',
			'default_value'	=> '',
			'label'			=> 'Focus Border Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_focus_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Focus Border Transparency'
		));

		$background_border_row3 = deploy_mikado_add_admin_row(array(
			'name'		=> 'background_border_row3',
			'next'		=> true,
			'parent'	=> $background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_border_width',
			'default_value'	=> '',
			'label'			=> 'Border Width',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_border_radius',
			'default_value'	=> '',
			'label'			=> 'Border Radius',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Form Elements Padding

		$padding_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'padding_group',
			'title'			=> 'Elements Padding',
			'description'	=> 'Setup form elements padding',
			'parent'		=> $panel_contact_form_style_2
		));

		$padding_row = deploy_mikado_add_admin_row(array(
			'name'		=> 'padding_row',
			'parent'	=> $padding_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_padding_top',
			'default_value'	=> '',
			'label'			=> 'Padding Top',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_padding_right',
			'default_value'	=> '',
			'label'			=> 'Padding Right',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_padding_bottom',
			'default_value'	=> '',
			'label'			=> 'Padding Bottom',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_padding_left',
			'default_value'	=> '',
			'label'			=> 'Padding Left',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Form Elements Margin

		$margin_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'margin_group',
			'title'			=> 'Elements Margin',
			'description'	=> 'Setup form elements margin',
			'parent'		=> $panel_contact_form_style_2
		));

		$margin_row = deploy_mikado_add_admin_row(array(
			'name'		=> 'margin_row',
			'parent'	=> $margin_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $margin_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_margin_top',
			'default_value'	=> '',
			'label'			=> 'Margin Top',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $margin_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_margin_bottom',
			'default_value'	=> '',
			'label'			=> 'Margin Bottom',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Textarea

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_2,
			'type'			=> 'text',
			'name'			=> 'cf7_style_2_textarea_height',
			'default_value'	=> '',
			'label'			=> 'Textarea Height',
			'description'	=> 'Enter height for textarea form element',
			'args'			=> array(
				'col_width' => '3',
				'suffix' => 'px'
			)
		));

		// Button Typography

		$button_typography_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'button_typography_group',
			'title'			=> 'Button Typography',
			'description'	=> 'Setup button text typography',
			'parent'		=> $panel_contact_form_style_2
		));

		$button_typography_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_typography_row1',
			'parent'	=> $button_typography_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_button_color',
			'default_value'	=> '',
			'label'			=> 'Text Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_button_hover_color',
			'default_value'	=> '',
			'label'			=> 'Text Hover Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_button_font_size',
			'default_value'	=> '',
			'label'			=> 'Font Size',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'fontsimple',
			'name'			=> 'cf7_style_2_button_font_family',
			'default_value'	=> '',
			'label'			=> 'Font Family'
		));

		$button_typography_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_typography_row2',
			'next'		=> true,
			'parent'	=> $button_typography_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_2_button_font_style',
			'default_value'	=> '',
			'label'			=> 'Font Style',
			'options'		=> deploy_mikado_get_font_style_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_2_button_font_weight',
			'default_value'	=> '',
			'label'			=> 'Font Weight',
			'options'		=> deploy_mikado_get_font_weight_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_2_button_text_transform',
			'default_value'	=> '',
			'label'			=> 'Text Transform',
			'options'		=> deploy_mikado_get_text_transform_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_button_letter_spacing',
			'default_value'	=> '',
			'label'			=> 'Letter Spacing',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Button Background and Border

		$button_background_border_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'button_background_border_group',
			'title'			=> 'Button Background and Border',
			'description'	=> 'Setup button background and border style',
			'parent'		=> $panel_contact_form_style_2
		));

		$button_background_border_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_background_border_row1',
			'parent'	=> $button_background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_button_background_color',
			'default_value'	=> '',
			'label'			=> 'Background Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_button_background_transparency',
			'default_value'	=> '',
			'label'			=> 'Background Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_button_hover_bckg_color',
			'default_value'	=> '',
			'label'			=> 'Background Hover Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_button_hover_bckg_transparency',
			'default_value'	=> '',
			'label'			=> 'Background Hover Transparency'
		));

		$button_background_border_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_background_border_row2',
			'next'		=> true,
			'parent'	=> $button_background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_button_border_color',
			'default_value'	=> '',
			'label'			=> 'Border Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_button_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Border Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_2_button_hover_border_color',
			'default_value'	=> '',
			'label'			=> 'Border Hover Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_button_hover_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Border Hover Transparency'
		));

		$button_background_border_row3 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_background_border_row3',
			'next'		=> true,
			'parent'	=> $button_background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_button_border_width',
			'default_value'	=> '',
			'label'			=> 'Border Width',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_2_button_border_radius',
			'default_value'	=> '',
			'label'			=> 'Border Radius',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Button Height

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_2,
			'type'			=> 'text',
			'name'			=> 'cf7_style_2_button_height',
			'default_value'	=> '',
			'label'			=> 'Button Height',
			'description'	=> 'Insert form button height',
			'args'			=> array(
				'col_width' => '3',
				'suffix' => 'px'
			)
		));

		// Button Padding

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_2,
			'type'			=> 'text',
			'name'			=> 'cf7_style_2_button_padding',
			'default_value'	=> '',
			'label'			=> 'Button Left/Right Padding',
			'description'	=> 'Enter value for button left and right padding',
			'args'			=> array(
				'col_width' => '3',
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_2,
			'type'			=> 'yesno',
			'name'			=> 'cf7_style_2_button_fullwidth',
			'default_value'	=> 'no',
			'label'			=> 'Make Button Full Width?',
			'description'	=> 'Enabling this option will make button full width'
		));
		
		//style 3
		$panel_contact_form_style_3 = deploy_mikado_add_admin_panel(array(
			'page'	=> '_contact_form7_page',
			'name'	=> 'panel_contact_form_style_3',
			'title'	=> 'Custom Style 3'
		));

		//Text Typography

		$typography_text_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'typography_text_group',
			'title'			=> 'Form Text Typography',
			'description'	=> 'Setup typography for form elements text',
			'parent'		=> $panel_contact_form_style_3
		));

		$typography_text_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_text_row1',
			'parent'	=> $typography_text_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_text_color',
			'default_value'	=> '',
			'label'			=> 'Text Color',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_focus_text_color',
			'default_value'	=> '',
			'label'			=> 'Focus Text Color',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_text_font_size',
			'default_value'	=> '',
			'label'			=> 'Font Size',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_text_line_height',
			'default_value'	=> '',
			'label'			=> 'Line Height',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		$typography_text_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_text_row2',
			'next'		=> true,
			'parent'	=> $typography_text_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'fontsimple',
			'name'			=> 'cf7_style_3_text_font_family',
			'default_value'	=> '',
			'label'			=> 'Font Family',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_3_text_font_style',
			'default_value'	=> '',
			'label'			=> 'Font Style',
			'options'		=>  deploy_mikado_get_font_style_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_3_text_font_weight',
			'default_value'	=> '',
			'label'			=> 'Font Weight',
			'options'		=> deploy_mikado_get_font_weight_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_3_text_text_transform',
			'default_value'	=> '',
			'label'			=> 'Text Transform',
			'options'		=> deploy_mikado_get_text_transform_array()
		));

		$typography_text_row3 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_text_row3',
			'next'		=> true,
			'parent'	=> $typography_text_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_text_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_text_letter_spacing',
			'default_value'	=> '',
			'label'			=> 'Letter Spacing',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Labels Typography

		$typography_label_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'typography_label_group',
			'title'			=> 'Form Label Typography',
			'description'	=> 'Setup typography for form elements label',
			'parent'		=> $panel_contact_form_style_3
		));

		$typography_label_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_label_row1',
			'parent'	=> $typography_label_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_label_color',
			'default_value'	=> '',
			'label'			=> 'Text Color',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_label_font_size',
			'default_value'	=> '',
			'label'			=> 'Font Size',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_label_line_height',
			'default_value'	=> '',
			'label'			=> 'Line Height',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row1,
			'type'			=> 'fontsimple',
			'name'			=> 'cf7_style_3_label_font_family',
			'default_value'	=> '',
			'label'			=> 'Font Family',
		));

		$typography_label_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'typography_label_row2',
			'next'		=> true,
			'parent'	=> $typography_label_group
		));


		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_3_label_font_style',
			'default_value'	=> '',
			'label'			=> 'Font Style',
			'options'		=>  deploy_mikado_get_font_style_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_3_label_font_weight',
			'default_value'	=> '',
			'label'			=> 'Font Weight',
			'options'		=> deploy_mikado_get_font_weight_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_3_label_text_transform',
			'default_value'	=> '',
			'label'			=> 'Text Transform',
			'options'		=> deploy_mikado_get_text_transform_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $typography_label_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_label_letter_spacing',
			'default_value'	=> '',
			'label'			=> 'Letter Spacing',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Form Elements Background and Border

		$background_border_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'background_border_group',
			'title'			=> 'Form Elements Background and Border',
			'description'	=> 'Setup form elements background and border style',
			'parent'		=> $panel_contact_form_style_3
		));

		$background_border_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'background_border_row1',
			'parent'	=> $background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_background_color',
			'default_value'	=> '',
			'label'			=> 'Background Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_background_transparency',
			'default_value'	=> '',
			'label'			=> 'Background Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_focus_background_color',
			'default_value'	=> '',
			'label'			=> 'Focus Background Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_focus_background_transparency',
			'default_value'	=> '',
			'label'			=> 'Focus Background Transparency'
		));

		$background_border_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'background_border_row2',
			'next'		=> true,
			'parent'	=> $background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_border_color',
			'default_value'	=> '',
			'label'			=> 'Border Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Border Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_focus_border_color',
			'default_value'	=> '',
			'label'			=> 'Focus Border Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_focus_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Focus Border Transparency'
		));

		$background_border_row3 = deploy_mikado_add_admin_row(array(
			'name'		=> 'background_border_row3',
			'next'		=> true,
			'parent'	=> $background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_border_width',
			'default_value'	=> '',
			'label'			=> 'Border Width',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_border_radius',
			'default_value'	=> '',
			'label'			=> 'Border Radius',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Form Elements Padding

		$padding_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'padding_group',
			'title'			=> 'Elements Padding',
			'description'	=> 'Setup form elements padding',
			'parent'		=> $panel_contact_form_style_3
		));

		$padding_row = deploy_mikado_add_admin_row(array(
			'name'		=> 'padding_row',
			'parent'	=> $padding_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_padding_top',
			'default_value'	=> '',
			'label'			=> 'Padding Top',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_padding_right',
			'default_value'	=> '',
			'label'			=> 'Padding Right',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_padding_bottom',
			'default_value'	=> '',
			'label'			=> 'Padding Bottom',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $padding_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_padding_left',
			'default_value'	=> '',
			'label'			=> 'Padding Left',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Form Elements Margin

		$margin_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'margin_group',
			'title'			=> 'Elements Margin',
			'description'	=> 'Setup form elements margin',
			'parent'		=> $panel_contact_form_style_3
		));

		$margin_row = deploy_mikado_add_admin_row(array(
			'name'		=> 'margin_row',
			'parent'	=> $margin_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $margin_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_margin_top',
			'default_value'	=> '',
			'label'			=> 'Margin Top',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $margin_row,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_margin_bottom',
			'default_value'	=> '',
			'label'			=> 'Margin Bottom',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Textarea

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_3,
			'type'			=> 'text',
			'name'			=> 'cf7_style_3_textarea_height',
			'default_value'	=> '',
			'label'			=> 'Textarea Height',
			'description'	=> 'Enter height for textarea form element',
			'args'			=> array(
				'col_width' => '3',
				'suffix' => 'px'
			)
		));

		// Button Typography

		$button_typography_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'button_typography_group',
			'title'			=> 'Button Typography',
			'description'	=> 'Setup button text typography',
			'parent'		=> $panel_contact_form_style_3
		));

		$button_typography_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_typography_row1',
			'parent'	=> $button_typography_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_button_color',
			'default_value'	=> '',
			'label'			=> 'Text Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_button_hover_color',
			'default_value'	=> '',
			'label'			=> 'Text Hover Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_button_font_size',
			'default_value'	=> '',
			'label'			=> 'Font Size',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row1,
			'type'			=> 'fontsimple',
			'name'			=> 'cf7_style_3_button_font_family',
			'default_value'	=> '',
			'label'			=> 'Font Family'
		));

		$button_typography_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_typography_row2',
			'next'		=> true,
			'parent'	=> $button_typography_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_3_button_font_style',
			'default_value'	=> '',
			'label'			=> 'Font Style',
			'options'		=> deploy_mikado_get_font_style_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_3_button_font_weight',
			'default_value'	=> '',
			'label'			=> 'Font Weight',
			'options'		=> deploy_mikado_get_font_weight_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'selectsimple',
			'name'			=> 'cf7_style_3_button_text_transform',
			'default_value'	=> '',
			'label'			=> 'Text Transform',
			'options'		=> deploy_mikado_get_text_transform_array()
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_typography_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_button_letter_spacing',
			'default_value'	=> '',
			'label'			=> 'Letter Spacing',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Button Background and Border

		$button_background_border_group = deploy_mikado_add_admin_group(array(
			'name'			=> 'button_background_border_group',
			'title'			=> 'Button Background and Border',
			'description'	=> 'Setup button background and border style',
			'parent'		=> $panel_contact_form_style_3
		));

		$button_background_border_row1 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_background_border_row1',
			'parent'	=> $button_background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_button_background_color',
			'default_value'	=> '',
			'label'			=> 'Background Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_button_background_transparency',
			'default_value'	=> '',
			'label'			=> 'Background Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_button_hover_bckg_color',
			'default_value'	=> '',
			'label'			=> 'Background Hover Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row1,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_button_hover_bckg_transparency',
			'default_value'	=> '',
			'label'			=> 'Background Hover Transparency'
		));

		$button_background_border_row2 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_background_border_row2',
			'next'		=> true,
			'parent'	=> $button_background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_button_border_color',
			'default_value'	=> '',
			'label'			=> 'Border Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_button_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Border Transparency',
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'colorsimple',
			'name'			=> 'cf7_style_3_button_hover_border_color',
			'default_value'	=> '',
			'label'			=> 'Border Hover Color'
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row2,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_button_hover_border_transparency',
			'default_value'	=> '',
			'label'			=> 'Border Hover Transparency'
		));

		$button_background_border_row3 = deploy_mikado_add_admin_row(array(
			'name'		=> 'button_background_border_row3',
			'next'		=> true,
			'parent'	=> $button_background_border_group
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_button_border_width',
			'default_value'	=> '',
			'label'			=> 'Border Width',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $button_background_border_row3,
			'type'			=> 'textsimple',
			'name'			=> 'cf7_style_3_button_border_radius',
			'default_value'	=> '',
			'label'			=> 'Border Radius',
			'args'			=> array(
				'suffix' => 'px'
			)
		));

		// Button Height

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_3,
			'type'			=> 'text',
			'name'			=> 'cf7_style_3_button_height',
			'default_value'	=> '',
			'label'			=> 'Button Height',
			'description'	=> 'Insert form button height',
			'args'			=> array(
				'col_width' => '3',
				'suffix' => 'px'
			)
		));

		// Button Padding

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_3,
			'type'			=> 'text',
			'name'			=> 'cf7_style_3_button_padding',
			'default_value'	=> '',
			'label'			=> 'Button Left/Right Padding',
			'description'	=> 'Enter value for button left and right padding',
			'args'			=> array(
				'col_width' => '3',
				'suffix' => 'px'
			)
		));

		deploy_mikado_add_admin_field(array(
			'parent'		=> $panel_contact_form_style_3,
			'type'			=> 'yesno',
			'name'			=> 'cf7_style_3_button_fullwidth',
			'default_value'	=> 'no',
			'label'			=> 'Make Button Full Width?',
			'description'	=> 'Enabling this option will make button full width'
		));
	}

	add_action( 'deploy_mikado_options_map', 'deploy_mikado_contact_form_7_options_map', 16 );

}