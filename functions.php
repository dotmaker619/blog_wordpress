<?php

//-----------------------------------------------------
// Setup
//-----------------------------------------------------
if (!function_exists('mundana_setup')) :

function mundana_setup()
{
if (!isset($content_width)) {
		$content_width = 730; /* pixels */
}
load_theme_textdomain('mundana', get_template_directory() . '/languages');
add_theme_support('automatic-feed-links');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('woocommerce');

add_image_size('postbox-style2', 548, 250, array('center', 'top'));
add_image_size('postbox-style2-right', 404, 250, array('center', 'top'));
add_image_size('postbox-style3', 168, 147, array('center', 'top'));
add_image_size('postbox-style4', 683, 250, array('center', 'top'));
add_image_size('postbox-related', 470, 216, array('center', 'top'));

set_post_thumbnail_size( 250, 150, array( 'center', 'center')  );


add_theme_support('html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
));
add_theme_support('wp-block-styles');
add_theme_support('align-wide');

register_nav_menus(array(
		'headermenu' => 'Main Menu',
		'extramenu' => 'Extra Menu',
));
}
endif;
add_action('after_setup_theme', 'mundana_setup');


//-----------------------------------------------------
// Scripts & Styles
//-----------------------------------------------------
if (!function_exists('mundana_scripts')) {
/**
 * Load theme's JavaScript and CSS sources.
 */
function mundana_scripts()
{
wp_enqueue_style( 'font-awesome4', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
// Get the theme data.
$the_theme     = wp_get_theme();
$theme_version = $the_theme->get('Version');

$css_version = $theme_version . '.' . filemtime(get_template_directory() . '/assets/css/theme.css');
wp_enqueue_style('mundana-styles', get_stylesheet_directory_uri() . '/assets/css/theme.css', array(), $css_version);

wp_enqueue_script('jquery');

$js_version = $theme_version . '.' . filemtime(get_template_directory() . '/assets/js/theme.min.js');
wp_enqueue_script('mundana-scripts', get_template_directory_uri() . '/assets/js/theme.min.js', array(), $js_version, true);
wp_register_script('mundana-progress-bar', get_template_directory_uri() . '/assets/js/progress-bar.js', array(), $js_version, true);
if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
}
}
}
add_action('wp_enqueue_scripts', 'mundana_scripts');


//-----------------------------------------------------
// Do shortcode in widgets
//-----------------------------------------------------
add_filter('widget_text', 'do_shortcode');

//----------------------------------------------------
// Register Widgets
//-----------------------------------------------------
if (!function_exists('mundana_sidebar_widgets_init')) :
function _widgets_init()
{
register_sidebar(array(
		'name'          => __('WooCommerce Sidebar', 'mundana'),
		'id'            => 'sidebar-woocommerce',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title h6 text-uppercase mb-3"><span>',
		'after_title'   => '</span></h4>',
));
register_sidebar(array(
		'name'          => __('Article Sidebar', 'mundana'),
		'id'            => 'sidebar-posts',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="font-weight-bold spanborder"><span>',
		'after_title'   => '</span></h5>',
));
register_sidebar(array(
		'name'          => __('Index Sidebar', 'mundana'),
		'id'            => 'sidebar-home',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="font-weight-bold spanborder"><span>',
		'after_title'   => '</span></h5>',
));
register_sidebar(array(
		'name'          => __('Before Article', 'mundana'),
		'id'            => 'sidebar-before-post',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
));
register_sidebar(array(
		'name'          => __('After Article', 'mundana'),
		'id'            => 'sidebar-after-post',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
));
}
endif; // _widgets_init
add_action('widgets_init', '_widgets_init');

//-----------------------------------------------------
// Excerpt
//-----------------------------------------------------
function excerpt($limit)
{
$excerpt = explode(' ', get_the_excerpt(), $limit);
if (count($excerpt) >= $limit) {
array_pop($excerpt);
$excerpt = implode(" ", $excerpt) . '...';
} else {
$excerpt = implode(" ", $excerpt);
}
$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
return $excerpt;
}

function content($limit)
{
$content = explode(' ', get_the_content(), $limit);
if (count($content) >= $limit) {
array_pop($content);
$content = implode(" ", $content) . '...';
} else {
$content = implode(" ", $content);
}
$content = preg_replace('/\[.+\]/', '', $content);
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
return $content;
}

//-----------------------------------------------------
// Reading Time
//-----------------------------------------------------
function mundana_estimated_reading_time()
{
$post = get_post();
$words = str_word_count(strip_tags($post->post_content));
$minutes = floor($words / 280);
$seconds = floor($words % 280 / (280 / 60));

if (1 <= $minutes) {
$estimated_time = $minutes . ' ' . esc_attr__('min read', 'mundana');
} else {
$estimated_time = $seconds . ' ' . esc_attr__('sec read', 'mundana');
}
return $estimated_time;
}


//-----------------------------------------------------
// Share
//-----------------------------------------------------
if (!function_exists('mundana_share_post')) {
function mundana_share_post()
{
global $post;
$shareURL = urlencode(get_permalink());
$shareTitle = str_replace(' ', '%20', get_the_title());
$shareThumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
$twitterURL = 'https://twitter.com/intent/tweet?text=' . $shareTitle . '&amp;url=' . $shareURL;
$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u=' . $shareURL;
$pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $shareURL . '&amp;media=' . $shareThumbnail[0] . '&amp;description=' . $shareTitle;
$linkedinURL = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $shareURL . '&amp;title=' . $shareTitle;
$disablesharetwitter = get_theme_mod('disable_share_twitter');
$disablesharefb = get_theme_mod('disable_share_fb');
$disablesharepinterest = get_theme_mod('disable_share_pinterest');
$disablesharelinkedin = get_theme_mod('disable_share_linkedin');

echo '
<ul class="shareitnow">';
if ($disablesharetwitter == 0) {
		echo
				'<li>
<a target="_blank" href="' . $twitterURL . '">
<i class="fa fa-twitter"></i>
</a>
</li>';
}

if ($disablesharefb == 0) {
		echo
				'<li>
<a target="_blank" href="' . $facebookURL . '">        
<i class="fa fa-facebook"></i>
</a>
</li>';
}

if ($disablesharepinterest == 0) {
		echo
				'<li>
<a target="_blank" href="' . $pinterestURL . '">
<i class="fa fa-pinterest"></i>
</a>
</li>';
}

if ($disablesharelinkedin == 0) {
		echo
				'<li>
<a target="_blank" href="' . $linkedinURL . '">
<i class="fa fa-linkedin"></i>
</a>
</li>';
}

echo '</ul>';
}
}

//-----------------------------------------------------
// Hide applause button plugin, it's already in theme
//-----------------------------------------------------
add_filter('wpli/autoadd', function () {
return false;
});


//-----------------------------------------------------
// Menu Search
//-----------------------------------------------------
function mundana_nav_search($items, $args)
{
// If this isn't the primary menu, do nothing
if (!($args->theme_location == 'extramenu') || (false == get_theme_mod('header_search', true)))
return $items;

// Otherwise, add search form
return '<li class="menu-item search align-self-center"><form action="' . home_url('/') . '" class="search-form" autocomplete="off">
				<div class="form-group has-feedback">
						<input type="hidden" name="post_type" value="post" />
						<input type="text" class="form-control" name="s" placeholder="Type and hit enter...">
						<i class="fa fa-search form-control-feedback"></i>
				</div>
		</form></li>' . $items;
}
add_filter('wp_nav_menu_items', 'mundana_nav_search', 10, 2);


//-----------------------------------------------------
// Justify main menu if ON
//-----------------------------------------------------
function modify_nav_menu_args($args)
{
if ('headermenu' == $args['theme_location']) {
		if (true == get_theme_mod('justify_menu', true)) {
				$args['menu_class'] = 'navbar-nav w-100 d-flex align-items-center justify-content-between';
		}
}
return $args;
}
add_filter('wp_nav_menu_args', 'modify_nav_menu_args');

//-----------------------------------------------------
// Comment Form
//-----------------------------------------------------
function my_update_comment_fields($fields)
{
$commenter = wp_get_current_commenter();
$req       = get_option('require_name_email');
$label     = $req ? '*' : ' ' . __('(optional)', 'mundana');
$aria_req  = $req ? "aria-required='true'" : '';
$fields['author'] =
'<div class="row"><p class="comment-form-author col-md-4">

<input id="author" name="author" type="text" placeholder="' . esc_attr__("Name", "mundana") . '" value="' . esc_attr($commenter['comment_author']) .
'" size="30" ' . $aria_req . ' />
</p>';
$fields['email'] =
'<p class="comment-form-email col-md-4">

<input id="email" name="email" type="email" placeholder="' . esc_attr__("E-mail address", "mundana") . '" value="' . esc_attr($commenter['comment_author_email']) .
'" size="30" ' . $aria_req . ' />
</p>';
$fields['url'] =
'<p class="comment-form-url col-md-4">

<input id="url" name="url" type="url"  placeholder="' . esc_attr__("Website Link", "mundana") . '" value="' . esc_attr($commenter['comment_author_url']) .
'" size="30" />
</p></div>';
return $fields;
}
add_filter('comment_form_default_fields', 'my_update_comment_fields');

function my_update_comment_field($comment_field)
{
$comment_field =
'<p class="comment-form-comment">            
		<textarea required id="comment" name="comment" placeholder="' . esc_attr__("Write a response...", "mundana") . '" cols="45" rows="8" aria-required="true"></textarea>
</p>';
return $comment_field;
}
add_filter('comment_form_field_comment', 'my_update_comment_field');

//-----------------------------------------------------
// shortcode for logged out users
//-----------------------------------------------------
function visitor_access($attr, $content = null)
{
extract(shortcode_atts(array(
'deny' => '',
), $attr));
if ((!is_user_logged_in() && !is_null($content)) || is_feed()) return $content;
return $deny;
}
add_shortcode('visitor_access', 'visitor_access');


//-----------------------------------------------------
// tooltip date
//-----------------------------------------------------
function mundana_tooltip_date() {
    $disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
    if ($disabledatecard == 0) { ?>
    <svg style="fill: rgba(0,0,0,0.45); margin-left: 3px; margin-top: -2px; display: inline-block;" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if (get_the_modified_time('U') > get_the_time('U')) {	echo __('Updated ', 'mundana') . get_the_modified_time('M j, Y'); } else {	echo get_the_date('M j, Y');} ?>">>
        <path d="M12 .288l2.833 8.718h9.167l-7.417 5.389 2.833 8.718-7.416-5.388-7.417 5.388 2.833-8.718-7.416-5.389h9.167z" /></svg>
    <?php 
    }
}


//-----------------------------------------------------
// postbox
//-----------------------------------------------------
function mundana_postbox()
{

global $post;
$disableauthorcard = get_theme_mod('disable_authorbox_sectionarticles_card');
$disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
$disablereadingtimecard = get_theme_mod('disable_readingtime_sectionarticles_card');
?>

<div class="mb-5 row d-lg-flex justify-content-between postbox" id="post-<?php echo the_ID(); ?>">
    <div class="col-7 col-lg-8">

        <h2 class="mb-2">
            <a class="text-dark" href="<?php echo get_permalink(); ?>">
                <?php echo get_the_title(); ?></a>
        </h2>

        <p class="excerpt">
            <?php echo excerpt(20); ?>
        </p>

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <div class="card-text text-muted small">
                    <?php if ($disableauthorcard == 0) { ?> <a class="text-muted text-capitalize" href="<?php echo get_author_posts_url($post->post_author); ?>">
                        <?php echo get_the_author_meta('display_name'); ?></a>
                    <?php } ?>
                    <?php _e('in', 'mundana'); ?>
                    <span class="thecatlinks">
                        <?php the_category(', '); ?></span>
                </div>

                <div class="text-muted small">
                    <?php if ($disabledatecard == 0) { ?>
                    <?php echo get_the_date('M j'); ?> ·
                    <?php } ?>
                    <?php if ($disablereadingtimecard == 0) { ?>
                    <?php echo mundana_estimated_reading_time(); ?>
                    <?php } ?>
                    <?php if ($disabledatecard == 0) { ?>
                    <?php echo mundana_tooltip_date(); ?>
                    <?php } ?>
                </div>
            </div>

            <div>
                <?php if (is_plugin_active('favorites/favorites.php')) { echo get_favorites_button(); } ?>
            </div>

        </div>

    </div>


    <?php if (has_post_thumbnail()) { ?>
    <div class="col-5 col-lg-4 mt-4 mt-lg-0 text-lg-right"><a href="<?php echo get_permalink(); ?>">
            <?php the_post_thumbnail('thumbnail'); ?></a></div>
    <?php 
} ?>

</div>

<?php 
}

//-----------------------------------------------------
// postbox_style2
//-----------------------------------------------------
function mundana_postbox_style2()
{
global $post;
$disableauthorcard = get_theme_mod('disable_authorbox_sectionarticles_card');
$disablereadingtimecard = get_theme_mod('disable_readingtime_sectionarticles_card');
$disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
?>
<div class="card border-0 postbox_style2">
    <a href="<?php echo get_permalink(); ?>">
        <?php the_post_thumbnail('postbox-style2'); ?></a>
    <div class="card-body pl-0 pr-0 pb-0">
        <h2 class="h4">
            <a class="text-dark" href="<?php echo get_permalink(); ?>">
                <?php echo the_title(); ?></a>
        </h2>
        <a href="<?php echo get_permalink(); ?>" class="text-muted">
            <p>
                <?php echo excerpt(20); ?>
            </p>
        </a>
        <div class="d-flex align-items-center">
            <small class="text-muted">
                <?php if ($disableauthorcard == 0) { ?>
                <a class="text-capitalize text-muted" href="<?php echo get_author_posts_url($post->post_author); ?>">
                    <?php echo get_the_author_meta('display_name'); ?></a>
                <?php 
		} ?>
                <?php _e(' in ', 'mundana'); ?>
                <span class="thecatlinks text-dark">
                    <?php the_category(', '); ?></span>
                <span class="text-muted d-block">
                    <?php if ($disabledatecard == 0) { ?>
                    <span class="post-date">
                        <time class="post-date">
                            <?php echo get_the_date('M j'); ?>
                        </time></span>
                    <?php 
				} ?>
                    <?php if ($disablereadingtimecard == 0) { ?>
                    &middot;
                    <span class="readingtime">
                        <?php echo mundana_estimated_reading_time() ?></span>
                    <?php 
				} ?>
                    <?php if ($disabledatecard == 0) { ?>
                    <?php echo mundana_tooltip_date(); ?>
                    <?php 
				} ?>
                </span>
            </small>
        </div>
    </div>
</div>
<?php 
}


//-----------------------------------------------------
// postbox_style2_right
//-----------------------------------------------------
function mundana_postbox_style2_right()
{
global $post;
$disableauthorcard = get_theme_mod('disable_authorbox_sectionarticles_card');
$disablereadingtimecard = get_theme_mod('disable_readingtime_sectionarticles_card');
$disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
?>
<div class="mt-3 mt-md-0 card border-0 mb-4 postbox_style2_right">
    <a href="<?php echo get_permalink(); ?>">
        <?php the_post_thumbnail('postbox-style2-right'); ?></a>
    <div class="card-body pl-0 pr-0 pb-0">
        <h2 class="h4">
            <a class="text-dark" href="<?php echo get_permalink(); ?>">
                <?php echo the_title(); ?></a>
        </h2>
        <a href="<?php echo get_permalink(); ?>" class="text-muted">
            <p class="d-none">
                <?php echo excerpt(10); ?>
            </p>
        </a>
        <div class="d-flex align-items-center">
            <small class="text-muted">
                <?php if ($disableauthorcard == 0) { ?>
                <a class="text-capitalize text-muted" href="<?php echo get_author_posts_url($post->post_author); ?>">
                    <?php echo get_the_author_meta('display_name'); ?></a>
                <?php 
		} ?>
                <?php _e(' in ', 'mundana'); ?>
                <span class="thecatlinks text-dark">
                    <?php the_category(', '); ?></span>
                <span class="text-muted d-block">
                    <?php if ($disabledatecard == 0) { ?>
                    <span class="post-date">
                        <time class="post-date">
                            <?php echo get_the_date('M j'); ?>
                        </time></span>
                    <?php 
				} ?>
                    <?php if ($disablereadingtimecard == 0) { ?>
                    &middot;
                    <span class="readingtime">
                        <?php echo mundana_estimated_reading_time() ?></span>
                    <?php 
				} ?>
                    <?php if ($disabledatecard == 0) { ?>
                    <?php echo mundana_tooltip_date(); ?>
                    <?php 
				} ?>
                </span>
            </small>
        </div>
    </div>
</div>
<?php 
}

//-----------------------------------------------------
// postbox_style3
//-----------------------------------------------------
function mundana_postbox_style3()
{
global $post;
$disableauthorcard = get_theme_mod('disable_authorbox_sectionarticles_card');
$disablereadingtimecard = get_theme_mod('disable_readingtime_sectionarticles_card');
$disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
?>
<div class="mt-3 mt-md-0 mb-3 d-flex post_box_style3">
    <div class="col-4 col-md-4 pl-0">
        <a href="<?php echo get_permalink(); ?>">
            <?php if (has_post_thumbnail()) { ?>
            <?php the_post_thumbnail('postbox-style3'); ?>
            <?php 
} ?>
        </a>
    </div>
    <div>
        <h2 class="mb-2 h6">
            <a class="text-dark" href="<?php echo get_permalink(); ?>">
                <?php the_title(); ?></a>
        </h2>
        <div>
            <small class="d-block text-muted">
                <?php if ($disableauthorcard == 0) { ?><a class="text-muted text-capitalize" href="<?php echo get_author_posts_url($post->post_author); ?>">
                    <?php the_author_meta('display_name'); ?></a>
                <?php 
																																																																																																																} ?>
                <?php _e(' in ', 'mundana'); ?>
                <span class="thecatlinks text-dark">
                    <?php the_category(', '); ?></span>
            </small>
            <small class="text-muted">
                <?php if ($disabledatecard == 0) { ?>
                <?php echo get_the_date('M j'); ?> ·
                <?php 
																																								} ?>
                <?php if ($disablereadingtimecard == 0) { ?>
                <?php echo mundana_estimated_reading_time(); ?>
                <?php 
		} ?>
                <?php echo mundana_tooltip_date(); ?>
            </small>
        </div>
    </div>
</div>

<?php 
}


//-----------------------------------------------------
// postbox_style4
//-----------------------------------------------------
function mundana_postbox_style4()
{
global $post;
$disableauthorcard = get_theme_mod('disable_authorbox_sectionarticles_card');
$disablereadingtimecard = get_theme_mod('disable_readingtime_sectionarticles_card');
$disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
?>
<div class="card border-0 mb-4">
    <a href="<?php echo get_permalink(); ?>">
        <?php the_post_thumbnail('postbox-style4', array('class' => 'w-100')); ?></a>
    <div class="card-body pl-0 pr-0">
        <h2 class="h3">
            <a class="text-dark" href="<?php echo get_permalink(); ?>">
                <?php echo the_title(); ?></a>
        </h2>
        <a href="<?php echo get_permalink(); ?>" class="text-muted">
            <p>
                <?php echo excerpt(30); ?>
            </p>
        </a>
        <div class="d-flex align-items-center">
            <?php if ($disableauthorcard == 0) { ?>
            <a class="mr-2" href="<?php echo get_author_posts_url($post->post_author); ?>">
                <?php echo get_avatar(get_the_author_meta('user_email'), '50', null, null, array('class' => array('rounded-circle imgavt'))); ?>
            </a>
            <?php 
} ?>
            <small>
                <?php if ($disableauthorcard == 0) { ?>
                <a class="text-muted text-capitalize" href="<?php echo get_author_posts_url($post->post_author); ?>">
                    <?php echo get_the_author_meta('display_name'); ?></a>
                <?php 
		} ?>
                <span class="text-muted">
                    <?php _e(' in ', 'mundana'); ?></span>
                <span class="thecatlinks text-dark">
                    <?php the_category(', '); ?></span>
                <span class="text-muted d-block">
                    <?php if ($disabledatecard == 0) { ?>
                    <span class="post-date">
                        <time class="post-date">
                            <?php echo get_the_date('M j'); ?>
                        </time></span>
                    <?php 
				} ?>
                    <?php if ($disablereadingtimecard == 0) { ?>
                    &middot;
                    <span class="readingtime">
                        <?php echo mundana_estimated_reading_time() ?></span>
                    <?php 
				} ?>
                    <?php if ($disabledatecard == 0) { ?>
                    <?php echo mundana_tooltip_date(); ?>
                    <?php 
				} ?>
                </span>
            </small>
        </div>
        <br />
        <span class="read_more">
            <a href="<?php echo get_permalink(); ?>">Read more</a>
        </span>
    </div>
</div>
<?php 
}


//-----------------------------------------------------
// sticky
//-----------------------------------------------------
function mundana_sticky()
{
global $post;
$bgurl = wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'postbox-sticky'));
?>
<div class="introjumbo rounded-0 mb-5 p-0 position-relative post-sticky">
    <div class="justify-content-between d-md-flex flex-md-row-reverse">        
        <div class="col-md-6 p-0 text-right">
            <a href="<?php echo get_permalink(); ?>">
                <img class="imgfullcover onhoverup text-right" alt=" <?php echo the_title(); ?>" src="<?php echo $bgurl; ?>">
            </a>
        </div>
        <div class="col-md-6 pl-0 pt-4rem pb-4rem pr-md-5 align-self-center">
            <a href="<?php echo get_permalink(); ?>" class="d-inline-block mb-2 catbadge"><?php _e( 'featured', 'mundana' ); ?></a>           
                <h1 class="mb-3">
                    <a class="text-dark" href="<?php echo get_permalink(); ?>">
                        <?php echo the_title(); ?>
                    </a>
                </h1>
            
            <p class="mb-4 lead">
                <?php echo excerpt(22); ?>
            </p>
            <a href="<?php echo get_permalink(); ?>" class="btn btn-dark mt-1">
                <?php _e('Read more', 'mundana'); ?></a>
        </div>
    </div>
</div>
<?php 
}


//-----------------------------------------------------
// featured post
//-----------------------------------------------------

function mundana_featured()
{
    global $post;
    $disableauthorcard = get_theme_mod('disable_authorbox_sectionarticles_card');
    $disablereadingtimecard = get_theme_mod('disable_readingtime_sectionarticles_card');
    $disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
    ?>
    <div class="card border-0 mb-4">
        <a href="<?php echo get_permalink(); ?>">
            <?php the_post_thumbnail('postbox-style4', array('class' => 'w-100')); ?></a>
        <div class="card-body pl-0 pr-0 ct-card">
            <span class="post-date">
                <time class="post-date text-dark">
                    <?php echo get_the_date('M j, Y'); ?>
                </time>
            </span>
            <h2 class="h3">
                <a class="text-dark" href="<?php echo get_permalink(); ?>">
                    <?php echo the_title(); ?></a>
            </h2>
            <a href="<?php echo get_permalink(); ?>" class="text-muted">
                <p>
                    <?php echo excerpt(70); ?>
                </p>
            </a>
            <div class="d-flex align-items-center">
                <?php if ($disableauthorcard == 0) { ?>
                <a class="mr-2" href="<?php echo get_author_posts_url($post->post_author); ?>">
                    <?php echo get_avatar(get_the_author_meta('user_email'), '50', null, null, array('class' => array('rounded-circle imgavt'))); ?>
                </a>
                <?php 
    } ?>
                <small>
                    <?php if ($disableauthorcard == 0) { ?>
                    <a class="text-muted text-capitalize" href="<?php echo get_author_posts_url($post->post_author); ?>">
                        <?php echo get_the_author_meta('display_name'); ?></a>
                    <?php 
            } ?>
                    <span class="text-muted">
                        <?php _e(' in ', 'mundana'); ?></span>
                    <span class="thecatlinks text-dark">
                        <?php the_category(', '); ?></span>
                    <span class="text-muted d-block">
                        <?php 
                        // if ($disabledatecard == 0) { 
                            ?>
                        <!-- <span class="post-date">
                            <time class="post-date"> -->
                                <?php 
                                    // echo get_the_date('M j'); 
                                ?>
                            <!-- </time></span> -->
                        <?php 
                    // } ?>
                        <?php if ($disablereadingtimecard == 0) { ?>
                        <!-- &middot; -->
                        <span class="readingtime">
                            <?php echo mundana_estimated_reading_time() ?></span>
                        <?php 
                    } ?>
                        <?php if ($disabledatecard == 0) { ?>
                        <?php echo mundana_tooltip_date(); ?>
                        <?php 
                    } ?>
                    </span>
                </small>
            </div>
        </div>
    </div>
    <?php 
}

//-----------------------------------------------------
// related_postbox
//-----------------------------------------------------
function mundana_related_postbox()
{
global $post;
$disableauthorcard = get_theme_mod('disable_authorbox_sectionarticles_card');
$disablereadingtimecard = get_theme_mod('disable_readingtime_sectionarticles_card');
$disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
$fall_image_url = get_theme_mod('fallback_image');
$fall_image_id = attachment_url_to_postid($fall_image_url);
?>

<div class="card border-0 cardwithshadow minh100 onhoverup">

    <?php if (has_post_thumbnail()) {
$image_data =  the_post_thumbnail(
		'postbox-related',
		array('class' => 'w-100 card-img-top')
);
} else {
if ($fall_image_url) {
				$image_data = wp_get_attachment_image(
						$fall_image_id,
						array(350, 150),
						array('class' => 'w-100 card-img-top')
				);
		}
}
?>
    <?php if (!empty($image_data)) {
echo $image_data;
} ?>

    <div class="card-body">
        <h2 class="h5">
            <a class="text-dark" href="<?php echo get_permalink(); ?>">
                <?php echo the_title(); ?></a>
        </h2>
        <div class="metafooter small mt-auto">
            <span class="author-meta">
                <?php if ($disableauthorcard == 0) { ?>
                <span class="post-name">
                    <a class="text-muted text-capitalize" href="<?php echo get_author_posts_url($post->post_author); ?> ">
                        <?php echo get_the_author_meta('display_name'); ?> </a>
                </span>
                <?php 
		} ?> <span class="text-muted">
                    <?php _e(' in ', 'mundana'); ?></span>
                <span class="thecatlinks text-dark">
                    <?php the_category(', '); ?></span>
                <div>
                    <?php if ($disabledatecard == 0) { ?>
                    <span class="post-date text-muted">
                        <?php echo get_the_date('M j, Y'); ?></span>
                    &nbsp; &middot; &nbsp;
                    <?php 
				} ?>
                    <?php if ($disablereadingtimecard == 0) { ?>
                    <span class="post-read readingtime text-muted">
                        <?php echo mundana_estimated_reading_time(); ?></span>
                    <?php 
				} ?>
                </div>
            </span>
        </div>
    </div>
</div>
<?php 
}


//-----------------------------------------------------
// Related Posts
//-----------------------------------------------------
function mundana_related_posts($args = array())
{
global $post;

// default args
$args = wp_parse_args($args, array(
'post_id' => !empty($post) ? $post->ID : '',
'taxonomy' => 'category',
'limit' => 3,
'post_type' => !empty($post) ? $post->post_type : 'post',
'orderby' => 'date',
'order' => 'DESC'
));

// check taxonomy
if (!taxonomy_exists($args['taxonomy'])) {
return;
}

// post taxonomies
$taxonomies = wp_get_post_terms($args['post_id'], $args['taxonomy'], array('fields' => 'ids'));

if (empty($taxonomies)) {
return;
}

// query
$related_posts = get_posts(array(
'post__not_in' => (array)$args['post_id'],
'post_type' => $args['post_type'],
'limit' => 3,
'tax_query' => array(
		array(
				'taxonomy' => $args['taxonomy'],
				'field' => 'term_id',
				'terms' => $taxonomies
		),
),
'posts_per_page' => $args['limit'],
'orderby' => $args['orderby'],
'order' => $args['order']
));
if (!empty($related_posts)) {  ?>
<div class="row justify-content-center h-100 listrecent listrelated mb-4">
    <?php
foreach ($related_posts as $post) {
setup_postdata($post);
{ ?>
    <div class="col-sm-6 mb-4 mb-md-0 col-md-4">
        <?php echo mundana_related_postbox(); ?>
    </div>
    <?php 
}
} ?>
</div>
<div class="clearfix"></div>
<?php 
}

wp_reset_postdata();
}

//-----------------------------------------------------
// claps
//-----------------------------------------------------
function mundana_claps()
{
global $post;
$disableauthorcard = get_theme_mod('disable_authorbox_sectionarticles_card');
$disablereadingtimecard = get_theme_mod('disable_readingtime_sectionarticles_card');
$disabledatecard = get_theme_mod('disable_date_sectionarticles_card');
if (class_exists('WPClapsApplause')) { ?>
<div class="sticky-top sticky-sidebar-offset mundana_claps_popular">
    <h4 class="spanborder h4"><span>
    <?php _e('Popular', 'mundana'); ?></span></h4>
    <ol class="list-featured">
        <?php $args = array(
		'post_type' => 'post',
		'post_status'    => 'publish',
		'numberposts' => 5,
		'meta_key' => '_pt_claps',
		'orderby' => 'meta_value_num',
		'order' => 'DESC'
);
$most_loved = get_posts($args);
foreach ($most_loved as $loved) :
		$categories = get_the_category($loved); ?>
        <li class="loved-item mb-4">
            <span>
                <h6>
                    <a class="text-dark" href="<?php echo get_permalink($loved->ID); ?>">
                        <?php echo get_the_title($loved->ID); ?></a>
                </h6>
                <div class="text-muted">
                    <?php if ($disableauthorcard == 0) { ?><a class="text-muted text-capitalize" href="<?php echo get_author_posts_url($loved->post_author); ?>">
                        <?php echo get_the_author_meta('display_name'); ?></a>
                    <?php } ?>
                    <?php _e('in', 'mundana'); ?>
                    <?php if (!empty($categories)) {
						echo '<a class="text-capitalize" href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
							} ?>
                    <?php if ($disabledatecard == 0) { ?> ·
                    <?php echo get_the_date('M j', $loved->ID); ?>
                    <?php } ?>
                    <?php if ($disabledatecard == 0) { ?>
                    <svg style="fill: rgba(0,0,0,0.45); margin-left: 3px; display:inline-black; margin-top: -2px;" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if (get_the_modified_time('U', $loved->ID) > get_the_time('U', $loved->ID)) {echo __('Updated ', 'mundana') . get_the_modified_time('M j, Y', $loved->ID);} else {echo get_the_date('M j, Y', $loved->ID);}?>">>
                        <path d="M12 .288l2.833 8.718h9.167l-7.417 5.389 2.833 8.718-7.416-5.388-7.417 5.388 2.833-8.718-7.416-5.389h9.167z" /></svg>
                    <?php 
				}  ?>
                </div>
            </span>
        </li>
        <?php endforeach;
}
?>
    </ol>
</div>
<?php 
}

//-----------------------------------------------------
// Return an alternate title, without prefix, for every type used in the get_the_archive_title().
//-----------------------------------------------------
function mundana_archive_title()
{
if (is_category()) {
$title = single_cat_title('', false);
} elseif (is_tag()) {
$title = single_tag_title('', false);
} elseif (is_author()) {
$title = '<span class="vcard">' . get_the_author() . '</span>';
} elseif (is_year()) {
$title = get_the_date('Y', 'yearly archives date format');
} elseif (is_month()) {
$title = get_the_date('F Y', 'monthly archives date format');
} elseif (is_day()) {
$title = get_the_date('F j, Y', 'daily archives date format');
} elseif (is_post_type_archive()) {
$title = post_type_archive_title('', false);
} elseif (is_tax()) {
$title = single_term_title('', false);
} else {
$title = 'Posts';
}
return $title;
}
add_filter('get_the_archive_title', 'mundana_archive_title');


//-----------------------------------------------------
// Add social fields to user profile
//-----------------------------------------------------
if (!function_exists('mundana_user_fields')) :

function mundana_user_fields($contactmethods)
{
$contactmethods['twitter'] = 'Twitter';
$contactmethods['facebook'] = 'Facebook';
$contactmethods['youtube'] = 'YouTube';
$contactmethods['location'] = 'Location';
$contactmethods['sidebarimageprofile'] = 'Sidebar Image Profile URL';

return $contactmethods;
}
add_filter('user_contactmethods', 'mundana_user_fields', 10, 1);

endif;

//-----------------------------------------------------
// Add textarea about author
//-----------------------------------------------------
add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');
function extra_user_profile_fields($user)
{ ?>
<li class="wpuf-el post_title">
    <div class="wpuf-label">
        <label for="authorabout">
            <?php _e("About me", "mundana"); ?></label>
    </div>
    <div class="wpuf-fields">
        <textarea name="authorabout" id="authorabout" rows="10" cols="100" class="w-100"><?php echo esc_attr(get_the_author_meta('authorabout', $user->ID)); ?></textarea>
    </div>
</li>
<?php 
}

add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');
function save_extra_user_profile_fields($user_id)
{
if (!current_user_can('edit_user', $user_id)) {
return false;
}
update_user_meta($user_id, 'authorabout', $_POST['authorabout']);
}

//-----------------------------------------------------
// Hide Featured Image from post
//-----------------------------------------------------

function hide_featured_image_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function hide_featured_image_add_meta_box() {
	add_meta_box(
		'hide_featured_image-hide-featured-image',
		__( 'Hide Featured Image', 'mundana' ),
		'hide_featured_image_html',
		'post',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'hide_featured_image_add_meta_box' );

function hide_featured_image_html( $post) {
	wp_nonce_field( '_hide_featured_image_nonce', 'hide_featured_image_nonce' ); ?>
	<p>
		<input type="checkbox" name="hide_featured_image_hide_featured_image_on_post" id="hide_featured_image_hide_featured_image_on_post" value="hide-featured-image-on-post" <?php echo ( hide_featured_image_get_meta( 'hide_featured_image_hide_featured_image_on_post' ) === 'hide-featured-image-on-post' ) ? 'checked' : ''; ?>>
		<label for="hide_featured_image_hide_featured_image_on_post"><?php _e( 'Hide featured image on post', 'mundana' ); ?></label>	
    </p>
<?php }

function hide_featured_image_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['hide_featured_image_nonce'] ) || ! wp_verify_nonce( $_POST['hide_featured_image_nonce'], '_hide_featured_image_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['hide_featured_image_hide_featured_image_on_post'] ) )
		update_post_meta( $post_id, 'hide_featured_image_hide_featured_image_on_post', esc_attr( $_POST['hide_featured_image_hide_featured_image_on_post'] ) );
	else
		update_post_meta( $post_id, 'hide_featured_image_hide_featured_image_on_post', null );
}
add_action( 'save_post', 'hide_featured_image_save' );

/*
	Usage: hide_featured_image_get_meta( 'hide_featured_image_hide_featured_image_on_post' )
*/


//-----------------------------------------------------
// Tall Featured Image from post
//-----------------------------------------------------

function tall_featured_image_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function tall_featured_image_add_meta_box() {
	add_meta_box(
		'tall_featured_image-tall-featured-image',
		__( 'Tall featured image', 'mundana' ),
		'tall_featured_image_html',
		'post',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'tall_featured_image_add_meta_box' );

function tall_featured_image_html( $post) {
	wp_nonce_field( '_tall_featured_image_nonce', 'tall_featured_image_nonce' ); ?>

	<p>

		<input type="checkbox" name="tall_featured_image_tall_featured_image_on_post" id="tall_featured_image_tall_featured_image_on_post" value="tall-featured-image-on-post" <?php echo ( tall_featured_image_get_meta( 'tall_featured_image_tall_featured_image_on_post' ) === 'tall-featured-image-on-post' ) ? 'checked' : ''; ?>>
		<label for="tall_featured_image_tall_featured_image_on_post"><?php _e( 'Tall featured image', 'mundana' ); ?></label>	</p><?php
}

function tall_featured_image_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['tall_featured_image_nonce'] ) || ! wp_verify_nonce( $_POST['tall_featured_image_nonce'], '_tall_featured_image_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['tall_featured_image_tall_featured_image_on_post'] ) )
		update_post_meta( $post_id, 'tall_featured_image_tall_featured_image_on_post', esc_attr( $_POST['tall_featured_image_tall_featured_image_on_post'] ) );
	else
		update_post_meta( $post_id, 'tall_featured_image_tall_featured_image_on_post', null );
}
add_action( 'save_post', 'tall_featured_image_save' );

/*
	Usage: tall_featured_image_get_meta( 'tall_featured_image_tall_featured_image_on_post' )
*/	



//-----------------------------------------------------
// Full Width Featured Image
//-----------------------------------------------------	
function full_width_featured_image_get_meta($value) {
    global $post;
    $field = get_post_meta($post->ID, $value, true);
    if (!empty($field)) {
        return is_array($field) ? stripslashes_deep($field) : stripslashes(wp_kses_decode_entities($field));
    } else {
        return false;
    }
}																															function full_width_featured_image_add_meta_box() {	
    add_meta_box( 
        'full_width_featured_image-tall-featured-image',
        __('Full width featured image', 'mundana'),	
        'full_width_featured_image_html',
        'post',	
        'side',	
        'default'
    );	
}	
add_action('add_meta_boxes', 'full_width_featured_image_add_meta_box');	
function full_width_featured_image_html($post)	{
    wp_nonce_field('_full_width_featured_image_nonce', 'full_width_featured_image_nonce'); ?>

<p>
<input type="checkbox" name="full_width_featured_image_full_width_featured_image_on_post" id="full_width_featured_image_full_width_featured_image_on_post" value="tall-featured-image-on-post" <?php echo (full_width_featured_image_get_meta('full_width_featured_image_full_width_featured_image_on_post')==='tall-featured-image-on-post' ) ? 'checked' : '' ; ?>>
<label for="full_width_featured_image_full_width_featured_image_on_post">
<?php _e('Full width featured image', 'mundana'); ?></label> 
</p>
<?php
}
function full_width_featured_image_save($post_id) {	
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['full_width_featured_image_nonce']) || !wp_verify_nonce($_POST['full_width_featured_image_nonce'], '_full_width_featured_image_nonce')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['full_width_featured_image_full_width_featured_image_on_post']))
        update_post_meta($post_id, 'full_width_featured_image_full_width_featured_image_on_post', esc_attr($_POST['full_width_featured_image_full_width_featured_image_on_post']));
    else
        update_post_meta($post_id, 'full_width_featured_image_full_width_featured_image_on_post', null);
}
add_action('save_post', 'full_width_featured_image_save');	
/*
Usage: full_width_featured_image_get_meta( 'full_width_featured_image_full_width_featured_image_on_post' )
*/

//-----------------------------------------------------
// Schema.org 
//-----------------------------------------------------
function html_schema()
{
$schema = 'http://schema.org/';																																	// Is single post
if (is_single()) { ?>
<?php
global $post;
global $post_id;
$author_id = $post->post_author;
$fb_url   = get_theme_mod('fb_url');
$twitter_url  = get_theme_mod('twitter_url');
$youtube_url  = get_theme_mod('youtube_url');
$pinterest_url  = get_theme_mod('pinterest_url');
$linkedin_url  = get_theme_mod('linkedin_url');
$fall_image_url = get_theme_mod('fallback_image');
$fall_image_id = attachment_url_to_postid($fall_image_url);
?>

<?php if (has_post_thumbnail($post->ID)) {

$image_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "thumbnail");
$image_width = $image_data[1];
$image_height = $image_data[2];
} else {

if ($fall_image_id) {
		$image_data = wp_get_attachment_image($fall_image_id, 'thumbnail');
		$image_width = 150;
		$image_height = 150;
}
} ?>

<script type='application/ld+json'>
    {
        "@context": "http://schema.org",
        "@type": "Article",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?php the_permalink(); ?>"
        },
        "headline": "<?php echo get_the_title($post_id); ?>",
        "description": "<?php echo get_the_excerpt(); ?>",
        "datePublished": "<?php echo get_the_date(); ?>",
        "dateModified": "<?php the_modified_date(); ?>",
        "image": {
            "@type": "ImageObject",

            <?php 
		if (has_post_thumbnail($post->ID)) { ?>
            "url": "<?php the_post_thumbnail_url(); ?>",
            <?php 
} else { ?>
            "url": "<?php echo $fall_image_url; ?>",
            <?php 
} ?>

            "height": <?php echo $image_height; ?>,
            "width": <?php echo $image_width; ?>
        },
        "publisher": {
            "@type": "Organization",
            "name": "<?php bloginfo('name'); ?>",
            "logo": {
                "@type": "ImageObject",
                "url": "<?php echo get_site_icon_url(); ?>",
                "height": 60,
                "width": 60
            }
        },
        "author": {
            "@type": "Person",
            "name": "<?php the_author_meta('display_name', $author_id); ?>",
            "sameAs": [
                <?php if (!empty($fb_url)) { ?>
                "<?php echo $fb_url; ?>", <?php 
																																} ?>
                <?php if (!empty($twitter_url)) { ?>
                "<?php echo $twitter_url; ?>", <?php 
																																				} ?>
                <?php if (!empty($youtube_url)) { ?>
                "<?php echo $youtube_url; ?>", <?php 
																																				} ?>
                <?php if (!empty($pinterest_url)) { ?>
                "<?php echo $pinterest_url; ?>", <?php 
																																						} ?>
                <?php if (!empty($linkedin_url)) { ?>
                "<?php echo $linkedin_url; ?>"
                <?php 
		} ?>
            ]
        }
    }
</script>
<?php 
} else { ?>
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebPage",
        "name": "<?php bloginfo('name'); ?>",
        "url": "<?php echo get_home_url(); ?>",
        "description": "<?php bloginfo('description'); ?>",
        "publisher": {
            "@type": "Organization",
            "name": "<?php bloginfo('name'); ?>"
        }
    }
</script>

<?php 
}
}

//-----------------------------------------------------
// User Front End
//-----------------------------------------------------
if (!function_exists('is_plugin_active'))
require_once(ABSPATH . '/wp-admin/includes/plugin.php');
if (is_plugin_active('wow-follow-author/wow-follow-author.php')) {

add_filter('wpuf_account_sections', 'wpuf_fe_following');
function wpuf_fe_following($followingsection)
{
$followingsection = array_merge($followingsection, array(
		array('slug' => 'fe-following', 'label' => 'Following')
));
return $followingsection;
}

add_action('wpuf_account_content_fe-following', 'wpuf_fe_following_section', 10, 2);
function wpuf_fe_following_section($sections, $current_section)
{
wpuf_load_template(
		"fe-following.php",
		array('sections' => $sections, 'current_section' => $current_section)
);
}
}

add_filter('wpuf_account_sections', 'wpuf_fe_social');
function wpuf_fe_social($sections)
{
$sections = array_merge($sections, array(
array('slug' => 'fe-social', 'label' => 'Public Info')
));
return $sections;
}
add_action('wpuf_account_content_fe-social', 'wpuf_fe_social_section', 10, 2);
function wpuf_fe_social_section($sections, $current_section)
{
wpuf_load_template(
"fe-social.php",
array('sections' => $sections, 'current_section' => $current_section)
);
}

if (is_plugin_active('wow-delete-me/wow-delete-me.php')) {

add_filter('wpuf_account_sections', 'wpuf_fe_deleteaccount');
function wpuf_fe_deleteaccount($deletesection)
{
$deletesection = array_merge($deletesection, array(
		array('slug' => 'fe-deleteaccount', 'label' => 'Delete Account')
));
return $deletesection;
}

add_action('wpuf_account_content_fe-deleteaccount', 'wpuf_fe_deleteaccount_section', 10, 2);
function wpuf_fe_deleteaccount_section($sections, $current_section)
{
wpuf_load_template(
		"fe-deleteaccount.php",
		array('sections' => $sections, 'current_section' => $current_section)
);
}
}


if (is_plugin_active('favorites/favorites.php')) {

add_filter('wpuf_account_sections', 'wpuf_fe_bookmarks');
function wpuf_fe_bookmarks($bookmarkssection)
{
$bookmarkssection = array_merge($bookmarkssection, array(
		array('slug' => 'fe-bookmarks', 'label' => 'My Bookmarks')
));
return $bookmarkssection;
}

add_action('wpuf_account_content_fe-bookmarks', 'wpuf_fe_bookmarks_section', 10, 2);
function wpuf_fe_bookmarks_section($sections, $current_section)
{
wpuf_load_template(
		"fe-bookmarks.php",
		array('sections' => $sections, 'current_section' => $current_section)
);
}
}


//-----------------------------------------------------
// Display all categories
//-----------------------------------------------------
function wowthemes_display_all_cats()
{
global $post;
$disable_cat_list = get_theme_mod('disable_categories_list');
if ($disable_cat_list == 0) { ?>
<div class="clearfix"></div>
<div id="allcategories" class="display-categories mt-5">
    <p class="text-uppercase font-weight-light mb-0">
        <?php _e('Categories', 'mundana'); ?>
    </p>
    <div class="row">
        <?php
$display_categories = get_categories(array(
		'orderby' => 'name',
		'order'   => 'ASC'
));
foreach ($display_categories as $category) { ?>
        <div class="col-4 mt-4">
            <?php 
		$category_link = sprintf(
				'<a class="text-dark" href="%1$s" alt="%2$s">%3$s</a>',
				esc_url(get_category_link($category->term_id)),
				esc_attr(sprintf(__('View all posts in %s', 'mundana'), $category->name)),
				esc_html($category->name)
		);
		echo '<div class="text-uppercase font-weight-bold mb-1">' . sprintf(esc_html__('%s', 'mundana'), $category_link) . '</div> '; ?>
            <?php if (function_exists('z_taxonomy_image_url')) {
				if (z_taxonomy_image_url($category->term_id)) { ?>
            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                <img src="<?php echo z_taxonomy_image_url($category->term_id); ?>" />
            </a>
            <?php 
}
} ?>
            <?php echo '<a href="' . esc_url(get_category_link($category->term_id)) . '"><div class="text-muted mt-1">' . sprintf(esc_html__('%s Stories', 'mundana'), $category->count) . '</div></a>'; ?>
        </div>
        <?php 
} ?>
    </div>
</div>

<?php 
}
}


//-----------------------------------------------------
// Woo Commerce
//-----------------------------------------------------
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
function loop_columns()
{
return 3; // 3 products per row
}
}


//-------------------------------------------------------------
// Offset 5 for homepage all stories & adjust offset pagination
//-------------------------------------------------------------

//exclude latest post

function mundana_exclude_latest_post($query)
{
if ($query->is_home() && $query->is_main_query()) {
$query->set('offset', '5');
$query->set('ignore_sticky_posts', 1);
$query->set('post__not_in', get_option('sticky_posts'));
}
}
add_action('pre_get_posts', 'mundana_exclude_latest_post', 1);


//query offset

add_action('pre_get_posts', 'mundana_query_offset', 1);
function mundana_query_offset(&$query)
{

//Before anything else, make sure this is the right query...
if (!$query->is_main_query() || !$query->is_home()) {
return;
}

$offset = 5;
$ppp = get_option('posts_per_page');
if ($query->is_paged) {
$page_offset = $offset + (($query->query_vars['paged'] - 1) * $ppp);
$query->set('offset', $page_offset);
} else {
//This is the first page. Just use the offset...
$query->set('offset', $offset);
}
}

//adjust offset pagination

add_filter('found_posts', 'mundana_adjust_offset_pagination', 1, 2);
function mundana_adjust_offset_pagination($found_posts, $query)
{

//Define our offset again...
$offset = 5;

//Ensure we're modifying the right query object...
if ($query->is_home() && $query->is_main_query()) {
//Reduce WordPress's found_posts count by the offset... 
return $found_posts - $offset;
}
return $found_posts;
}


//-----------------------------------------------------
// Require
//-----------------------------------------------------
require_once get_template_directory() . '/inc/bootstrap/wp_bootstrap_pagination.php';
require_once get_template_directory() . '/inc/bootstrap/wp_bootstrap_navwalker.php';
require_once get_template_directory() . '/inc/customizer/include-kirki.php';
require_once get_template_directory() . '/inc/customizer/kirki-fallback.php';
require_once get_template_directory() . '/inc/customizer/customizer.php';
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

//-----------------------------------------------------
// TGMPA
//-----------------------------------------------------
if (!function_exists('mundana_required_plugins')) {
function mundana_required_plugins()
{
$config = array(
		'id'           => 'mundana',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => ''
);
$plugins = array(
		array(
				'name'     => esc_html__('Kirki', 'mundana'),
				'slug'     => 'kirki',
				'required' => true,
		),
		array(
				'name'     => esc_html__('WP Frontend Submit', 'mundana'),
				'slug'     => 'wp-user-frontend',
				'required' => false,
		),
		array(
				'name'     => esc_html__('Categories Images', 'mundana'),
				'slug'     => 'categories-images',
				'required' => false,
		),
		array(
				'name'     => esc_html__('WP Applause Button', 'mundana'),
				'slug'     => 'wp-claps-applause',
				'source'   => 'https://s3.amazonaws.com/wtnplugins/wp-claps-applause.zip',
				'required' => false,
		),
		array(
				'name'     => esc_html__('AJAX Login and Registration', 'mundana'),
				'slug'     => 'ajax-login-and-registration-modal-popup',
				'required' => false,
		),

);
tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'mundana_required_plugins');
}




?>