<?php
/**
 * Theme Customizer.
 *
 * @package mundana
 */

$textdomain = "mundana";



/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mundana_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'mundana_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mundana_customize_preview_js() {
	wp_enqueue_script( 'mundana_customizer', get_template_directory_uri() . '/inc/customizer/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'mundana_customize_preview_js' );

/**
 * Add the theme configuration
 */
Mundana_Kirki::add_config( 'mundana_theme', array(
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
) );


Mundana_Kirki::add_panel( 'mainthemepanel_mundana', array(
    'priority'    => 10,
    'title'       => __( 'Mundana Theme', 'mundana' ),
    'description' => __( 'Mundana Theme Options', 'mundana' ),
) );

//-----------------------------------------------------
// SECTION: Theme Style
//-----------------------------------------------------

Mundana_Kirki::add_section( 'section_theme_style', array(
    'title'      => esc_attr__( 'Theme Style', 'mundana' ),
    'priority'   => 2,
    'capability' => 'edit_theme_options',
    'panel'          => 'mainthemepanel_mundana', // Not typically needed.
) );

/**
 * Body Bg - enabled dark bg in next version
 */

/**
 * Navbar Bg Color
 */

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'navbar_bg_color',
	'label'       => esc_attr__( 'Navbar Background Color', 'mundana' ),
	'section'     => 'section_theme_style',
	'priority'    => 10,
	'default'     => '#ffffff',
    'output' => array(
		          array(
                     'element'  => '.mediumnavigation',
			         'property' => 'background-color',
		          ),

        ),
) );


/**
 * Navbar Text Color
 */

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'select',
	'settings'    => 'navbar_text_color',
	'label'       => esc_html__( 'Navbar Text Color', 'mundana' ),
	'section'     => 'section_theme_style',
	'default'     => 'navbar-light',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'navbar-light' => esc_html__( 'Dark Text', 'mundana' ),
		'navbar-dark' => esc_html__( 'White Text', 'mundana' ),
	],
) );



/**
 * Link Color
 */

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'accent-color',
	'label'       => esc_attr__( 'Article Links Color', 'mundana' ),
	'section'     => 'section_theme_style',
	'priority'    => 10,
	'default'     => '#03a87c',
    'output' => array(
		          array(
              	'element'  => 'a, a:hover',
			        	'property' => 'color',
		          ),

        ),
) );


/**
 * Comments Color
 */

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'comments_accentcolor',
	'label'       => esc_attr__( 'Comments Accent Color', 'mundana' ),
	'section'     => 'section_theme_style',
	'priority'    => 10,
	'default'     => '#03a87c',
    'output' => array(
        array(
			'element'  => '#comments a',
			'property' => 'color',
		),
		array(
			'element'  => '.comment-form input.submit, .lrm-form button, .lrm-form button[type=submit]',
			'property' => 'background-color',
		),
		array(
			'element'  => '.comment-form input.submit',
			'property' => 'border-color',
		),
	),
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'submitbutton_color',
	'label'       => esc_attr__( 'Submit Button', 'mundana' ),
	'section'     => 'section_theme_style',
	'priority'    => 10,
	'default'     => '#03a87c',
    'output' => array(
        array(
			'element'  => 'input[type="submit"], button, .btn-outline-success:hover',
			'property' => 'background-color',
		),
        array(
			'element'  => '.btn-outline-success, .btn-outline-success:hover',
			'property' => 'border-color',
		),
        array(
			'element'  => '.btn-outline-success',
			'property' => 'color',
		),
	),
) );

/**
 * Home
 */

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'home_intro_color',
	'label'       => esc_attr__( 'Home Sticky Post Color', 'mundana' ),
	'section'     => 'section_theme_style',
	'priority'    => 10,
	'default'     => '#2b2b2b',
    'output' => array(
        array(
			'element'  => '.introjumbo.bglight, .introjumbo .secondfont',
			'property' => 'color',
		),
	),
) );


/**
 * Footer Links Color
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'mundana_footerlinks_color',
	'label'       => esc_attr__( 'Footer Links', 'mundana' ),
	'section'     => 'section_colorschemes',
	'priority'    => 10,
	'default'     => '#1C9963',
    'output' => array(
        array(
			'element'  => 'footer.footer a',
			'property' => 'color',
		),
	),
) );



//-----------------------------------------------------
// SECTION: Typography
//-----------------------------------------------------

Mundana_Kirki::add_section( 'typography', array(
    'title'      => esc_attr__( 'Typography', 'mundana' ),
    'priority'   => 2,
    'capability' => 'edit_theme_options',
    'panel'          => 'mainthemepanel_mundana', // Not typically needed.
) );

/**
 * body_typography
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'body_typography',
	'label'       => esc_attr__( 'Body', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
        'font-family'    => 'PT Sans',
		'font-size'      => '16px',
		'line-height'    => '1.6',
		'color'          => '#2b2b2b',
	),
	'output' => array(
		array(
			'element' => array('body'),
		),
	),
) );

/**
 * body_blod_typography
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'body_bold_typography',
	'label'       => esc_attr__( 'Body Bold', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
		'font-family'    => 'PT Sans',
		'variant'        => '700',
	),
	'output' => array(
		array(
			'element' => array('b, strong, .font-weight-bold'),
		),
	),
) );

/**
 * body_blod_typography
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'headlines_typography',
	'label'       => esc_attr__( 'Headlines', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
		'font-family'    => 'Source Sans Pro',
		'variant'        => '700',
		'color'          => '#2b2b2b',
	),
	'output' => array(
		array(
			'element' => array('h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6'),
		),
	),
) );


/**
 * logo_typography
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'logo_typography',
	'label'       => esc_attr__( 'Logo', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
        'font-family'    => 'DM Serif Text',        
        'variant'        => '400',
		'color'          => '#2b2b2b',        
		'font-size'      => '1.9em',
		'letter-spacing' => '0',
	),
	'output' => array(
		array(
			'element' => array( '.navbar-brand'),
		),
	),
) );


/**
 * menu_tpyography
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'menu_typography',
	'label'       => esc_attr__( 'Menu', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
        'font-size'      => '0.97em',
        'text-transform' => 'uppercase',
        'letter-spacing' => '0px',
	),
	'output' => array(
		array(
			'element' => array( '.nav-link,.dropdown-item' ),
		),
	),
) );



/**
 *  article_headline_typography
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'article_headline_typography',
	'label'       => esc_attr__( 'Article Headline', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
        'font-family'    => 'Source Sans Pro',
        'font-size'      => '3.2rem',
		'color'          => '#2b2b2b',
        'line-height'    => '1.2',        
        'variant'        => '700',
	),
	'output' => array(
		array(
			'element' => array('.article-headline'),
		),
	),
) );

/**
 * singlearticle_typography
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'singlearticle_typography',
	'label'       => esc_attr__( 'Article Body', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
        'font-family'    => 'PT Serif',
		'line-height'    => '1.72',
        'font-size'      => '1.25rem',
		'color'          => '',
        'variant'       => 'regular',
        
	),
	'output' => array(
		array(
      	'element' => array( '.article-post, #comments .comment-content'),
		),
	),
) );


/**
 * singlearticle_bold_typography
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'singlearticle_bold_typography',
	'label'       => esc_attr__( 'Article Bold', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
        'font-family'    => 'PT Serif',
        'variant'        => '700',
		'color'          => '#2b2b2b',
        
	),
	'output' => array(
		array(
      	'element' => array( '.article-post b, .article-post strong'),
		),
	),
) );

/**
 * singlearticle_italic_typography
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'singlearticle_italic_typography',
	'label'       => esc_attr__( 'Article Italic', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
        'font-family'    => 'PT Serif',
        'variant'        => 'italic',
        'color'          => '#2b2b2b',
        
	),
	'output' => array(
		array(
      	'element' => array( '.article-post em, .article-post blockquote'),
		),
	),
) );


/**
 * Home Intro Headline
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'home_headline_typography',
	'label'       => esc_attr__( 'Home Sticky Post Healine', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
        'font-family'    => 'Source Sans Pro',
        'variant'        => '700',
        'font-size'      => '2.6em',
        'line-height'    => '1.2',
	),
	'output' => array(
		array(
			'element' => array('.introjumbo h1'),
		),
	),
) );

/**
 * Sidebar Title
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'typography',
	'settings'    => 'sidebar_title_typography',
	'label'       => esc_attr__( 'Sidebar Title', 'mundana' ),
	'section'     => 'typography',
	'priority'    => 10,
	'default'     => array(
        'font-size'      => '1.5em',
	),
	'output' => array(
		array(
			'element' => array('.thesidebar .spanborder.h4'),
		),
	),
) );


//-----------------------------------------------------
// SECTION: Logo & Nav
//-----------------------------------------------------

Mundana_Kirki::add_section( 'sectionlogonav', array(
	'title'      => esc_attr__( 'Logo & Nav Area', 'mundana' ),
	'priority'   => 2,
	'capability' => 'edit_theme_options',
    'panel'          => 'mainthemepanel_mundana', 
) );

/**
 * Logo
 */

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'image',
	'settings'    => 'logo_sectionlogonav',
	'label'       => esc_html__( 'Logo', 'mundana' ),
  'description'     => 'Recommended px size: 200x60',
	'section'     => 'sectionlogonav',
	'priority'    => 10,
  'transport' => 'auto',
	'default'     => '',
) );

/**
 * Header Search
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'     => 'switch',
  'settings' => 'header_search',
  'label'    => 'Header Search',
  'section'  => 'sectionlogonav',
  'default'  => 1,
  'choices'  => array(
    'on'  => __( 'ON', 'mundana' ),
    'off' => __( 'OFF', 'mundana' ),
  ),
) );

/**
 * Align Menu
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'     => 'switch',
  'settings' => 'justify_menu',
  'label'    => 'Justify Menu',
  'section'  => 'sectionlogonav',
  'default'  => 1,
  'choices'  => array(
    'on'  => __( 'ON', 'mundana' ),
    'off' => __( 'OFF', 'mundana' ),
  ),
) );


//-----------------------------------------------------
// SECTION: SOCIAL LINKS
//-----------------------------------------------------

Mundana_Kirki::add_section( 'social_links', array(
	'title'      => esc_attr__( 'Social Links', 'mundana' ),
	'priority'   => 2,
	'capability' => 'edit_theme_options',
    'panel'          => 'mainthemepanel_mundana', // Not typically needed.
) );

/**
 * Control: Facebook
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'     => 'text',
  'settings' => 'fb_url',
  'label'    => 'Facebook',
  'default'   => 'https://www.facebook.com/wowthemesnet/',
  'section'  => 'social_links',
) );
/**
 * Control: Twitter
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'      => 'text',
  'settings'  => 'twitter_url',
  'label'     => 'Twitter',
  'default'   => 'https://twitter.com/wowthemesnet',
  'section'   => 'social_links',
) );
/**
 * Control: YouTube
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'      => 'text',
  'settings'  => 'youtube_url',
  'label'     => 'YouTube',
  'default'   => 'https://youtube.com/',
  'section'   => 'social_links',
) );
/**
 * Control: Pinterest
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'      => 'text',
  'settings'  => 'pinterest_url',
  'label'     => 'Pinterest',
  'default'   => 'https://pinterest.com/',
  'section'   => 'social_links',
) );

/**
 * Control: Linkedin
 */
Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'      => 'text',
  'settings'  => 'linkedin_url',
  'label'     => 'Linkedin',
  'default'   => 'https://linkedin.com/',
  'section'   => 'social_links',
) );

//-----------------------------------------------------
// SECTION: Articles
//-----------------------------------------------------
Mundana_Kirki::add_section( 'sectionarticles', array(
	'title'      => esc_attr__( 'Articles', 'mundana' ),
	'priority'   => 2,
	'capability' => 'edit_theme_options',
    'panel'          => 'mainthemepanel_mundana', 
    
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
    'type'        => 'custom',
	'settings'    => 'infor_title_articles',
	'label'       => esc_html__( 'Articles', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_authorbox_sectionarticles',
	'label'       => esc_html__( 'Disable Author', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_readingtime_sectionarticles',
	'label'       => esc_html__( 'Disable Reading Time', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_date_sectionarticles',
	'label'       => esc_html__( 'Disable Article Date', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => 0,
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_share_twitter',
	'label'       => esc_html__( 'Disable Twitter Share', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_share_fb',
	'label'       => esc_html__( 'Disable Facebook Share', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_share_pinterest',
	'label'       => esc_html__( 'Disable Pinterest Share', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_share_linkedin',
	'label'       => esc_html__( 'Disable Linkedin Share', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_share_sectionarticles',
	'label'       => esc_html__( 'Disable Share', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_cats_sectionarticles',
	'label'       => esc_html__( 'Disable Categories', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_tags_sectionarticles',
	'label'       => esc_html__( 'Disable Tags', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_rp_sectionarticles',
	'label'       => esc_html__( 'Disable Related Posts', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_excerpt_sectionarticles',
	'label'       => esc_html__( 'Disable Excerpt', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
    'type'        => 'custom',
	'settings'    => 'infor_title_article_cards',
	'label'       => esc_html__( 'Article Cards', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_authorbox_sectionarticles_card',
	'label'       => esc_html__( 'Disable Author', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_readingtime_sectionarticles_card',
	'label'       => esc_html__( 'Disable Reading Time', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_date_sectionarticles_card',
	'label'       => esc_html__( 'Disable Meta Date', 'mundana' ),
	'section'     => 'sectionarticles',
	'priority'    => 10,
	'default'     => '0',
) );

//-----------------------------------------------------
// SECTION: Post Alert Bar
//-----------------------------------------------------
Mundana_Kirki::add_section( 'sectionalertbar', array(
	'title'      => esc_attr__( 'Article Alert Bar', 'mundana' ),
	'priority'   => 2,
	'capability' => 'edit_theme_options',
    'description' => __( 'Navigate to a random post in order to see the changes. The alert bar is shown on scroll.', 'mundana' ),
    'panel'          => 'mainthemepanel_mundana', // Not typically needed.
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'textarea',
	'settings'    => 'text_before_follow',
	'label'       => esc_attr__( 'Text before follow buttons', 'mundana' ),
	'section'     => 'sectionalertbar',
	'priority'    => 10,
	'default'     => '<b>Follow us</b> on',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'     => 'switch',
  'settings' => 'show_fb_btn',
  'label'    => 'Facebook follow button',
  'section'  => 'sectionalertbar',
  'default'  => 1,
  'choices'  => array(
    'on'  => __( 'ON', 'mundana' ),
    'off' => __( 'OFF', 'mundana' ),
  ),
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'     => 'switch',
  'settings' => 'show_twitter_btn',
  'label'    => 'Twitter follow button',
  'section'  => 'sectionalertbar',
  'default'  => 1,
  'choices'  => array(
    'on'  => __( 'ON', 'mundana' ),
    'off' => __( 'OFF', 'mundana' ),
  ),
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'     => 'switch',
  'settings' => 'show_youtube_btn',
  'label'    => 'YouTube follow button',
  'section'  => 'sectionalertbar',
  'default'  => 1,
  'choices'  => array(
    'on'  => __( 'ON', 'mundana' ),
    'off' => __( 'OFF', 'mundana' ),
  ),
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'     => 'switch',
  'settings' => 'show_pinterest_btn',
  'label'    => 'Pinterest follow button',
  'section'  => 'sectionalertbar',
  'default'  => 1,
  'choices'  => array(
    'on'  => __( 'ON', 'mundana' ),
    'off' => __( 'OFF', 'mundana' ),
  ),
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'     => 'switch',
  'settings' => 'show_linkedin_btn',
  'label'    => 'Linkedin follow button',
  'section'  => 'sectionalertbar',
  'default'  => 1,
  'choices'  => array(
    'on'  => __( 'ON', 'mundana' ),
    'off' => __( 'OFF', 'mundana' ),
  ),
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
  'type'     => 'switch',
  'settings' => 'show_nextpost',
  'label'    => 'Next Post Link',
  'section'  => 'sectionalertbar',
  'default'  => 1,
  'choices'  => array(
    'on'  => __( 'ON', 'mundana' ),
    'off' => __( 'OFF', 'mundana' ),
  ),
) );


//-----------------------------------------------------
// SECTION: Footer
//-----------------------------------------------------
Mundana_Kirki::add_section( 'sectionfooter', array(
	'title'      => esc_attr__( 'Footer', 'mundana' ),
	'priority'   => 2,
	'capability' => 'edit_theme_options',
  'panel'          => 'mainthemepanel_mundana', // Not typically needed.
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'textarea',
	'settings'    => 'footer_textleft',
	'label'       => esc_attr__( 'Footer Text Left', 'mundana' ),
	'section'     => 'sectionfooter',
	'priority'    => 10,
	'default'     => '&copy; Copyright Your Website Name',
) );


Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'textarea',
	'settings'    => 'footer_textright',
	'label'       => esc_attr__( 'Footer Text Right', 'mundana' ),
	'section'     => 'sectionfooter',
	'priority'    => 10,
	'default'     => 'Mundana Theme by <a target="_blank" href="https://www.wowthemes.net">WowThemesNet</a>',
) );

//-----------------------------------------------------
// SECTION: Tracking Codes
//-----------------------------------------------------
Mundana_Kirki::add_section( 'sectiontracking', array(
	'title'      => esc_attr__( 'Tracking Codes', 'mundana' ),
	'priority'   => 2,
	'capability' => 'edit_theme_options',
  'panel'          => 'mainthemepanel_mundana', // Not typically needed.
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'code',
	'settings'    => 'head_sectiontracking',
	'label'       => esc_attr__( 'Header Area', 'mundana' ),
  'description'     => 'Right before "head" ends. Do not forget to save after closing the editor.',
	'section'     => 'sectiontracking',
	'priority'    => 10,
	'default'     => '',
	'choices'     => array(
		'language' => 'html',
	),
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'code',
	'settings'    => 'footer_sectiontracking',
	'label'       => esc_attr__( 'Footer Area', 'mundana' ),
  'description'     => 'Right before "body" ends. Do not forget to save after closing the editor.',
	'section'     => 'sectiontracking',
	'priority'    => 10,
	'default'     => '',
	'choices'     => array(
		'language' => 'html',
	),
) );


//-----------------------------------------------------
// SECTION: Newsletter
//-----------------------------------------------------
Mundana_Kirki::add_section( 'section_newsletter', array(
    'title'      => esc_attr__( 'Newsletter', 'mundana' ),
    'priority'   => 2,
    'capability' => 'edit_theme_options',
    'description'     => 'To add a newsletter form right after the article, navigate to Appearance/Widgets and drag your widget in "After Article" area. If you use Mailchimp plugin, you can customize it below. <br/><br/>Tip: Not using Mailchimp? You can add any code provided by your newsletter client in a text editor widget instead.',
    'panel'          => 'mainthemepanel_mundana', // Not typically needed.
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'bg_newsletter',
	'label'       => esc_attr__( 'Newsletter Background', 'mundana' ),
	'section'     => 'section_newsletter',
	'priority'    => 10,
	'default'     => '#e8f3ec',
    'output' => array(
        array(
			'element'  => '.widget-area .mc4wp-form',
			'property' => 'background-color',
		),
	),
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'button_newsletter',
	'label'       => esc_attr__( 'Newsletter Button Color', 'mundana' ),
	'section'     => 'section_newsletter',
	'priority'    => 10,
	'default'     => '#03a87c',
    'output' => array(
        array(
			'element'  => '.widget-area .mc4wp-form input[type="submit"]',
			'property' => 'background-color',
		),
	),
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'textcolor_newsletter',
	'label'       => esc_attr__( 'Newsletter Text Color', 'mundana' ),
	'section'     => 'section_newsletter',
	'priority'    => 10,
	'default'     => '#2b2b2b',
    'output' => array(
        array(
			'element'  => '.widget-area .mc4wp-form, .mc4wp-form-fields h1, .mc4wp-form-fields h2, .mc4wp-form-fields h3, .mc4wp-form-fields h4, .mc4wp-form-fields h5, .mc4wp-form-fields h6',
			'property' => 'color',
		),
	),
) );

//-----------------------------------------------------
// SECTION: Other
//-----------------------------------------------------
Mundana_Kirki::add_section( 'section_misc', array(
    'title'      => esc_attr__( 'Other', 'mundana' ),
    'priority'   => 2,
    'capability' => 'edit_theme_options',
    'panel'          => 'mainthemepanel_mundana', // Not typically needed.
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
    'type'        => 'image',
    'settings'    => 'fallback_image',
    'label'       => esc_html__( 'Fallback Image', 'mundana' ),
    'description'       => esc_html__( 'For schema.org & related posts when a featured image is not set.', 'mundana' ),
    'section'     => 'section_misc',
    'priority'    => 10,
    'transport' => 'auto',
    'default'     => '',
) );

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_schema',
	'label'       => esc_html__( 'Disable Theme Schema', 'mundana' ),
	'section'     => 'section_misc',
	'priority'    => 10,
	'default'     => '0',
) );


Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'select',
	'settings'    => 'featured_category',
	'label'       => esc_html__( 'Featured Category on Homepage', 'mundana' ),
	'section'     => 'section_misc',
	'default'     => 'option-1',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => ( class_exists( 'Kirki_Helper' ) ) ? Kirki_Helper::get_terms( array('taxonomy' => 'category') ) : array(),
));


Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'select',
	'settings'    => 'featured_category',
	'label'       => esc_html__( 'Featured Category on Homepage', 'mundana' ),
	'section'     => 'section_misc',
	'default'     => 'option-1',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => ( class_exists( 'Kirki_Helper' ) ) ? Kirki_Helper::get_terms( array('taxonomy' => 'category') ) : array(),
));

Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'checkbox',
	'settings'    => 'disable_categories_list',
	'label'       => esc_html__( 'Disable Categories List', 'mundana' ),
	'section'     => 'section_misc',
	'priority'    => 10,
	'default'     => '0',
) );


Mundana_Kirki::add_field( 'mundana_theme', array(
	'type'        => 'text',
	'settings'    => 'author_reassigned',
	'label'       => esc_attr__( 'Reassign posts of deleted users', 'mundana' ),
    'description' => esc_attr__( 'If users do not delete their posts before deleting their account, type in the username of the reassigned author.', 'mundana' ),
	'section'     => 'section_misc',
	'priority'    => 10,
	'default'     => '',
) );