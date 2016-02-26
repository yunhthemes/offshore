<?php

//top header bar
add_action('deploy_mikado_before_page_header', 'deploy_mikado_get_header_top');

//mobile header
add_action('deploy_mikado_after_page_header', 'deploy_mikado_get_mobile_header');