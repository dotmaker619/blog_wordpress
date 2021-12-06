<?php
/* Get user info. */
global $id;
global $current_user, $wp_roles;
$user = wp_get_current_user(); 
if (shortcode_exists('plugin_delete_me')) { ?>
    <div class="deleteaccountlink">
    <?php echo do_shortcode( '[plugin_delete_me /]' ); ?>
    </div>
<?php } ?>

