<?php
/* Get user info. */
global $id;
global $current_user, $wp_roles;
$user = wp_get_current_user();

if (shortcode_exists('favourite-author-posts')) {echo do_shortcode ('[favourite-author-posts]');}?>