<div class="row">
<div class="articleheader col-md-12 col-lg-8 mx-auto">
<?php  get_template_part( 'partials/headerpost', 'cats' ); ?>
<h1 class="display-4 article-headline mb-3"><?php the_title(); ?></h1>
<?php  get_template_part( 'partials/headerpost', 'meta' ); ?>
</div>
</div>

<?php the_post_thumbnail( 'full', array(
'class' => 'd-block featured-image img-fluid  mx-auto text-center mb-5 mt-5'
) ); ?>