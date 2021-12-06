</div> <!-- / end container site-content -->

<a href="" class="back-to-top"> 
    <i class="fa fa-angle-up"></i>
</a>

<div class="container text-center text-md-left">
<footer class="footer text-muted d-md-flex justify-content-between align-items-center pt-4 pb-4 border-top" itemscope="itemscope" itemtype="http://schema.org/WPFooter" role="contentinfo"> 
    <div> <?php echo get_theme_mod( 'footer_textleft', '&copy; Website Name. All rights reserved.'); ?> </div> 
    <div class="text-md-right"> <?php echo get_theme_mod( 'footer_textright', 'Mundana Theme by WowThemesNet.'); ?> </div>
</footer>
</div>



<?php 
$disableschema = get_theme_mod( 'disable_schema');
if ($disableschema == 0) {
html_schema(); 
} ?> 

<?php wp_footer(); ?>
<?php echo get_theme_mod( 'footer_sectiontracking'); ?>



</body>     
</html>
