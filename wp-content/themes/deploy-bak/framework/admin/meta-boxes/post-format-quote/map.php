<?php

/*** Quote Post Format ***/

$quote_post_format_meta_box = deploy_mikado_add_meta_box(
	array(
		'scope' =>	array('post'),
		'title' => 'Quote Post Format',
		'name' 	=> 'post-format-quote-meta'
	)
);

deploy_mikado_add_meta_box_field(
	array(
		'name'        => 'mkdf_post_quote_text_meta',
		'type'        => 'text',
		'label'       => 'Quote Text',
		'description' => 'Enter Quote text',
		'parent'      => $quote_post_format_meta_box,

	)
);
