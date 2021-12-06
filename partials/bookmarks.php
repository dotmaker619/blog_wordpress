<?php 
$disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
$disableauthorcard = get_theme_mod('disable_authorbox_sectionarticles_card');
if (function_exists('get_user_favorites')) {
$favorites = get_user_favorites();
if ( $favorites ) : 
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$favorites_query = new WP_Query(array(
'post_type' => array('post', 'download'), // If you have multiple post types, pass an array
'ignore_sticky_posts' => true,
'paged'        => $paged,
'post__in' => $favorites
));
if ( $favorites_query->have_posts() ) : ?>

<?php while ( $favorites_query->have_posts() ) : $favorites_query->the_post();
echo mundana_postbox();
endwhile; ?>

<div class="bottompagination">
<?php wp_bootstrap_pagination ( array(
'custom_query'    => TRUE,
'custom_query'    => $favorites_query
) ); ?>
</div>

<?php 
endif; wp_reset_postdata();
else : ?>
<div><?php _e( 'No bookmarks yet!', 'mundana' ); ?></div>
<?php endif;  } ?>