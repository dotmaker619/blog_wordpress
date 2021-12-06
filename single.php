<?php
/**
 * Single
 */
get_header();
wp_enqueue_script('mundana-progress-bar');
$disableauthorbox = get_theme_mod('disable_authorbox_sectionarticles');
$disablereadingtime = get_theme_mod('disable_readingtime_sectionarticles');
$disabledate = get_theme_mod('disable_date_sectionarticles');
$disableshare = get_theme_mod('disable_share_sectionarticles');
$disablerp = get_theme_mod('disable_rp_sectionarticles');
$disablecats = get_theme_mod('disable_cats_sectionarticles');
$disabletags = get_theme_mod('disable_tags_sectionarticles');
$hide_featimg =  get_post_meta(get_the_ID(), "hide_featured_image_hide_featured_image_on_post", true);
$tall_featimg =  get_post_meta(get_the_ID(), "tall_featured_image_tall_featured_image_on_post", true);
$fullw_featimg =  get_post_meta(get_the_ID(), "full_width_featured_image_full_width_featured_image_on_post", true);
$text_before_follow = get_theme_mod('text_before_follow', '<b>Follow us</b> on');
$fb_url   = get_theme_mod('fb_url');
$twitter_url  = get_theme_mod('twitter_url');
$youtube_url  = get_theme_mod('youtube_url');
$pinterest_url  = get_theme_mod('pinterest_url');
$linkedin_url  = get_theme_mod('linkedin_url');
?>


<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

<progress class="reading-progress-bar"></progress>

<div id="post-<?php the_ID(); ?>">

    <?php 
    if (has_post_thumbnail()) {
    
      if ($fullw_featimg) {
        get_template_part('partials/headerpost', 'fullimage');
      } else 
      if ($tall_featimg) {
        get_template_part('partials/headerpost', 'tallimage');
      } else
      if (!$hide_featimg) {
        get_template_part('partials/headerpost', 'default');
      } 
    }
    ?>

    <div class="alignfullincol">

        <div class="container-fluid max1140">

            <!-- row -->
            <div class="row mb-5 mt-5">

                <!-- main column -->
                <div class="col-md-8">

                    <!-- unless featured image is hidden or not present -->
                    <?php if (($hide_featimg) || (!has_post_thumbnail())) { ?>
                    <div class="articleheader jumbotron jumbotron-fluid removetoppadding mb-5 pl-0 pt-0 pb-0 pr-0 bg-transparent position-relative">
                        <p class="text-uppercase font-weight-bold articleheader-category">
                            <?php get_template_part('partials/headerpost', 'cats'); ?>
                        </p>
                        <h1 class="display-4 article-headline mb-3"><?php the_title(); ?></h1>
                        <?php get_template_part('partials/headerpost', 'meta'); ?>
                    </div>
                    <?php 
                } ?>
                    <!-- end unless featured image hidden or not present -->

                    <!-- widget before article -->
                    <?php if (is_active_sidebar('sidebar-before-post')) : ?>
                    <div id="sidebar-before-post" class="sidebar-before-post widget-area" role="complementary">
                        <?php dynamic_sidebar('sidebar-before-post'); ?>
                    </div>
                    <?php endif; ?>
                    <!-- end widget before article -->

                    <article class="article-post">
                        <?php the_content(); ?>
                        <div class="clearfix"></div>
                    </article>

                    <!-- tags -->
                    <div class="after-post-tags">
                        <?php if ($disabletags == 0) { ?>
                        <div class="post-categories aretags">
                            <?php 
                            if (is_array(get_the_tags($post->ID)) || is_object(get_the_tags($post->ID))) :
                                foreach (get_the_tags($post->ID) as $tag) {
                                    echo '<a class="tag-link bg-light" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a> ';
                                }
                            endif;
                            ?>
                        </div>
                        <?php 
                    } ?>
                    </div>
                    <!-- end tags -->

                    <!-- widget after article -->
                    <?php if (is_active_sidebar('sidebar-after-post')) : ?>
                    <div id="sidebar-after-post" class="sidebar-after-post widget-area" role="complementary">
                        <?php dynamic_sidebar('sidebar-after-post'); ?>
                    </div>
                    <?php endif; ?>
                    <!-- end widget after article -->

                    <!-- author box -->
                    <?php if ($disableauthorbox == 0) { ?>
                    <div class="d-flex mt-5 mb-5 align-items-center">
                        <div class="col-2">
                            <a href="<?php echo get_author_posts_url($post->post_author); ?>">
                                <?php echo get_avatar(get_the_author_meta('user_email'), '80', null, null, array('class' => array('rounded-circle imgavt mr-4'))); ?>
                            </a>
                        </div>
                        <div class="ml-2">
                            <a class="text-muted" href="<?php echo get_author_posts_url($post->post_author); ?>">
                                <h5><?php _e('Written by ', 'mundana'); ?> <span class="text-capitalize"><?php echo get_the_author_meta('display_name'); ?></span>
                                </h5>
                            </a>
                            <span class="text-muted d-block mb-3">
                                <?php echo the_author_meta('description'); ?>
                            </span>
                            <span class="text-muted d-block">
                                <a href="<?php echo get_author_posts_url($post->post_author); ?>" class="btn btn-outline-success btn-sm">Profile</a>
                            </span>
                        </div>
                    </div>
                    <?php 
                } ?>
                    <!-- end author box -->

                </div>
                <!-- end main column -->


                <!-- share -->
                <div class="<?php if (!is_active_sidebar('sidebar-posts')) { ?> col-md-2 mb-4 <?php 
                                                                                            } else {
                                                                                                echo 'col-md-1';
                                                                                            } ?> order-md-first">
                    <div class="sticky-top sticky-sidebar-offset">
                        <div class="share text-center">

                            <div class="sidebarapplause">
                                <?php
                                if (class_exists('WPClapsApplause')) {
                                    echo do_shortcode('[wp_claps_applause ]');
                                }
                                ?>
                            </div>

                            <?php if ($disableshare == 0) { ?>
                            <p class="sharecolour">
                                <?php _e('Share', 'mundana'); ?>
                            </p>
                            <?php mundana_share_post(); ?>
                            <?php 
                        } ?>

                            <?php if (comments_open() || get_comments_number()) : ?>
                            <div class="sep"></div>
                            <div class="d-none d-md-block">
                                <p>
                                    <?php _e('Reply', 'mundana'); ?>
                                </p>
                                <ul>
                                    <li>
                                        <a class="smoothscroll" href="#comments"><?php printf(_nx('1', '%1$s', get_comments_number(), 'comments title', 'mundana'), number_format_i18n(get_comments_number()), get_the_title()); ?><br />
                                            <svg class="svgIcon-use" width="29" height="29" viewBox="0 0 29 29">
                                                <path d="M21.27 20.058c1.89-1.826 2.754-4.17 2.754-6.674C24.024 8.21 19.67 4 14.1 4 8.53 4 4 8.21 4 13.384c0 5.175 4.53 9.385 10.1 9.385 1.007 0 2-.14 2.95-.41.285.25.592.49.918.7 1.306.87 2.716 1.31 4.19 1.31.276-.01.494-.14.6-.36a.625.625 0 0 0-.052-.65c-.61-.84-1.042-1.71-1.282-2.58a5.417 5.417 0 0 1-.154-.75zm-3.85 1.324l-.083-.28-.388.12a9.72 9.72 0 0 1-2.85.424c-4.96 0-8.99-3.706-8.99-8.262 0-4.556 4.03-8.263 8.99-8.263 4.95 0 8.77 3.71 8.77 8.27 0 2.25-.75 4.35-2.5 5.92l-.24.21v.32c0 .07 0 .19.02.37.03.29.1.6.19.92.19.7.49 1.4.89 2.08-.93-.14-1.83-.49-2.67-1.06-.34-.22-.88-.48-1.16-.74z">
                                                </path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- end share -->


                <!-- sidebar posts -->
                <?php if (is_active_sidebar('sidebar-posts')) : ?>
                <div class="col-lg-3">
                    <div id="sidebar-posts" class="sidebar-posts widget-area" role="complementary">
                        <?php dynamic_sidebar('sidebar-posts'); ?>
                    </div>
                </div>
                <?php endif; ?>
                <!-- end sidebar posts -->


            </div><!-- end row -->

        </div><!-- end container-fluid -->

    </div><!-- end alignfullincol -->

</div>
<!-- end post id -->

<?php endwhile; ?>


<?php else : ?>
<p><?php _e('Sorry, no posts matched your criteria.', 'mundana'); ?></p>
<?php endif; ?>


<!-- related posts -->
<?php if ($disablerp == 0) { ?>
<?php echo mundana_related_posts() ?>
<?php 
} ?>
<!-- end related posts -->


<!-- comments -->
<?php 
if (comments_open() || get_comments_number()) :
    comments_template();
endif;
?>
<!-- end comments -->

<!-- bottom fixed bar -->
<div class="alertbar">
    <div class="container">
        <?php $next_post = get_next_post(); ?>
        <div class="d-flex <?php if ((is_a($next_post, 'WP_Post')) && (true == get_theme_mod('show_nextpost', true))) {
                                echo 'justify-content-md-center justify-content-lg-between';
                            } else {
                                echo 'justify-content-center';
                            } ?> align-items-center">

            <div class="follow-links">

                <?php echo do_shortcode($text_before_follow); ?>

                <?php if (true == get_theme_mod('show_fb_btn', true)) { ?>
                <a target="_blank" href="<?php echo $fb_url; ?>" class="followlink text-fbblue"><i class="fa fa-facebook"></i></a>
                <?php 
            } ?>

                <?php if (true == get_theme_mod('show_twitter_btn', true)) { ?>
                <a target="_blank" href="<?php echo $twitter_url; ?>" class="followlink text-twblue"><i class="fa fa-twitter"></i></a>
                <?php 
            } ?>

                <?php if (true == get_theme_mod('show_youtube_btn', true)) { ?>
                <a target="_blank" href="<?php echo $youtube_url; ?>" class="followlink text-youtubered"><i class="fa fa-youtube"></i></a>
                <?php 
            } ?>

                <?php if (true == get_theme_mod('show_pinterest_btn', true)) { ?>
                <a target="_blank" href="<?php echo $pinterest_url; ?>" class="followlink text-pinterestred"><i class="fa fa-pinterest"></i></a>
                <?php 
            } ?>

                <?php if (true == get_theme_mod('show_linkedin_btn', true)) { ?>
                <a target="_blank" href="<?php echo $linkedin_url; ?>" class="followlink text-linkedinblue"><i class="fa fa-linkedin"></i></a>
                <?php 
            } ?>

            </div>

            <?php 
            if (true == get_theme_mod('show_nextpost', true)) {
                if (is_a($next_post, 'WP_Post')) : ?>
            <div class="d-none d-lg-flex pt-3 pb-3 align-items-center">
                <small class="font-weight-light mr-2"><?php _e('Up Next:', 'mundana'); ?></small>
                <a class="text-dark font-weight-bold text-right d-flex align-items-center upnext" href="<?php echo get_permalink($next_post->ID); ?>">
                    <?php echo get_the_post_thumbnail($next_post->ID, 'thumbnail'); ?>
                    <?php echo get_the_title($next_post->ID); ?>
                </a>
            </div>
            <?php endif; ?>
            <?php 
        } ?>
        </div>
    </div>
</div>
<!-- end bottom fixed bar -->

<?php get_footer(); ?> 