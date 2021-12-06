<?php
/**
* Archive
*/
get_header(); ?>
<div class="row justify-content-between">
    
  <!-- main -->
  <div class="col-md-8 pr-0 pr-md-6"> 
    <?php if ( have_posts() ) : ?>
    <div class="section-title">
      <h2 class="spanborder h4 text-capitalize">
        <span>
          <?php echo wp_title(); ?>
        </span>
      </h2> 
    </div>
      
    <!-- begin posts -->                             
    <?php while ( have_posts() ) : the_post(); ?>                
    <?php echo mundana_postbox(); ?>                           
    <?php endwhile; ?> 
    <!-- end post --> 
      
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
    <p>
      <?php _e( 'Sorry, no posts matched your criteria.', 'mundana' ); ?>
    </p>
    <?php endif; ?> 
    <?php wp_reset_query(); ?>
      
    <!-- display categories -->
    <?php echo wowthemes_display_all_cats();?>
    <!-- end display categories -->
      
  </div>    
  <!-- end main -->
    
  <!-- right sidebar (popular posts and widgets if any) -->
  <div class="col-md-4">
      
    <!-- widgets -->
    <?php if ( is_active_sidebar( 'sidebar-home' ) ) : ?>
    <div id="sidebar-home" class="sidebar-home widget-area" role="complementary">
      <?php dynamic_sidebar( 'sidebar-home' ); ?>
    </div>
    <?php endif; ?>
    <!-- end widgets -->
      
    <?php echo mundana_claps(); ?>
      
  </div>
  <!-- end right sidebar -->
    
</div>
<?php get_footer(); ?>
