<?php
 /*
Template Name: Display Authors
*/
get_header();
?>

<div class="row listrecent listrecent listauthor justify-content-center">
    <div class="col-md-8 pr-4 pr-md-5">
        <div class="section-title">
            <h2 class="spanborder h4 text-capitalize"><span><?php the_title() ?></span></h2>
        </div>
        <?php 
        $display_admins = true;
        $order_by = 'post_count'; // 'nicename', 'email', 'url', 'registered', 'display_name', or 'post_count'
        $order = 'DESC';
        $roleadmin = get_users(array('role' => 'administrator'));
        $roleauthor = get_users(array('role' => 'author'));
        $rolecontributor = get_users(array('role' => 'contributor'));
        $role = array_merge($roleauthor, $roleadmin, $rolecontributor);
        $avatar_size = 60;
        $hide_empty = true; // hides authors with zero posts 
        $blogusers = get_users($role);
        $authors = array();

        foreach ($blogusers as $bloguser) {
            $user = get_userdata($bloguser->ID);
            if (!empty($hide_empty)) {
                $numposts = count_user_posts($user->ID);
                if ($numposts < 1) continue;
            }
            $authors[] = (array)$user;
        }

        foreach ($authors as $author) {
            $display_name = $author['data']->display_name;
            $description = get_user_meta($author['ID'], 'description', true);
            $twitter = get_user_meta($author['ID'], 'twitter', true);
            $facebook = get_user_meta($author['ID'], 'facebook', true);
            $location = get_user_meta($author['ID'], 'location', true);
            $youtube = get_user_meta($author['ID'], 'youtube', true);
            $website = $author['data']->user_url;
            $avatar = get_avatar($author['ID'], $avatar_size);
            $author_profile_url = get_author_posts_url($author['ID']);
            $user_post_count = count_user_posts($author['ID'], $post_type = 'post');
            $author_id = $author['ID'];
            ?>

        <div class="shadow-2 p-4 d-block d-md-flex text-center text-md-left mb-30">
            <div class="col-md-2 text-center"><div class="d-block"><?php echo $avatar; ?></div>
                <a href="<?php echo $author_profile_url; ?>" class="btn btn-outline-success btn-sm mt-3"><?php echo esc_attr__('Profile', 'mundana'); ?></a>

            </div>
            <div class="col-md-4">
                <a href="<?php echo $author_profile_url; ?>">
                    <h4 class="text-dark mb-3 mt-4 mt-md-0"> <?php echo $display_name; ?>
                    </h4>
                </a>
                <div class="text-muted">
                    <?php echo $description; ?>
                </div>
                <div class="mt-4">
                    <?php if ($twitter) { ?>
                    <a target="_blank" href="<?php echo $twitter; ?>"><i class="fa fa-twitter text-muted"></i></a> &nbsp;
                    <?php 
                } ?>
                    <?php if ($facebook) { ?>
                    <a target="_blank" href="<?php echo $facebook; ?>"><i class="fa fa-facebook text-muted"></i></a> &nbsp;
                    <?php 
                } ?>
                    <?php if ($youtube) { ?>
                    <a target="_blank" href="<?php echo $youtube; ?>"><i class="fa fa-youtube text-muted"></i></a> &nbsp;
                    <?php 
                } ?>
                    <?php if ($website) { ?>
                    <a target="_blank" href="<?php echo $website; ?>"><i class="fa fa-globe text-muted"></i></a> &nbsp;
                    <?php 
                } ?>
                </div>
            </div>

            <?php 
            $args = array(
                'author'        =>   $author_id,
                'posts_per_page' => 3
            );
            // The Loop
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) { ?>
            <div class="col-md-6 mt-4 mt-md-0">
                <?php while ($the_query->have_posts()) {
                    $the_query->the_post(); ?>
                <div class="row d-md-flex mb-3 text-left">
                    <div class="col-2 col-md-3">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('thumbnail');
                        } ?>
                    </div>
                    <div class="col-10 col-md-9">
                        <?php echo '<a class="d-block" href="' . get_the_permalink() . '"><h7 class="text-dark">' . get_the_title() . '</h7></a>';  ?>
                    </div>
                </div>
                <?php 
            } ?>
                <div class="text-left">
                    <a class="mt-3 text-center text-muted border-bottom" href="<?php echo $author_profile_url; ?>">
                        <small class="font-weight-normal">
                        <?php echo esc_attr__('View all ', 'mundana');
                        echo $user_post_count . ' ' . esc_attr__('Posts', 'mundana'); ?></small>
                    </a>
                </div>
            </div>

        </div>
        <?php
 /* Restore original Post Data */
        wp_reset_postdata();
    } else {
        // no posts found
    }
    ?>

        <?php 
    } ?>

    <!-- display categories -->
    <?php echo wowthemes_display_all_cats(); ?>
    <!-- end display categories -->

    </div>

 
         <!-- right sidebar (widgets if any & popular posts) -->
		<div class="col-md-4 col-lg-4 thesidebar">
            <!-- widgets -->
                <?php if ( is_active_sidebar( 'sidebar-home' ) ) : ?>
                    <div id="sidebar-home" class="sidebar-home widget-area" role="complementary">
                        <?php dynamic_sidebar( 'sidebar-home' ); ?>
                    </div>
                <?php endif; ?>
                <?php echo mundana_claps(); ?>
            <!-- end widgets -->
		</div>
        <!-- end right sidebar -->
    


</div>
<?php get_footer(); ?> 