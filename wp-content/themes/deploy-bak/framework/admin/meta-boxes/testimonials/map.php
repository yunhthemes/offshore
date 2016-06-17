<?php

//Testimonials

$testimonial_meta_box = deploy_mikado_add_meta_box (
    array(
        'scope' => array('testimonials'),
        'title' => 'Testimonial',
        'name' => 'testimonial_meta'
    )
);


    deploy_mikado_add_meta_box_field (
        array(
            'name'        	=> 'mkdf_testimonial_author',
            'type'        	=> 'text',
            'label'       	=> 'Author',
            'description' 	=> 'Enter author name',
            'parent'      	=> $testimonial_meta_box,
        )
    );


    deploy_mikado_add_meta_box_field (
        array(
            'name'        	=> 'mkdf_testimonial_text',
            'type'        	=> 'text',
            'label'       	=> 'Text',
            'description' 	=> 'Enter testimonial text',
            'parent'      	=> $testimonial_meta_box,
        )
    );

        deploy_mikado_add_meta_box_field (
            array(
                'name'        	=> 'mkdf_testimonial_job',
                'type'        	=> 'text',
                'label'       	=> 'Job Position',
                'description' 	=> 'Enter testimonial job',
                'parent'      	=> $testimonial_meta_box,
            )
    );


