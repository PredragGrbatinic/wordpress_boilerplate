<?php

function boilerplate_setup()
{
// ADD POST THUMBNAILS
    add_theme_support('post-thumbnails');

// MENUS
     add_theme_support('menus');

// Enable support for Post Formats.
    add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

//Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    add_theme_support('automatic-feed-links');
    add_theme_support("custom-header");
    add_theme_support("custom-background");

//Image sizes
    add_image_size('header-banner', 1600, 775, true);
    add_image_size('testimonial-thumbnail', 144, 144, true);


// Localisation Support (files for translations-PO files)
    load_theme_textdomain('custom_project', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'boilerplate_setup');


// Enqueue Stylesheets
function boilerplate_styles()
{
    // CSS files
    //wp_enqueue_style('favicons', get_template_directory_uri() . '/img/favicon.ico'); //add favicon on this path
    wp_enqueue_style('main', get_template_directory_uri() . '/css/main.min.css');

    // JS files
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/scripts/plugins.min.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'main', get_template_directory_uri() . '/scripts/main.min.js', array ( 'jquery' ), 1.1, true);

}
add_action('wp_enqueue_scripts', 'boilerplate_styles');

//Adding ACF options page for header and footer in backend if fields exists

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' => __( 'Theme Options' ),
        'menu_title' => __( 'Theme Options' ),
        'menu_slug' => 'theme-options',
        'capability' => 'edit_posts',
        'parent_slug' => '',
        'position' => false,
        'icon-url' => false,
        'redirect' => true
    ));

    acf_add_options_sub_page(array(
        'page_title' => __( 'Header' ),
        'menu_title' => __( 'Header' ),
        'menu_slug' => 'theme-options-header',
        'capability' => 'edit_posts',
        'parent_slug' => 'theme-options',
        'position' => false,
        'icon-url' => false,
    ));

    acf_add_options_sub_page(array(
        'page_title' => __( 'Footer' ),
        'menu_title' => __( 'Footer' ),
        'menu_slug' => 'theme-options-footer',
        'capability' => 'edit_posts',
        'parent_slug' => 'theme-options',
        'position' => false,
        'icon-url' => false,
    ));
}

// Register Menu Locations
function register_menu_locations()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'main-menu' => __('Main Menu'), // Main Navigation
        'footer-menu' => __('Footer Menu') // Footer Menu
    ));
}

add_action('init', 'register_menu_locations'); // Add Menu Locations to Theme

// Main Menu
function main_menu_nav()
{
    wp_nav_menu(array(
        'theme_location' => 'main-menu',
        'menu' => '',
        'container' => 'section',
        'container_class' => 'menu-{menu slug}-container nav-bottom',
        'container_id' => '',
        'menu_class' => 'navigation__list',
        'menu_id' => '',
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '<ul class="navigation__list">%3$s</ul>',
        'depth' => 2,
        'walker' => ''
    ));
}

// Footer Menu
function footer_menu_nav()
{
    wp_nav_menu(array(
        'theme_location' => 'footer-menu',
        'menu' => '',
        'container' => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id' => '',
        'menu_class' => 'menu',
        'menu_id' => '',
        'echo' => true,
        'fallback_cb' => '',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '<ul>%3$s</ul>',
        'depth' => 1,
        'walker' => ''
    ));
}

// Add widget support
// If Dynamic Sidebar Exists
function custom_widgets_init()
{
    if (function_exists('register_sidebar')) {
        // Define Sidebar Widget Area 1
        register_sidebar(array(
            'name'          => __('Widget Area 1', __( 'Widget Area 1' )),
            'description'   => __('Description for this widget-area...', __( 'Description for this widget-area...' )),
            'id'            => 'widget-area-1',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        ));

        // Define Sidebar Widget Area 2
        register_sidebar(array(
            'name'          => __('Widget Area 2', __( 'Widget Area 2' )),
            'description'   => __('Description for this widget-area...', __( 'Description for this widget-area...' )),
            'id'            => 'widget-area-2',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        ));
    }
}
add_action( 'widgets_init', 'custom_widgets_init' );

// Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'do_shortcode');

// Remove <p> tags from Excerpt and Content altogether
remove_filter('the_excerpt', 'wpautop');
remove_filter('the_content', 'wpautop');

// Replace the […] in a Read More link
if( !function_exists( "wp_excerpt_more" ) ) {
    function wp_excerpt_more( $more ) {
        global $post;
        return '&hellip; <!--a href="'. get_permalink($post->ID) . '" class="read-more">__( \'Read article\' ) &raquo;</a-->';
    }
}
add_filter('excerpt_more', 'wp_excerpt_more');

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}
add_filter('body_class', 'add_slug_to_body_class');

//Number of words in excerpt, by default its 55
function new_excerpt_length($length) {
    $length = 20;
    return $length;
}
add_filter('excerpt_length', 'new_excerpt_length');

// remove version info from head and feeds for better security
function complete_version_removal() {
return '';
}
add_filter('the_generator', 'complete_version_removal');