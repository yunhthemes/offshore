<?php

/*** Gallery Post Format ***/

$gallery_post_format_meta_box = deploy_mikado_add_meta_box(
	array(
		'scope' =>	array('post'),
		'title' => 'Gallery Post Format',
		'name' 	=> 'post-format-gallery-meta'
	)
);

deploy_mikado_add_multiple_images_field(
	array(
		'name'        => 'mkdf_post_gallery_images_meta',
		'label'       => 'Gallery Images',
		'description' => 'Choose your gallery images',
		'parent'      => $gallery_post_format_meta_box,
	)
);
