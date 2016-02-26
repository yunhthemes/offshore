<?php

$general_meta_box = deploy_mikado_add_meta_box(
	array(
		'scope' => array('page', 'portfolio-item', 'post'),
		'title' => 'General',
		'name'  => 'general_meta'
	)
);


deploy_mikado_add_meta_box_field(
	array(
		'name'          => 'mkdf_page_background_color_meta',
		'type'          => 'color',
		'default_value' => '',
		'label'         => 'Page Background Color',
		'description'   => 'Choose background color for page content',
		'parent'        => $general_meta_box
	)
);

deploy_mikado_add_meta_box_field(
	array(
		'name'          => 'mkdf_page_slider_meta',
		'type'          => 'text',
		'default_value' => '',
		'label'         => 'Slider Shortcode',
		'description'   => 'Paste your slider shortcode here',
		'parent'        => $general_meta_box
	)
);

$mkdf_content_padding_group = deploy_mikado_add_admin_group(array(
	'name'        => 'content_padding_group',
	'title'       => 'Content Style',
	'description' => 'Define styles for Content area',
	'parent'      => $general_meta_box
));

$mkdf_content_padding_row = deploy_mikado_add_admin_row(array(
	'name'   => 'mkdf_content_padding_row',
	'next'   => true,
	'parent' => $mkdf_content_padding_group
));

deploy_mikado_add_meta_box_field(
	array(
		'name'          => 'mkdf_page_content_behind_header_meta',
		'type'          => 'yesnosimple',
		'default_value' => 'no',
		'label'         => 'Always put content behind header',
		'parent'        => $mkdf_content_padding_row,
		'args'          => array(
			'suffix' => 'px'
		)
	)
);

deploy_mikado_add_meta_box_field(
	array(
		'name'          => 'mkdf_page_content_top_padding',
		'type'          => 'textsimple',
		'default_value' => '',
		'label'         => 'Content Top Padding',
		'parent'        => $mkdf_content_padding_row,
		'args'          => array(
			'suffix' => 'px'
		)
	)
);

deploy_mikado_add_meta_box_field(
	array(
		'name'    => 'mkdf_page_content_top_padding_mobile',
		'type'    => 'selectblanksimple',
		'label'   => 'Set this top padding for mobile header',
		'parent'  => $mkdf_content_padding_row,
		'options' => array(
			'yes' => 'Yes',
			'no'  => 'No',
		)
	)
);

deploy_mikado_add_meta_box_field(
	array(
		'name'        => 'mkdf_page_comments_meta',
		'type'        => 'selectblank',
		'label'       => 'Show Comments',
		'description' => 'Enabling this option will show comments on your page',
		'parent'      => $general_meta_box,
		'options'     => array(
			'yes' => 'Yes',
			'no'  => 'No',
		)
	)
);