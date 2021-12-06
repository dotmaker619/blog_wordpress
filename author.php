<?php
/**
 * Author
 */
get_header();
$author = get_queried_object();
$twitter = $author->twitter;
$facebook = $author->facebook;
$youtube = $author->youtube;
$location = $author->location;
$sidebarimageprofile = $author->sidebarimageprofile;
$website = $author->user_url;
$description = $author->description;
$urlposts = get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename'));
$get_author_id = get_the_author_meta('ID');
$get_author_about = get_the_author_meta('authorabout');
$get_author_gravatar = get_avatar($get_author_id);
$author_intro_width = get_theme_mod('author_intro_width');
?>

<div class="<?php if (!empty($sidebarimageprofile)) { ?>alignfull removetoppadding h-100 <?php } ?>">
<div class="row <?php if (empty($sidebarimageprofile)) { ?>justify-content-center <?php } ?>">

<?php if (!empty($sidebarimageprofile)) { ?>
<div class="col-md-4">
<div class="sticky-top sticky-sidebar-offset-menu authorbkg">
<img src="<?php echo esc_html($sidebarimageprofile);?>">
</div>
</div>
<?php } ?>

<div class="<?php if (!empty($sidebarimageprofile)) { echo 'col-md-6 pl-md-5'; } else { echo 'col-md-8';} ?> pt-4 order-first order-md-last">

<div class="profile-card-2 forauthor mb-5">

<div class="d-flex justify-content-between align-items-center">

<div class="card-text text-muted shortbio">

<div class="d-flex align-items-center">

<h1 class="text-dark mb-0">
    <?php echo $author->display_name; ?>
</h1>

<?php
if (shortcode_exists('subscribe-author-button')) { ?>
<div class="ml-2">
<?php echo do_shortcode('[subscribe-author-button]'); ?>
</div>
<?php } ?>

</div>

<?php if (!empty($location)) { ?>
<?php echo $location; ?>
<?php } ?>

<?php if (!empty($description)) { ?>
<p class="text-muted mt-3">
<?php echo $description; ?>
</p>
<?php } ?>             

<div class="icon-block mt-1 mb-2">
<div>
<?php if ($twitter) { ?>
<a target="_blank" href="<?php echo $twitter; ?>">
<i class="fa fa-twitter">
</i>
</a> &nbsp;
<?php } ?>

<?php if ($facebook) { ?>
<a target="_blank" href="<?php echo $facebook; ?>">
<i class="fa fa-facebook">
</i>
</a> &nbsp;
<?php  } ?>

<?php if ($youtube) { ?>
<a target="_blank" href="<?php echo $youtube; ?>">
<i class="fa fa-youtube">
</i>
</a> &nbsp;
<?php } ?>

<?php if (!empty($website)) { ?>
<a target="_blank" href="<?php echo $website; ?>">
<i class="fa fa-globe">
</i>
</a> &nbsp;
<?php } ?>

</div>
</div>

</div>

<div class="col-md-3 text-right">
<?php echo $get_author_gravatar;?>
</div>

</div>


<?php if (!empty($get_author_about)) { ?>
<div class="mt-4 text-muted longdescription">
<?php echo wp_kses_post (wpautop($get_author_about)); ?>
</div>
<?php } ?>

</div>


<section class="authorbox" id="postsbyauthor">
<?php
$i = 0;
$counter = range(0, 200, 3);
$post_counter = 0; ?>

<div class="listrecent">

<?php if (have_posts()) : ?>
<h4 class="mb-4 h5 font-weight-bold spanborder">
<span>
<?php echo the_author_posts(); ?>
</span>
<?php _e('stories by ', 'mundana'); ?> <?php echo get_the_author_meta('display_name'); ?>
</h4>

<!-- begin post -->
<?php while (have_posts()) : the_post();
$post_counter++; ?>
<?php if (is_paged()) { ?> <style>.longdescription {display:none;}</style><?php } ?>
<?php 
if (!is_paged() && $post_counter == 1) {
echo mundana_postbox_style4();
} else {
echo mundana_postbox();
}
endwhile; ?>
<!-- end post -->

<!-- pagination -->
<div class="bottompagination mt-4">
<?php wp_bootstrap_pagination(array(
'previous_string' => '<i class="fa fa-angle-double-left"></i>',
'next_string' => '<i class="fa fa-angle-double-right"></i>',
'before_output' => '<span class="navigation">',
'after_output' => '</span>',
)); ?>
</div>
<!-- end pagination -->

<?php else : ?>
<p>
<?php _e('No published posts yet.', 'mundana'); ?>
</p>
<?php endif; ?>

</div>

</section>

</div>
</div>
</div>
<?php get_footer(); ?>