<?php
/**
 * Page
 */
get_header(); ?>

 <div class="section-title justify-content-between">
        <h1 class="spanborder h2 text-capitalize d-flex justify-content-between"><span><?php woocommerce_page_title(); ?></span>  <span class="text-right align-self-end pb-1 border-0"><?php woocommerce_breadcrumb(); ?></span></h1>        
        </div>
    
    <div class="row justify-content-center">        
        <div class="<?php if ( is_active_sidebar( 'sidebar-woocommerce' ) ) { ?> col-md-9 <?php } else { ?> col-md-12 <?php } ?>">
			<?php woocommerce_content(); ?>
		</div>        
        <?php if ( is_active_sidebar( 'sidebar-woocommerce' ) ) : ?>
            <div class="col-md-3">               
                <div id="sidebarwoocommerce" class="widget-area" role="complementary">
                <?php if ( ! dynamic_sidebar( 'sidebar-woocommerce' ) ) :
                endif; ?>
                </div>                
            </div>
        <?php endif; ?>
	</div>

<?php get_footer();?>