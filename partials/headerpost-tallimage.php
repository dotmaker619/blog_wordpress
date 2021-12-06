<?php
$disableartexcerpt = get_theme_mod('disable_excerpt_sectionarticles');
?>
<div class="articleheader jumbotron jumbotron-fluid removetoppadding mb-0 pl-0 pt-0 pb-0 pr-0 bg-transparent position-relative">
   <div class="h-100 tofront">
      <div class="d-md-flex justify-content-center justify-content-between">
         <div class="pt-4 pb-4 pt-md-5 pb-md-5 pr-md-5 align-self-center">
            <?php get_template_part( 'partials/headerpost', 'cats' ); ?>        
            <h1 class="display-4 article-headline mb-3"><?php the_title(); ?></h1>
            <?php if ($disableartexcerpt == 0) {?>
            <p class="mb-3 text-muted lead d-none d-md-block"><?php echo excerpt(23); ?></p>
            <?php } ?>
            <?php  get_template_part( 'partials/headerpost', 'meta' ); ?>
         </div>
         <div class="col-12 col-md-6 pt-0 pb-0 introimg pr-0 pl-0 text-right">
            <?php the_post_thumbnail( 'single-tall-image', array(
            'class' => 'featured-image single-tall-image onhoverup'
            ) ); ?>
         </div>
      </div>     
   </div>
</div>
