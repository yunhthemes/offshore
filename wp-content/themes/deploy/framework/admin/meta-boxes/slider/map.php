<?php

//Slider

$slider_meta_box = deploy_mikado_add_meta_box(
    array(
        'scope' => array('slides'),
        'title' => 'Slide Background Type',
        'name' => 'slides_type'
    )
);

    deploy_mikado_add_meta_box_field(
        array(
            'name'          => 'mkdf_slide_background_type',
            'type'          => 'imagevideo',
            'default_value' => 'image',
            'label'         => 'Slide Background Type',
            'description'   => 'Do you want to upload an image or video?',
            'parent'        => $slider_meta_box,
            'args' => array(
                "dependence" => true,
                "dependence_hide_on_yes" => "#mkdf-meta-box-mkdf_slides_video_settings",
                "dependence_show_on_yes" => "#mkdf-meta-box-mkdf_slides_image_settings"
            )
        )
    );


//Slide Image

$slider_meta_box = deploy_mikado_add_meta_box(
    array(
        'scope' => array('slides'),
        'title' => 'Slide Background Image',
        'name' => 'slides_image_settings',
        'hidden_property' => 'mkdf_slide_background_type',
        'hidden_values' => array('video')
    )
);

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_image',
            'type'        => 'image',
            'label'       => 'Slide Image',
            'description' => 'Choose background image',
            'parent'      => $slider_meta_box
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_overlay_image',
            'type'        => 'image',
            'label'       => 'Overlay Image',
            'description' => 'Choose overlay image (pattern) for background image',
            'parent'      => $slider_meta_box
        )
    );


//Slide Video

$video_meta_box = deploy_mikado_add_meta_box(
    array(
        'scope' => array('slides'),
        'title' => 'Slide Background Video',
        'name' => 'slides_video_settings',
        'hidden_property' => 'mkdf_slide_background_type',
        'hidden_values' => array('image')
    )
);

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_video_webm',
            'type'        => 'text',
            'label'       => 'Video - webm',
            'description' => 'Path to the webm file that you have previously uploaded in Media Section',
            'parent'      => $video_meta_box
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_video_mp4',
            'type'        => 'text',
            'label'       => 'Video - mp4',
            'description' => 'Path to the mp4 file that you have previously uploaded in Media Section',
            'parent'      => $video_meta_box
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_video_ogv',
            'type'        => 'text',
            'label'       => 'Video - ogv',
            'description' => 'Path to the ogv file that you have previously uploaded in Media Section',
            'parent'      => $video_meta_box
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_video_image',
            'type'        => 'image',
            'label'       => 'Video Preview Image',
            'description' => 'Choose background image that will be visible until video is loaded. This image will be shown on touch devices too.',
            'parent'      => $video_meta_box
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name' => 'mkdf_slide_video_overlay',
            'type' => 'yesempty',
            'default_value' => '',
            'label' => 'Video Overlay Image',
            'description' => 'Do you want to have a overlay image on video?',
            'parent' => $video_meta_box,
            'args' => array(
                "dependence" => true,
                "dependence_hide_on_yes" => "",
                "dependence_show_on_yes" => "#mkdf_mkdf_slide_video_overlay_container"
            )
        )
    );

    $slide_video_overlay_container = deploy_mikado_add_admin_container(array(
        'name' => 'mkdf_slide_video_overlay_container',
        'parent' => $video_meta_box,
        'hidden_property' => 'mkdf_slide_video_overlay',
        'hidden_values' => array('','no')
    ));

        deploy_mikado_add_meta_box_field(
            array(
                'name'        => 'mkdf_slide_video_overlay_image',
                'type'        => 'image',
                'label'       => 'Overlay Image',
                'description' => 'Choose overlay image (pattern) for background video.',
                'parent'      => $slide_video_overlay_container
            )
        );


//Slide General

$general_meta_box = deploy_mikado_add_meta_box(
    array(
        'scope' => array('slides'),
        'title' => 'Slide General',
        'name' => 'slides_general_settings'
    )
);

    deploy_mikado_add_admin_section_title(
        array(
            'parent' => $general_meta_box,
            'name' => 'mkdf_text_content_title',
            'title' => 'Slide Text Content'
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name' => 'mkdf_slide_hide_title',
            'type' => 'yesno',
            'default_value' => 'no',
            'label' => 'Hide Slide Title',
            'description' => 'Do you want to hide slide title?',
            'parent' => $general_meta_box,
            'args' => array(
                "dependence" => true,
                "dependence_hide_on_yes" => "#mkdf_mkdf_slide_hide_title_container",
                "dependence_show_on_yes" => ""
            )
        )
    );

    $slide_hide_title_container = deploy_mikado_add_admin_container(array(
        'name' => 'mkdf_slide_hide_title_container',
        'parent' => $general_meta_box,
        'hidden_property' => 'mkdf_slide_hide_title',
        'hidden_value' => 'yes'
    ));

        $group_title_link = deploy_mikado_add_admin_group(array(
            'title' => 'Title Link',
            'name' => 'group_title_link',
            'description' => 'Define styles for title',
            'parent' => $slide_hide_title_container
        ));

            $row1 = deploy_mikado_add_admin_row(array(
                'name' => 'row1',
                'parent' => $group_title_link
            ));

                deploy_mikado_add_meta_box_field(
                    array(
                        'name'        => 'mkdf_slide_title_link',
                        'type'        => 'textsimple',
                        'label'       => 'Link',
                        'parent'      => $row1
                    )
                );

                deploy_mikado_add_meta_box_field(
                    array(
                        'parent' => $row1,
                        'type' => 'selectsimple',
                        'name' => 'mkdf_slide_title_target',
                        'default_value' => '_self',
                        'label' => 'Target',
                        'options' => array(
                            "_self" => "Self",
                            "_blank" => "Blank"
                        )
                    )
                );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_subtitle',
            'type'        => 'text',
            'label'       => 'Subtitle Text',
            'description' => 'Enter text for subtitle',
            'parent'      => $general_meta_box
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_text',
            'type'        => 'text',
            'label'       => 'Body Text',
            'description' => 'Enter slide body text',
            'parent'      => $general_meta_box
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_button_label',
            'type'        => 'text',
            'label'       => 'Button 1 Text',
            'description' => 'Enter text to be displayed on button 1',
            'parent'      => $general_meta_box
        )
    );

    $group_button1 = deploy_mikado_add_admin_group(array(
        'title' => 'Button 1 Link',
        'name' => 'group_button1',
        'parent' => $general_meta_box
    ));

        $row1 = deploy_mikado_add_admin_row(array(
            'name' => 'row1',
            'parent' => $group_button1
        ));

            deploy_mikado_add_meta_box_field(
                array(
                    'name'        => 'mkdf_slide_button_link',
                    'type'        => 'textsimple',
                    'label'       => 'Link',
                    'parent'      => $row1
                )
            );

            deploy_mikado_add_meta_box_field(
                array(
                    'parent' => $row1,
                    'type' => 'selectsimple',
                    'name' => 'mkdf_slide_button_target',
                    'default_value' => '_self',
                    'label' => 'Target',
                    'options' => array(
                        "_self" => "Self",
                        "_blank" => "Blank"
                    )
                )
            );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_button_label2',
            'type'        => 'text',
            'label'       => 'Button 2 Text',
            'description' => 'Enter text to be displayed on button 2',
            'parent'      => $general_meta_box
        )
    );

    $group_button2 = deploy_mikado_add_admin_group(array(
        'title' => 'Button 2 Link',
        'name' => 'group_button2',
        'parent' => $general_meta_box
    ));

        $row1 = deploy_mikado_add_admin_row(array(
            'name' => 'row1',
            'parent' => $group_button2
        ));

            deploy_mikado_add_meta_box_field(
                array(
                    'name'        => 'mkdf_slide_button_link2',
                    'type'        => 'textsimple',
                    'label'       => 'Link',
                    'parent'      => $row1
                )
            );

            deploy_mikado_add_meta_box_field(
                array(
                    'parent' => $row1,
                    'type' => 'selectsimple',
                    'name' => 'mkdf_slide_button_target2',
                    'default_value' => '_self',
                    'label' => 'Target',
                    'options' => array(
                        "_self" => "Self",
                        "_blank" => "Blank"
                    )
                )
            );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_text_content_top_margin',
            'type'        => 'text',
            'label'       => 'Text Content Top Margin',
            'description' => 'Enter top margin for text content',
            'parent'      => $general_meta_box,
            'args' => array(
                'col_width' => 2,
                'suffix' => 'px'
            )
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_text_content_bottom_margin',
            'type'        => 'text',
            'label'       => 'Text Content Bottom Margin',
            'description' => 'Enter bottom margin for text content',
            'parent'      => $general_meta_box,
            'args' => array(
                'col_width' => 2,
                'suffix' => 'px'
            )
        )
    );

    deploy_mikado_add_admin_section_title(
        array(
            'parent' => $general_meta_box,
            'name' => 'mkdf_graphic_title',
            'title' => 'Slide Graphic'
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_thumbnail',
            'type'        => 'image',
            'label'       => 'Slide Graphic',
            'description' => 'Choose slide graphic',
            'parent'      => $general_meta_box
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_thumbnail_link',
            'type'        => 'text',
            'label'       => 'Graphic Link',
            'description' => 'Enter URL to link slide graphic',
            'parent'      => $general_meta_box
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_graphic_top_padding',
            'type'        => 'text',
            'label'       => 'Graphic Top Padding',
            'description' => 'Enter top padding for slide graphic',
            'parent'      => $general_meta_box,
            'args' => array(
                'col_width' => 2,
                'suffix' => 'px'
            )
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name'        => 'mkdf_slide_graphic_bottom_padding',
            'type'        => 'text',
            'label'       => 'Graphic Bottom Padding',
            'description' => 'Enter bottom padding for slide graphic',
            'parent'      => $general_meta_box,
            'args' => array(
                'col_width' => 2,
                'suffix' => 'px'
            )
        )
    );

    deploy_mikado_add_admin_section_title(
        array(
            'parent' => $general_meta_box,
            'name' => 'mkdf_general_styling_title',
            'title' => 'General Styling'
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'parent' => $general_meta_box,
            'type' => 'selectblank',
            'name' => 'mkdf_slide_header_style',
            'default_value' => '',
            'label' => 'Header Style',
            'description' => 'Header style will be applied when this slide is in focus',
            'options' => array(
                "light" => "Light",
                "dark" => "Dark"
            )
        )
    );

//Slide Behaviour

$behaviours_meta_box = deploy_mikado_add_meta_box(
    array(
        'scope' => array('slides'),
        'title' => 'Slide Behaviours',
        'name' => 'slides_behaviour_settings'
    )
);

    deploy_mikado_add_admin_section_title(
        array(
            'parent' => $behaviours_meta_box,
            'name' => 'mkdf_image_animation_title',
            'title' => 'Slide Image Animation'
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name' => 'mkdf_enable_image_animation',
            'type' => 'yesno',
            'default_value' => 'no',
            'label' => 'Enable Image Animation',
            'description' => 'Enabling this option will turn on a motion animation on the slide image',
            'parent' => $behaviours_meta_box,
            'args' => array(
                "dependence" => true,
                "dependence_hide_on_yes" => "",
                "dependence_show_on_yes" => "#mkdf_mkdf_enable_image_animation_container"
            )
        )
    );

    $enable_image_animation_container = deploy_mikado_add_admin_container(array(
        'name' => 'mkdf_enable_image_animation_container',
        'parent' => $behaviours_meta_box,
        'hidden_property' => 'mkdf_enable_image_animation',
        'hidden_value' => 'no'
    ));

        deploy_mikado_add_meta_box_field(
            array(
                'parent' => $enable_image_animation_container,
                'type' => 'select',
                'name' => 'mkdf_enable_image_animation_type',
                'default_value' => 'zoom_center',
                'label' => 'Animation Type',
                'options' => array(
                    "zoom_center" => "Zoom In Center",
                    "zoom_top_left" => "Zoom In to Top Left",
                    "zoom_top_right" => "Zoom In to Top Right",
                    "zoom_bottom_left" => "Zoom In to Bottom Left",
                    "zoom_bottom_right" => "Zoom In to Bottom Right"
                )
            )
        );

    deploy_mikado_add_admin_section_title(
        array(
            'parent' => $behaviours_meta_box,
            'name' => 'mkdf_content_animation_title',
            'title' => 'Slide Content Entry Animations'
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'parent' => $behaviours_meta_box,
            'type' => 'select',
            'name' => 'mkdf_slide_thumbnail_animation',
            'default_value' => 'flip',
            'label' => 'Graphic Entry Animation',
            'description' => 'Choose entry animation for graphic',
            'options' => array(
                "flip" => "Flip",
                "fade" => "Fade In",
                "from_bottom" => "From Bottom",
                "from_top" => "From Top",
                "from_left" => "From Left",
                "from_right" => "From Right",
                "clip_anim_hor" => "Clip Animation Horizontal",
                "clip_anim_ver" => "Clip Animation Vertical",
                "clip_anim_puzzle" => "Clip Animation Puzzle",
                "without_animation"	=>	"No Animation"
            )
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'parent' => $behaviours_meta_box,
            'type' => 'select',
            'name' => 'mkdf_slide_content_animation',
            'default_value' => 'all_at_once',
            'label' => 'Content Entry Animation',
            'description' => 'Choose entry animation for whole slide content group (title, subtitle, text, button)',
            'options' => array(
                "all_at_once" => "All At Once",
                "one_by_one" => "One By One",
                "without_animation"	=>	"No Animation"
            ),
            'args' => array(
                "dependence" => true,
                "hide" => array(
                    "all_at_once"=>"",
                    "one_by_one"=>"",
                    "without_animation"=>"#mkdf_mkdf_slide_content_animation_container"),
                "show" => array(
                    "all_at_once"=>"#mkdf_mkdf_slide_content_animation_container",
                    "one_by_one"=>"#mkdf_mkdf_slide_content_animation_container",
                    "without_animation"=>""
                )
            )
        )
    );

    $slide_content_animation_container = deploy_mikado_add_admin_container(array(
        'name' => 'mkdf_slide_content_animation_container',
        'parent' => $behaviours_meta_box,
        'hidden_property' => 'mkdf_slide_content_animation',
        'hidden_value' => 'without_animation'
    ));

        deploy_mikado_add_meta_box_field(
            array(
                'parent' => $slide_content_animation_container,
                'type' => 'select',
                'name' => 'mkdf_slide_content_animation_direction',
                'default_value' => 'from_bottom',
                'label' => 'Animation Direction',
                'options' => array(
                    "from_bottom" => "From Bottom",
                    "from_top" => "From Top",
                    "from_left" => "From Left",
                    "from_right" => "From Right",
                    "fade" => "Fade In"
                )
            )
        );

//Slide Content Positioning

$content_positioning_meta_box = deploy_mikado_add_meta_box(
    array(
        'scope' => array('slides'),
        'title' => 'Slide Content Positioning',
        'name' => 'content_positioning_settings'
    )
);

    deploy_mikado_add_meta_box_field(
        array(
            'parent' => $content_positioning_meta_box,
            'type' => 'selectblank',
            'name' => 'mkdf_slide_content_alignment',
            'default_value' => '',
            'label' => 'Text Alignment',
            'description' => 'Choose an alignment for the slide text',
            'options' => array(
                "left" => "Left",
                "center" => "Center",
                "right" => "Right"
            )
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'parent' => $content_positioning_meta_box,
            'type' => 'selectblank',
            'name' => 'mkdf_slide_separate_text_graphic',
            'default_value' => 'no',
            'label' => 'Separate Graphic and Text Positioning',
            'description' => 'Do you want to separately position graphic and text?',
            'options' => array(
                "no" => "No",
                "yes" => "Yes"
            ),
            'args' => array(
                "dependence" => true,
                "hide" => array(
                    "" => "#mkdf_mkdf_slide_graphic_positioning_container",
                    "no" => "#mkdf_mkdf_slide_graphic_positioning_container, #mkdf_mkdf_content_vertical_positioning_group_container"
                ),
                "show" => array(
                    "yes" => "#mkdf_mkdf_slide_graphic_positioning_container, #mkdf_mkdf_content_vertical_positioning_group_container"
                )
            )
        )
    );

    deploy_mikado_add_meta_box_field(
        array(
            'name' => 'mkdf_slide_content_vertical_middle',
            'type' => 'yesno',
            'default_value' => 'no',
            'label' => 'Vertically Align Content to Middle',
            'parent' => $content_positioning_meta_box,
            'args' => array(
                "dependence" => true,
                "dependence_hide_on_yes" => "#mkdf_mkdf_slide_content_vertical_middle_no_container",
                "dependence_show_on_yes" => "#mkdf_mkdf_slide_content_vertical_middle_yes_container"
            )
        )
    );

    $slide_content_vertical_middle_yes_container = deploy_mikado_add_admin_container(array(
        'name' => 'mkdf_slide_content_vertical_middle_yes_container',
        'parent' => $content_positioning_meta_box,
        'hidden_property' => 'mkdf_slide_content_vertical_middle',
        'hidden_value' => 'no'
    ));

        deploy_mikado_add_meta_box_field(
            array(
                'parent' => $slide_content_vertical_middle_yes_container,
                'type' => 'selectblank',
                'name' => 'mkdf_slide_content_vertical_middle_type',
                'default_value' => '',
                'label' => 'Align Content Vertically Relative to the Height Measured From',
                'options' => array(
                    "bottom_of_header" => "Bottom of Header",
                    "window_top" => "Window Top"
                )
            )
        );

        deploy_mikado_add_meta_box_field(
            array(
                'name' => 'mkdf_slide_vertical_content_full_width',
                'type' => 'yesno',
                'default_value' => 'no',
                'label' => 'Content Holder Full Width',
                'description' => 'Do you want to set slide content holder to full width?',
                'parent' => $slide_content_vertical_middle_yes_container
            )
        );

        deploy_mikado_add_meta_box_field(
            array(
                'name'        => 'mkdf_slide_vertical_content_width',
                'type'        => 'text',
                'label'       => 'Content Width',
                'description' => 'Enter Width for Content Area',
                'parent'      => $slide_content_vertical_middle_yes_container,
                'args' => array(
                    'col_width' => 2,
                    'suffix' => '%'
                )
            )
        );

        $group_space_around_content = deploy_mikado_add_admin_group(array(
            'title' => 'Space Around Content in Slide',
            'name' => 'group_space_around_content',
            'parent' => $slide_content_vertical_middle_yes_container
        ));

            $row1 = deploy_mikado_add_admin_row(array(
                'name' => 'row1',
                'parent' => $group_space_around_content
            ));

                deploy_mikado_add_meta_box_field(
                    array(
                        'name'        => 'mkdf_slide_vertical_content_left',
                        'type'        => 'textsimple',
                        'label'       => 'From Left',
                        'parent'      => $row1,
                        'args' => array(
                            'col_width' => 2,
                            'suffix' => '%'
                        )
                    )
                );

                deploy_mikado_add_meta_box_field(
                    array(
                        'name'        => 'mkdf_slide_vertical_content_right',
                        'type'        => 'textsimple',
                        'label'       => 'From Right',
                        'parent'      => $row1,
                        'args' => array(
                            'col_width' => 2,
                            'suffix' => '%'
                        )
                    )
                );

    $slide_content_vertical_middle_no_container = deploy_mikado_add_admin_container(array(
        'name' => 'mkdf_slide_content_vertical_middle_no_container',
        'parent' => $content_positioning_meta_box,
        'hidden_property' => 'mkdf_slide_content_vertical_middle',
        'hidden_value' => 'yes'
    ));

        deploy_mikado_add_meta_box_field(
            array(
                'name' => 'mkdf_slide_content_full_width',
                'type' => 'yesno',
                'default_value' => 'no',
                'label' => 'Content Holder Full Width',
                'description' => 'Do you want to set slide content holder to full width?',
                'parent' => $slide_content_vertical_middle_no_container,
                'args' => array(
                    "dependence" => true,
                    "dependence_hide_on_yes" => "#mkdf_mkdf_slide_content_width_container",
                    "dependence_show_on_yes" => ""
                )
            )
        );

        $slide_content_width_container = deploy_mikado_add_admin_container(array(
            'name' => 'mkdf_slide_content_width_container',
            'parent' => $slide_content_vertical_middle_no_container,
            'hidden_property' => 'mkdf_slide_content_full_width',
            'hidden_value' => 'yes'
        ));

            deploy_mikado_add_meta_box_field(
                array(
                    'name'        => 'mkdf_slide_content_width',
                    'type'        => 'text',
                    'label'       => 'Content Holder Width',
                    'description' => 'Enter Width for Content Holder Area',
                    'parent'      => $slide_content_width_container,
                    'args' => array(
                        'col_width' => 2,
                        'suffix' => '%'
                    )
                )
            );

        $group_space_around_content = deploy_mikado_add_admin_group(array(
            'title' => 'Space Around Content in Slide',
            'name' => 'group_space_around_content',
            'parent' => $slide_content_vertical_middle_no_container
        ));

            $row1 = deploy_mikado_add_admin_row(array(
                'name' => 'row1',
                'parent' => $group_space_around_content
            ));

                deploy_mikado_add_meta_box_field(
                    array(
                        'name'        => 'mkdf_slide_content_top',
                        'type'        => 'textsimple',
                        'label'       => 'From Top',
                        'parent'      => $row1,
                        'args' => array(
                            'col_width' => 2,
                            'suffix' => '%'
                        )
                    )
                );

                deploy_mikado_add_meta_box_field(
                    array(
                        'name'        => 'mkdf_slide_content_left',
                        'type'        => 'textsimple',
                        'label'       => 'From Left',
                        'parent'      => $row1,
                        'args' => array(
                            'col_width' => 2,
                            'suffix' => '%'
                        )
                    )
                );

                deploy_mikado_add_meta_box_field(
                    array(
                        'name'        => 'mkdf_slide_content_bottom',
                        'type'        => 'textsimple',
                        'label'       => 'From Bottom',
                        'parent'      => $row1,
                        'args' => array(
                            'col_width' => 2,
                            'suffix' => '%'
                        )
                    )
                );

                deploy_mikado_add_meta_box_field(
                    array(
                        'name'        => 'mkdf_slide_content_right',
                        'type'        => 'textsimple',
                        'label'       => 'From Right',
                        'parent'      => $row1,
                        'args' => array(
                            'col_width' => 2,
                            'suffix' => '%'
                        )
                    )
                );

            $row2 = deploy_mikado_add_admin_row(array(
                'name' => 'row2',
                'parent' => $group_space_around_content
            ));

                $content_vertical_positioning_group_container = deploy_mikado_add_admin_container_no_style(array(
                    'name' => 'mkdf_content_vertical_positioning_group_container',
                    'parent' => $row2,
                    'hidden_property' => 'mkdf_slide_separate_text_graphic',
                    'hidden_value' => 'no'
                ));

                    deploy_mikado_add_meta_box_field(
                        array(
                            'name'        => 'mkdf_slide_text_width',
                            'type'        => 'textsimple',
                            'label'       => 'Text Holder Width',
                            'parent'      => $content_vertical_positioning_group_container,
                            'args' => array(
                                'col_width' => 2,
                                'suffix' => '%'
                            )
                        )
                    );

        $slide_graphic_positioning_container = deploy_mikado_add_admin_container(array(
            'name' => 'mkdf_slide_graphic_positioning_container',
            'parent' => $slide_content_vertical_middle_no_container,
            'hidden_property' => 'mkdf_slide_separate_text_graphic',
            'hidden_value' => 'no'
        ));

            deploy_mikado_add_meta_box_field(
                array(
                    'parent' => $slide_graphic_positioning_container,
                    'type' => 'selectblank',
                    'name' => 'mkdf_slide_graphic_alignment',
                    'default_value' => 'left',
                    'label' => 'Choose an alignment for the slide graphic',
                    'options' => array(
                        "left" => "Left",
                        "center" => "Center",
                        "right" => "Right"
                    )
                )
            );

            $group_graphic_positioning = deploy_mikado_add_admin_group(array(
                'title' => 'Graphic Positioning',
                'description' => 'Positioning for slide graphic',
                'name' => 'group_graphic_positioning',
                'parent' => $slide_graphic_positioning_container
            ));

                $row1 = deploy_mikado_add_admin_row(array(
                    'name' => 'row1',
                    'parent' => $group_graphic_positioning
                ));

                    deploy_mikado_add_meta_box_field(
                        array(
                            'name'        => 'mkdf_slide_graphic_top',
                            'type'        => 'textsimple',
                            'label'       => 'From Top',
                            'parent'      => $row1,
                            'args' => array(
                                'col_width' => 2,
                                'suffix' => '%'
                            )
                        )
                    );

                    deploy_mikado_add_meta_box_field(
                        array(
                            'name'        => 'mkdf_slide_graphic_left',
                            'type'        => 'textsimple',
                            'label'       => 'From Left',
                            'parent'      => $row1,
                            'args' => array(
                                'col_width' => 2,
                                'suffix' => '%'
                            )
                        )
                    );

                    deploy_mikado_add_meta_box_field(
                        array(
                            'name'        => 'mkdf_slide_graphic_bottom',
                            'type'        => 'textsimple',
                            'label'       => 'From Bottom',
                            'parent'      => $row1,
                            'args' => array(
                                'col_width' => 2,
                                'suffix' => '%'
                            )
                        )
                    );

                    deploy_mikado_add_meta_box_field(
                        array(
                            'name'        => 'mkdf_slide_graphic_right',
                            'type'        => 'textsimple',
                            'label'       => 'From Right',
                            'parent'      => $row1,
                            'args' => array(
                                'col_width' => 2,
                                'suffix' => '%'
                            )
                        )
                    );

            $row2 = deploy_mikado_add_admin_row(array(
                'name' => 'row2',
                'parent' => $group_graphic_positioning
            ));

                deploy_mikado_add_meta_box_field(
                    array(
                        'name'        => 'mkdf_slide_graphic_width',
                        'type'        => 'textsimple',
                        'label'       => 'Graphic Holder Width',
                        'parent'      => $row2,
                        'args' => array(
                            'col_width' => 2,
                            'suffix' => '%'
                        )
                    )
                );