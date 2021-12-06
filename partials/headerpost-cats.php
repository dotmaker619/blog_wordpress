<?php $disablecats = get_theme_mod( 'disable_cats_sectionarticles'); ?>

<p class="text-uppercase font-weight-bold articleheader-category">
   <?php if ($disablecats == 0) {
   the_category( ', ' );
   } ?>
</p>
