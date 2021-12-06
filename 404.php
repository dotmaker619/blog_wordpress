<?php
/**
* 404
*/
get_header(); ?>
<div class="container"> 
  <div class="row justify-content-center listrecent listrelated align-items-center">
    <div class="col-md-12 align-items-center text-center">
      <p>
      </p>
      <h1 class="page-title title-xxl">
        <?php _e( '404', 'mundana' ); ?>
        <small>
          <?php _e( 'Page not found', 'mundana' ); ?>
        </small>
      </h1>
      <div class="page-content">
        <p class="text-muted mt-4 mb-4">
          <?php _e( 'Maybe try a search?', 'mundana' ); ?>
        </p>				        
        <form role="search" method="get" class="row search-form justify-content-center" action="<?php echo home_url( '/' ); ?>">
          <div class="col-md-5">
            <input type="hidden" name="post_type" value="post" />
            <input type="search" class="search-field form-control btn-round"
                   placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
                   value="<?php echo get_search_query() ?>" name="s"
                   title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
          </div>
          <div class="col-md-2">
            <input type="submit" class="search-submit btn btn-primary btn-round d-block w-100" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php get_footer();
