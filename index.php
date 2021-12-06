<?php
/**
 * Index
 */
get_header();
?>
  
<?php if ( is_home() ) :


    if (is_paged()) {  } else { ?>
    <h1 class="al_center"><b>Featured Posts</b></h1>
    <!-- begin sticky post -->
    <div class="alignfullincol">
    <div class="container homelatest removetoppadding">
    <?php 

    $i = 0; $counter = range(0, 200, 3);
    $post_counter = 0;
    $sticky = get_option('sticky_posts');
    if (!empty($sticky)) {
        rsort($sticky);
        $args = array(
            'post__in' => $sticky,
        );
        query_posts($args);
    ?>
    <div class="row justify-content-center h-100 listrecent listrelated mb-4">
        <?php while ( have_posts() ) : the_post(); $post_counter++; ?>
            <?php 
            if ( $post_counter == 1) { 
                    echo mundana_featured();                    
                } else if ( $post_counter < 5) { ?>
                
                    <div class="col-sm-6 mb-4 mb-md-0 col-md-4">
                        <?php echo mundana_related_postbox(); ?>  
                    </div>
                
                <?php } ?>
        <?php endwhile; ?> 
    </div>
    <?php 
        wp_reset_query();
    }
    ?>
    </div>
    </div>
    <!-- end sticky post -->

    <?php 
        $mundana_count_posts = wp_count_posts();
        $mundana_published_posts = $mundana_count_posts->publish;
    ?>

    <!-- first 5 posts on top --> 
    <!-- end first 5 posts on top and open a new container -->
    
 

<?php } endif; ?> <!-- we now close if it's frontpage, else go on -->  

    
<?php 
if ( have_posts() ) :  while (have_posts()) : the_post();
        if ( $first = !isset( $first ) ) { ?>            
            <div class="row">
            <div class="col-md-8 col-lg-8 pr-md-5">           
            <h2 class="spanborder h4">
            <?php if (is_search()) { ?>
            <?php _e( 'Search results for ', 'mundana' ); ?> <span>"<?php echo get_query_var('s');?>"</span>
            <?php } else { ?>
            <span><?php _e( 'Latest Posts', 'mundana' ); ?></span>
            <?php } ?>
            </h2>
            <?php echo mundana_postbox_style4();

            } else { 
            echo mundana_postbox_style4();
            }

            endwhile;
            wp_reset_query();?>

            <!-- pagination -->                     
            <div class="bottompagination">
            <?php wp_bootstrap_pagination( array(
            'previous_string' => '<i class="fa fa-angle-double-left"></i>',
            'next_string' => '<i class="fa fa-angle-double-right"></i>',
            'before_output' => '<span class="navigation">',
            'after_output' => '</span>'
            ) ); ?> 
            </div> 
            <!-- end pagination -->

            <?php else : ?>

                <div class="row"><div class="col-md-8">

            <?php endif; ?>

            <!-- display categories -->
            <?php echo wowthemes_display_all_cats(); ?>
            <!-- end display categories -->

            </div>
    
    
      <!-- right sidebar (widgets if any & popular posts) -->
		<div class="col-md-4 col-lg-4 thesidebar">
            <!-- widgets -->
                <?php if ( is_active_sidebar( 'sidebar-home' ) ) : ?>
                    <div id="sidebar-home" class="sidebar-home widget-area" role="complementary">
                        <?php dynamic_sidebar( 'sidebar-home' ); ?>
                    </div>
                <?php endif; ?>
                <?php echo mundana_claps(); ?>
            <!-- end widgets -->
		</div>
        <!-- end right sidebar -->
    
</div>
<?php get_footer(); ?>