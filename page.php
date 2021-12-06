<?php
/**
 * Page
 */
get_header();
$hide_featimg = get_post_meta(get_the_ID(), "hide_featured_image_hide_featured_image_on_post", true);
$tall_featimg = get_post_meta(get_the_ID(), "tall_featured_image_tall_featured_image_on_post", true);
$backgroundImg = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');

if (has_post_thumbnail()) {?>
<div class="articleheader jumbotron jumbotron-fluid mb-0 pl-0 pt-0 pb-0 pr-0 bg-transparent position-relative">
    <div class="h-100 tofront">
        <div class="d-md-flex justify-content-between">
            <div class="pt-4 pb-4 pr-5 pt-md-5 pb-md-5 align-self-center">
                <h1 class="display-4 article-headline"><?php the_title();?></h1> 
            </div> 
            <div class="col-12 col-md-6 pl-0 pr-0 align-self-center">
                <?php the_post_thumbnail('large', array('class' => 'featured-image rounded img-fluid cardwithshadow onhoverup',
                )); ?>
            </div> 
        </div> 
    </div> 
</div>
<?php

} else {?> 
<div class="section-title">
<h1 class="page-headline spanborder"><span><?php the_title();?></span> </h1> 
</div><?php
}
?> 

<div class="row justify-content-center <?php if (has_post_thumbnail()) {echo 'mt-5';}?>">

    <div class="col-md-12"><?php while (have_posts()): the_post();?>

        <article class="article-page" id="post-<?php the_ID();?>" <?php post_class();?>>
        <?php the_content();
        wp_link_pages(array('before' => '<div class="page-links">' . __('Pages:', 'mundana'),
        'after' => '</div>',
        ));?>
        </article> 

        <?php // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()): comments_template();
        endif;
        endwhile; // End of the loop.
        ?>

    </div> 

</div>
<?php get_footer();