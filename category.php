<?php
/**
 * Category
 */
get_header(); 
$disableauthorcard = get_theme_mod( 'disable_authorbox_sectionarticles_card'); 
?>

<div class="row justify-content-between">

<?php 
     
    $i = 0; $counter = range(0, 200, 3);
    $post_counter = 0;
    if ( have_posts() ) : ?>
    
    <!-- main -->
    <div class="col-md-8 pr-4 pr-md-5">
        
        <div class="section-title">
        <h2 class="spanborder text-capitalize"><span><?php the_archive_title() ?></span></h2> 
        </div>
        
        <!-- begin posts -->                             
        <?php while ( have_posts() ) : the_post(); $post_counter++; ?>
            <?php 
            if ( ! is_paged() && $post_counter == 1) { 
                    echo mundana_postbox_style4();                    
                } else { ?>
            <?php echo mundana_postbox(); ?>  
                <?php } ?>
        <?php endwhile; ?> 
        <!-- end posts --> 

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
        <p><?php _e( 'Sorry, no posts matched your criteria.', 'mundana' ); ?></p>
        <?php endif; ?> 

        <!-- display categories -->
        <?php echo wowthemes_display_all_cats(); ?>
        <!-- end display categories -->
        
    </div>    
    <!-- end main -->
    
    <!-- right sidebar (popular posts and widgets if any) -->
    <div class="col-md-4 thesidebar">  
        <!-- widgets -->
                <?php if ( is_active_sidebar( 'sidebar-home' ) ) : ?>
                    <div id="sidebar-home" class="sidebar-home widget-area" role="complementary">
                        <?php dynamic_sidebar( 'sidebar-home' ); ?>
                    </div>
                <?php endif; ?>
            <!-- end widgets -->
        <?php
        if( class_exists( 'WPClapsApplause' ) ) {
        $disabledatecard = get_theme_mod( 'disable_date_sectionarticles_card');    
        $category = get_queried_object();
        $cat_id = $category->term_id; ?> 
        
        <div class="sticky-top sticky-sidebar-offset mundana_claps_popular_category">
        <h4 class="spanborder"><span><?php _e( 'Popular in', 'mundana' ); ?> <div class="text-capitalize d-inline">"<?php the_archive_title() ?>"</div> </span></h4>
        <ol class="list-featured">  

            <?php $args = array(
                        'post_type' => 'post',
                        'post_status'    => 'publish',
                        'cat' => $cat_id,
                        'numberposts' => 5,
                        'meta_key' => '_pt_claps',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC'
                    );
                    $most_loved = get_posts( $args );
                    foreach( $most_loved as $loved ) : 
                    $categories = get_the_category($loved); ?>                            
                        <li class="loved-item mb-4">
                            <span>
                            <h6>
                            <a class="text-dark" href="<?php echo get_permalink($loved->ID); ?>"><?php echo get_the_title($loved->ID); ?></a>
                            </h6>
                            <div class="text-muted">
                            <?php if ($disableauthorcard == 0) { ?><a class="text-muted text-capitalize" href="<?php echo get_author_posts_url($loved->post_author);?>"><?php echo get_the_author_meta( 'display_name');?></a><?php } ?>
                            <?php _e( 'in', 'mundana' ); ?> <?php if ( ! empty( $categories ) ) {
                            echo '<a class="text-capitalize" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                            } ?> 
                            <?php if ($disabledatecard == 0) { ?> &middot; <?php echo get_the_date('M j',$loved->ID);?><?php } ?>
                            <?php if ($disabledatecard == 0) { ?>
                            <svg style="fill: rgba(0,0,0,0.45); margin-left: 3px; display:inline-black; margin-top: -2px;" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php 
                            if ( get_the_modified_time( 'U',$loved->ID ) > get_the_time( 'U',$loved->ID ) ) {
                            echo __('Updated ', 'mundana') .get_the_modified_time('M j, Y',$loved->ID);
                            } else {
                            echo get_the_date('M j, Y',$loved->ID);   
                            }
                            ?>">><path d="M12 .288l2.833 8.718h9.167l-7.417 5.389 2.833 8.718-7.416-5.388-7.417 5.388 2.833-8.718-7.416-5.389h9.167z"/></svg>
                            <?php }  ?>
                            </div>
                            </span>
                        </li>
                    <?php endforeach; 
                }
            ?>
            
        </ol>
        </div>
        
    </div>
    <!-- end right sidebar -->

</div>    
        

<?php get_footer(); ?>