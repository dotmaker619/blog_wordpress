<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<?php wp_head(); ?>
<?php echo get_theme_mod( 'head_sectiontracking'); ?>
</head> 
    
<body <?php body_class(); ?>> 
        
<?php 
global $post;
global $post_ids;
$navbar_text_color = get_theme_mod( 'navbar_text_color');
$headersearch = get_theme_mod( 'mundana_headersearch' );
if ($navbar_text_color=="navbar-dark") { ?><style>.homelatest.removetoppadding, .removetoppadding {margin-top:0;}</style><?php }?>

    
<?php if (! has_nav_menu( 'headermenu' ) ) { ?> <style>
.mediumnavigation {padding-top:15px; padding-bottom:15px;}
.mediumnavigation.nav-up {padding-top:0;padding-bottom:0;}
</style><?php } ?>
           
<header id="MagicMenu" class="<?php if ($navbar_text_color=="navbar-dark") { echo 'navbar-dark'; } else { echo 'navbar-light'; } ?> fixed-top navbar mediumnavigation">

    
<div class="container">
       
        <div class="d-lg-flex justify-content-between align-items-center brandrow w-100">
            
            <!-- Begin Logo --> 
            <div class="logoarea">
                 <?php if ( get_theme_mod( 'logo_sectionlogonav' ) ) { ?>
                    <a class="blog-logo" href='<?php echo esc_url( home_url( '/' ) ); ?>' rel='home'><img src='<?php echo esc_url( get_theme_mod( 'logo_sectionlogonav' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
                    <?php } else { ?>
                    <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                <?php } ?>
            </div>
            <!-- End Logo --> 
            
            
        
            <!-- Secondary Top Menu -->
            
                <div class="navbar-expand-lg  d-lg-flex align-items-center text-lg-right">
                    
                <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#bs4navbar,#bs4navbartop" aria-controls="bs4navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="menuclose">X</span>
                <span class="navbar-toggler-icon"></span>
                </button>
                    
                 
                    
                <?php
                wp_nav_menu([
                 'menu'            => 'top',
                 'theme_location'  => 'extramenu',
                 'container'       => 'div',
                 'container_id'    => 'bs4navbartop',
                 'container_class' => 'collapse navbar-collapse',
                 'menu_id'         => false,
                 'menu_class'      => 'navbar-nav w-100 d-lg-flex align-items-center',
                 'depth'           => 2,
                 'fallback_cb'     => 'bs4navwalker::fallback',
                 'walker'          => new bs4navwalker()
                ]);
                ?>      
                    
                </div>
             
            <!-- Secondary Top Menu -->
                    
        </div>
        
    
        <!-- Main Menu -->
        <div class="navbar-expand-lg d-flex  align-items-center w-100">      
            
            <?php
            wp_nav_menu([
             'menu'            => 'top',
             'theme_location'  => 'headermenu',
             'container'       => 'div',
             'container_id'    => 'bs4navbar',
             'container_class' => 'collapse navbar-collapse',
             'menu_id'         => false,
             'menu_class'      => 'navbar-nav w-100 d-flex align-items-center',
             'depth'           => 2,
             'fallback_cb'     => 'bs4navwalker::fallback',
             'walker'          => new bs4navwalker()
            ]);
            ?>       
        </div>
        <!-- Main Menu -->
        
            
    </div>

</header>
    
       
<!-- Begin site-content
================================================== -->
    
<div class="container site-content"> 
   