<?php
$disableauthorbox = get_theme_mod('disable_authorbox_sectionarticles');
$disablereadingtime = get_theme_mod('disable_readingtime_sectionarticles');
$disabledate = get_theme_mod('disable_date_sectionarticles');
?>

<div class="d-flex align-items-center">
    <?php if ($disableauthorbox == 0) {?>
    <a class="mr-3" href="<?php echo get_author_posts_url($post->post_author); ?>">
        <?php echo get_avatar(get_the_author_meta('user_email'), '60', null, null, array('class' => array('rounded-circle imgavt'))); ?>
    </a><?php

}?>
    <small>
        <?php if ($disableauthorbox == 0) {?><a class="text-muted mb-2" href="<?php echo get_author_posts_url($post->post_author); ?>"><?php _e('Written by', 'mundana');?> <span class="text-capitalize"><?php echo get_the_author_meta('display_name'); ?></span></a>
        <?php
if (shortcode_exists('subscribe-author-button')) {?>
        <span class="ml-1">
            <?php echo do_shortcode('[subscribe-author-button]'); ?>
        </span>
        <?php

}?>
        <?php

}?>
        <span class="text-muted d-block">
            <?php if ($disabledate == 0) {?>
            <span class="post-date">
                <time class="post-date">
                    <?php echo get_the_date('M j'); ?>
                </time></span> &middot;
            <?php

}?>
            <?php if ($disablereadingtime == 0) {?>
            <span class="readingtime"><?php echo mundana_estimated_reading_time() ?></span>
            <?php

}?>
            <?php if ($disabledate == 0) {?><?php echo mundana_tooltip_date(); ?><?php

}?>
        </span>
    </small>
</div>