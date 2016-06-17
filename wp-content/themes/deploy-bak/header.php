<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php deploy_mikado_wp_title(); ?>
    <?php
    /**
     * @see deploy_mikado_header_meta() - hooked with 10
     * @see mkd_user_scalable - hooked with 10
     */
    ?>
	<?php do_action('deploy_mikado_header_meta'); ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php deploy_mikado_get_side_area(); ?>

<?php
if(deploy_mikado_options()->getOptionValue('smooth_page_transitions') === 'yes') { ?>
	<div class="mkdf-smooth-transition-loader mkdf-mimic-ajax">
		<div class="mkdf-st-loader">
			<div class="mkdf-st-loader1">
				<?php deploy_mikado_loading_spinners(); ?>
			</div>
		</div>
	</div>
<?php } ?>

<div class="mkdf-wrapper">
    <div class="mkdf-wrapper-inner">
        <?php deploy_mikado_get_header(); ?>

        <?php if(deploy_mikado_options()->getOptionValue('show_back_button') == 'yes') { ?>
            <a id="mkdf-back-to-top"  href="#">
	            <span class="mkdf-icon-stack">
                     <?php echo deploy_mikado_icon_collections()->renderIcon('arrow_carrot-up', 'font_elegant'); ?>
                </span>
                <span class="mkdf-back-to-top-inner">
                    <span class="mkdf-back-to-top-text"><?php esc_html_e('Top', 'deploy'); ?></span>
                </span>
            </a>
        <?php } ?>

        <div class="mkdf-content" <?php deploy_mikado_content_elem_style_attr(); ?>>
            <div class="mkdf-content-inner">