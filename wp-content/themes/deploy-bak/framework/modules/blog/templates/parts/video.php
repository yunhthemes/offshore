<?php $_video_type = get_post_meta(get_the_ID(), "mkdf_video_type_meta", true);?>
<?php if($_video_type == "youtube") { ?>
	<iframe  src="http://www.youtube.com/embed/<?php echo esc_attr(get_post_meta(get_the_ID(), "mkdf_post_video_id_meta", true));  ?>?wmode=transparent" wmode="Opaque" width="500" height="281" frameborder="0" allowfullscreen></iframe>
<?php } elseif ($_video_type == "vimeo"){ ?>
	<iframe src="http://player.vimeo.com/video/<?php echo esc_attr(get_post_meta(get_the_ID(), "mkdf_post_video_id_meta", true));  ?>?title=0&amp;byline=0&amp;portrait=0" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
<?php } elseif ($_video_type == "self"){ ?>
	<div class="mkdf-self-hosted-video-holder">
		<div class="mkdf-mobile-video-image" style="background-image: url(<?php echo esc_url(get_post_meta(get_the_ID(), "mkdf_post_video_image_meta", true));  ?>);"></div>
		<div class="mkdf-video-wrap">
			<video class="mkdf-self-hosted-video" poster="<?php echo esc_url(get_post_meta(get_the_ID(), "video_format_image", true));  ?>" preload="auto">
				<?php if(get_post_meta(get_the_ID(), "mkdf_post_video_webm_link_meta", true) != "") { ?> <source type="video/webm" src="<?php echo esc_url(get_post_meta(get_the_ID(), "mkdf_post_video_webm_link_meta", true));  ?>"> <?php } ?>
				<?php if(get_post_meta(get_the_ID(), "mkdf_post_video_mp4_link_meta", true) != "") { ?> <source type="video/mp4" src="<?php echo esc_url(get_post_meta(get_the_ID(), "mkdf_post_video_mp4_link_meta", true));  ?>"> <?php } ?>
				<?php if(get_post_meta(get_the_ID(), "mkdf_post_video_ogv_link_meta", true) != "") { ?> <source type="video/ogg" src="<?php echo esc_url(get_post_meta(get_the_ID(), "mkdf_post_video_ogv_link_meta", true));  ?>"> <?php } ?>
				<object width="320" height="240" type="application/x-shockwave-flash" data="<?php echo esc_url(get_template_directory_uri().'/js/flashmediaelement.swf'); ?>">
					<param name="movie" value="<?php echo esc_url(get_template_directory_uri().'/js/flashmediaelement.swf'); ?>" />
					<param name="flashvars" value="controls=true&file=<?php echo esc_url(get_post_meta(get_the_ID(), "mkdf_post_video_mp4_link_meta", true));  ?>" />
					<img src="<?php echo esc_url(get_post_meta(get_the_ID(), "mkdf_post_video_image_meta", true));  ?>" width="1920" height="800" title="No video playback capabilities" alt="<?php esc_attr_e('Video thumb', 'deploy') ?>" />
				</object>
			</video>
		</div>
	</div>
<?php } ?>