<form role="search" method="get" class="row search-form justify-content-center" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div class="col-md-8">
    <input type="hidden" name="post_type" value="post" />
    <input type="search" class="search-field form-control btn-round"
           placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
           value="<?php echo get_search_query() ?>" name="s"
           title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
  </div>
  <div class="col-md-4">
    <input type="submit" class="search-submit btn btn-primary btn-round d-block w-100" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
  </div>
</form>