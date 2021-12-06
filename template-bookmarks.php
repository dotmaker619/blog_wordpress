<?php
/*
Template Name: Bookmarks
*/
get_header();
?>
<div class="row justify-content-between">
<div class="col-md-8">
<div class="section-title">
<h2 class="spanborder h4 text-capitalize"><span><?php the_title() ?></span></h2>
</div>

<?php get_template_part('partials/bookmarks'); ?>

<!-- display categories -->
<?php echo wowthemes_display_all_cats(); ?>
<!-- end display categories -->

</div>

<!-- right sidebar (popular posts and widgets if any) -->
<div class="col-md-4 thesidebar">
<div class="sticky-top sticky-sidebar-offset mundana_claps_popular_category">
<h4 class="font-weight-bold spanborder"><span class="border-0"><?php _e('Top Bookmarks', 'mundana'); ?> </span>
</h4>

<?php
$disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
$disableauthorcard = get_theme_mod('disable_authorbox_sectionarticles_card');
$allfavorites_query = new WP_Query(array(
'post_type' => array('post'),
'posts_per_page' => 5,
'meta_key' => 'simplefavorites_count',
'orderby' => 'meta_value_num',
'order' => 'DESC',
'ignore_sticky_posts' => true
));
if ($allfavorites_query->have_posts()) :
echo '<ol class="list-featured">';
while ($allfavorites_query->have_posts()) : $allfavorites_query->the_post(); ?>
<li class="mb-4">
<span>
<h6><a class="text-dark" href="<?php echo get_permalink($allfavorites_query->ID); ?>"><?php echo get_the_title(); ?></a>
</h6>
<div class="text-muted">
<?php if ($disableauthorcard == 0) { ?><a class="text-muted text-capitalize" href="<?php echo get_author_posts_url($allfavorites_query->post_author); ?>"><?php echo get_the_author_meta('display_name'); ?></a><?php 
                                                                                                                                                } ?>
<?php if ($disabledatecard == 0) { ?> &middot;
<?php echo get_the_date('M j', $allfavorites_query->ID); ?><?php 
} ?>
<?php if ($disabledatecard == 0) { ?>
<svg style="fill: rgba(0,0,0,0.45); margin-left: 3px; display:inline-black; margin-top: -2px;" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if (get_the_modified_time('U', $allfavorites_query->ID) > get_the_time('U', $allfavorites_query->ID)) {
                                                                                                                                                                                          echo __('Updated ', 'mundana') . get_the_modified_time('M j, Y', $allfavorites_query->ID);
                                                                                                                                                                                       } else {
                                                                                                                                                                                          echo get_the_date('M j, Y', $allfavorites_query->ID);
                                                                                                                                                                                       } ?>">>
<path d="M12 .288l2.833 8.718h9.167l-7.417 5.389 2.833 8.718-7.416-5.388-7.417 5.388 2.833-8.718-7.416-5.389h9.167z" />
</svg>
<?php 
}  ?>
</div>
</span>
</li>
<?php endwhile;
echo '</ol>';
endif;
wp_reset_postdata(); ?>
</div>
</div>

</div>

<?php get_footer(); ?> 