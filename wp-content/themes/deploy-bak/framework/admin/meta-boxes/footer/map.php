<?php

$footer_meta_box = deploy_mikado_add_meta_box(
    array(
        'scope' => array('page', 'portfolio-item', 'post'),
        'title' => 'Footer',
        'name' => 'footer_meta'
    )
);

    deploy_mikado_add_meta_box_field(
        array(
            'name' => 'mkdf_disable_footer_meta',
            'type' => 'yesno',
            'default_value' => 'no',
            'label' => 'Disable Footer for this Page',
            'description' => 'Enabling this option will hide footer on this page',
            'parent' => $footer_meta_box,
        )
    );