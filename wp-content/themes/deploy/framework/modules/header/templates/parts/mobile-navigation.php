<?php do_action('deploy_mikado_before_mobile_navigation'); ?>

<nav class="mkdf-mobile-nav">
    <div class="mkdf-grid">
        <ul class="menu-header-mneu-1">
            <?php if ( !is_user_logged_in() ): ?>
                <li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
                    <a href="#" id="custom-right-header-signin-mobile">
                        <span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Sign In</span></span><span class="plus"></span></span>
                    </a>
                    <div id="custom-right-header-signin-box-mobile">
                        <form name="login" id="mobilelogin" class="login" method="post">
                            <p class="login-username">
                                <label for="user_login"></label>
                                <input type="text" name="username" class="username input" value="" size="20" placeholder="Username">
                            </p>
                            <p class="login-password">
                                <label for="user_pass"></label>
                                <input type="password" name="password" class="password input" value="" size="20" placeholder="Password">
                            </p>
                            <!-- <a class="lost" href="'.wp_lostpassword_url().'">Lost your password?</a> -->
                            <p class="login-submit">
                                <input type="submit" id="wp-submit" class="button-primary" value="Sign in">
                                <?php echo wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
                            </p>
                            <p class="status"></p>                              
                        </form>
                    </div>
                </li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
                    <a href="<?php echo esc_url( get_permalink( get_page_by_title( 'Sign Up' ) ) ); ?>"><span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Sign Up</span></span><span class="plus"></span></span></a>
                </li>
            <?php endif; ?>
        </ul>
        <?php wp_nav_menu(array(
            'menu' => 'Mobile Menu',
            'theme_location' => 'main-navigation' ,
            'container'  => '',
            'container_class' => '',
            'menu_class' => '',
            'menu_id' => '',
            'fallback_cb' => 'top_navigation_fallback',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'walker' => new DeployMikadoMobileNavigationWalker()
        )); ?>        
        <ul class="menu-header-menu-1">
            <?php if ( is_user_logged_in() ): ?>
            <li id="sticky-nav-menu-item-60" class="menu-item menu-item-type-post_type menu-item-object-page  narrow">
                <a href="<?php echo esc_url( get_permalink( get_page_by_title( 'Client services dashboard' ) ) ); ?>" class="">
                    <span class="item_outer">
                        <span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Client dashboard</span></span><span class="plus"></span>
                    </span>
                </a>
            </li>
            <li id="sticky-nav-menu-item-60" class="menu-item menu-item-type-post_type menu-item-object-page  narrow">
                <a href="<?php echo wp_logout_url(home_url()); ?>" class="">
                    <span class="item_outer">
                        <span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Sign out</span></span><span class="plus"></span>
                    </span>
                </a>
            </li>            
        <?php endif; ?>
        </ul>
    </div>
</nav>

<?php do_action('deploy_mikado_after_mobile_navigation'); ?>