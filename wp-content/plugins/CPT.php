<?php
/**
 * Plugin Name: Custom Post Type Creator
 * Description: Plugin for Custom Post Types Creation
 * Version: 1.0
 * Author: Predrag Grbatinic
 */


add_action( 'init', 'create_posttypes' );

function create_posttypes() {

    // Newsletter post type
    $singular = 'Newsletter';
    $plural = 'Newsletters';

    $labels = array(
        'name' => _x($plural, 'newsletter post type', 'custom_project'),
        'singular-name' => _x($singular, 'newsletter post type', 'custom_project'),
        'menu_name' => _x($plural, 'admin menu', 'custom_project' ),
        'name_admin_bar' =>_x($plural, 'add new on admin bar', 'custom_project'),
        'add_new' => _x('Add new ' . $singular, 'newsletter', 'custom_project' ),
        'add_new_item' => __('Add new ' . $singular, 'custom_project' ),
        'new_item' => __('Add new ' . $singular, 'custom_project' ),
        'edit_item' => __('Edit ' . $singular, 'custom_project' ),
        'view_item' => __('View ' . $singular, 'custom_project' ),
        'all_items' => __('All ' . $plural, 'custom_project' ),
        'search_items' => __('Search ' . $plural, 'custom_project' ),
        'parent_item_colon' => __('Parent ' . $singular . ':', 'custom_project' ),
        'not_found' => __('Not found', 'custom_project' ),
        'not_found_in_trash' => __('Not found in trash', 'custom_project' )
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_ui_menu' => true,
		'menu_icon' => 'dashicons-media-document',
        'menu_position' => 5,
        'query_var' => true,
        'exclude_from_search' => false,
        'rewrite' => array( 'slug' => 'newsletters'),
        'cabability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
    );

    register_post_type('newsletters', $args);


    // Testemonials post type
    $singular = 'Testimonial';
    $plural = 'Testimonials';

    $labels = array(
        'name' => _x($plural, 'testimonials post type', 'custom_project'),
        'singular-name' => _x($singular, 'testimonial post type', 'custom_project'),
        'menu_name' => _x($plural, 'admin menu', 'custom_project' ),
        'name_admin_bar' =>_x($plural, 'add new on admin bar', 'custom_project'),
        'add_new' => _x('Add new ' . $singular, 'testimonial', 'custom_project' ),
        'add_new_item' => __('Add new ' . $singular, 'custom_project' ),
        'new_item' => __('Add new ' . $singular, 'custom_project' ),
        'edit_item' => __('Edit ' . $singular, 'custom_project' ),
        'view_item' => __('View ' . $singular, 'custom_project' ),
        'all_items' => __('All ' . $plural, 'custom_project' ),
        'search_items' => __('Search ' . $plural, 'custom_project' ),
        'parent_item_colon' => __('Parent ' . $singular . ':', 'custom_project' ),
        'not_found' => __('Not found', 'custom_project' ),
        'not_found_in_trash' => __('Not found in trash', 'custom_project' )
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_ui_menu' => true,
		'menu_icon' => 'dashicons-format-chat',
        'menu_position' => 5,
        'query_var' => true,
        'exclude_from_search' => false,
        'rewrite' => array( 'slug' => 'testimonials'),
        'cabability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
    );

    register_post_type('testimonials', $args);

    
}

add_action( 'init', 'create_taxonomies', 0 );

function create_taxonomies()
{
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => __('Testimonial Categories', 'custom_project'),
        'singular_name' => __('Testimonial Category', 'custom_project'),
        'search_items' => __('Search Testimonial Categories', 'custom_project'),
        'all_items' => __('All Testimonial Categories', 'custom_project'),
        'parent_item' => __('Parent Testimonial Category', 'custom_project'),
        'parent_item_colon' => __('Parent Testimonial Category: ', 'custom_project'),
        'edit_item' => __('Edit Testimonial Category', 'custom_project'),
        'update_item' => __('Update Testimonial Category', 'custom_project'),
        'add_new_item' => __('Add New Testimonial Category', 'custom_project'),
        'new_item_name' => __('New Testimonial Category', 'custom_project'),
        'menu_name' => __('Testimonial Categories', 'custom_project'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'testimonial-category'),
    );

    register_taxonomy('testimonial-category', array('testimonials'), $args);
    
}

function my_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry,
    // when you add a post of this CPT.
    create_posttypes();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'my_rewrite_flush' );
