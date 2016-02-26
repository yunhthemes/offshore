<?php if($fullwidth) : ?>
<div class="mkdf-full-width">
    <div class="mkdf-full-width-inner">
<?php else: ?>
<div class="mkdf-container">
    <div class="mkdf-container-inner clearfix">
<?php endif; ?>
        <div <?php deploy_mikado_class_attribute($holder_class); ?>>
            <?php if(post_password_required()) {
                echo get_the_password_form();
            } else {
                //load proper portfolio template
                deploy_mikado_get_module_template_part('templates/single/single', 'portfolio', $portfolio_template);

                //load portfolio comments
                deploy_mikado_get_module_template_part('templates/single/parts/comments', 'portfolio');

            } ?>
        </div>
    </div>
</div>