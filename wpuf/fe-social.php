<?php
/* Get user info. */
global $id;
global $current_user, $wp_roles;
$user = wp_get_current_user();

$error = array();  
    
/* If profile was saved, update profile */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

    
/* Info to update */
    
if ( isset( $_POST['twitter'] ) ) 
        update_user_meta( $current_user->ID, 'twitter', esc_attr( $_POST['twitter'] ) );
    
if ( isset( $_POST['facebook'] ) ) 
        update_user_meta( $current_user->ID, 'facebook', esc_attr( $_POST['facebook'] ) );
    
if ( isset( $_POST['youtube'] ) ) 
        update_user_meta( $current_user->ID, 'youtube', esc_attr( $_POST['youtube'] ) );
    
if ( isset( $_POST['user_url'] ) ) 
        update_user_meta( $current_user->ID, 'user_url', esc_attr( $_POST['user_url'] ) );
        wp_update_user( array ('ID' => $user->ID, 'user_url' => esc_attr( $_POST['user_url'] ) )); 
    
if ( isset( $_POST['location'] ) )  
        update_user_meta( $current_user->ID, 'location', esc_attr( $_POST['location'] ) );    
    
if ( isset( $_POST['description'] ) ) 
        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );

if ( isset( $_POST['sidebarimageprofile'] ) ) 
        update_user_meta( $current_user->ID, 'sidebarimageprofile', esc_attr( $_POST['sidebarimageprofile'] ) );
    
if ( isset( $_POST['nickname'] ) ) 
        update_user_meta( $current_user->ID, 'nickname', esc_attr( $_POST['nickname'] ) );
        wp_update_user( array ('ID' => $user->ID, 'display_name' => esc_attr( $_POST['nickname'] ) ));

    
/* Action hook */
 if ( count($error) == 0 ) {
        do_action('edit_user_profile_update', $current_user->ID);
        wp_redirect( get_permalink().'?section=fe-social&updated=true' ); ?>
        <?php exit;
    }   
    
}
?>

<form class="wpuf-form wpuf-update-social-form" action="<?php the_permalink(); ?>?section=fe-social" method="post">
    
     <?php 
    if( isset( $_GET['updated'] ) ) { ?>
    <div style="" class="wpuf-success">
        
        <?php _e( 'Public info updated succesfully!', 'mundana' ); ?> 
        <a target="_blank" href="<?php echo get_author_posts_url( get_current_user_id() );?>"> <?php _e( 'View public profile', 'mundana' ); ?> <i class="fa fa-external-link"></i></a>
        
    </div> 
    <?php } ?> 
    

<ul class="wpuf-form form-label-left">
<li class="wpuf-el post_title">        
    <div class="wpuf-label">
        <label for="post_title"><?php _e( 'Twitter URL', 'mundana' ); ?></label>
    </div>
    <div class="wpuf-fields">
        <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" size="40"/>
    </div>
</li>
    
<li class="wpuf-el post_title">        
    <div class="wpuf-label">
        <label for="post_title"><?php _e( 'Facebook URL', 'mundana' ); ?></label>
    </div>
    <div class="wpuf-fields">
        <input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" size="40"/>
    </div>
</li>
    
<li class="wpuf-el post_title">        
    <div class="wpuf-label">
        <label for="post_title"><?php _e( 'YouTube URL', 'mundana' ); ?></label>
    </div>
    <div class="wpuf-fields">
        <input type="text" name="youtube" id="youtube" value="<?php echo esc_attr( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" size="40"/>
    </div>
</li>
    
<li class="wpuf-el post_title">        
    <div class="wpuf-label">
        <label for="post_title"><?php _e( 'Website URL', 'mundana' ); ?></label>
    </div>
    <div class="wpuf-fields">
        <input type="text" name="user_url" id="user_url" value="<?php echo esc_attr( get_the_author_meta( 'user_url', $user->ID ) ); ?>" class="regular-text" size="40"/>
    </div>
</li>
    
<li class="wpuf-el post_title">        
    <div class="wpuf-label">
       <label for="post_title"><?php _e( 'Location', 'mundana' ); ?></label>
    </div>
    <div class="wpuf-fields">
        <input type="text" name="location" id="location" value="<?php echo esc_attr( get_the_author_meta( 'location', $user->ID ) ); ?>" class="regular-text" size="40"/>
    </div>
</li>
    
<li class="wpuf-el post_title">        
    <div class="wpuf-label">
         <label for="post_title"><?php _e( 'Bio', 'mundana' ); ?></label>
    </div>
    <div class="wpuf-fields">
        <textarea name="description" id="description" rows="3" class="w-100"><?php echo esc_attr( get_the_author_meta( 'user_description', $user->ID ) ); ?>
        </textarea>
    </div>
</li>
    
<li class="wpuf-el post_title">        
    <div class="wpuf-label">
         <label for="post_title"><?php _e( 'Display Name', 'mundana' ); ?></label>
    </div>
    <div class="wpuf-fields">
        <input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( get_the_author_meta( 'nickname', $user->ID ) ); ?>" class="regular-text" size="40"/>        
    </div>
</li>
    

<li class="wpuf-el post_title">        
    <div class="wpuf-label">
       <label for="post_title"><?php _e( 'Sidebar Image - Tall', 'mundana' ); ?></label>
    </div>
    <div class="wpuf-fields">
        <input type="text" name="sidebarimageprofile" id="sidebarimageprofile" value="<?php echo esc_attr( get_the_author_meta( 'sidebarimageprofile', $user->ID ) ); ?>" class="regular-text" size="40" placeholder="https://unsplash.com/imagecover.jpg"/>
    </div>
</li>


<div class="clearfix"></div>
    
<?php do_action('edit_user_profile',$current_user); ?>
    
<li class="wpuf-submit">
<div class="wpuf-label">
    &nbsp;
</div>
<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'mundana'); ?>" />
<?php wp_nonce_field( 'update-user' ) ?>
<input name="action" type="hidden" id="action" value="update-user" />

</li><!-- .form-submit -->
    
</ul>
</form>
