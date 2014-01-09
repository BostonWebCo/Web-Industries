<?php
/**
 *  Web Industries theme functions and definitions.
 *  @author George Gecewicz
 */

/**
 *  Set up theme defaults and registers support for various WordPress features.
 */
function webindustries_theme_setup() {

    // Add RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    // Enable support for Post Thumbnails.
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus.
    register_nav_menus( array(
        'header'   => __( 'The header navigation', 'web-industries-theme' ),
        'footer' => __( 'The footer navigation', 'web-industries-theme' ),
    ) );
}
add_action( 'after_setup_theme', 'webindustries_theme_setup' );

/**
 *  Register theme widget areas.
 */
function webindustries_theme_widgets_init() {

    register_sidebar( array(
        'name'          => __( 'Primary Sidebar', 'web-industries-theme' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Primary sidebar.', 'web-industries-theme' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );

}
add_action( 'widgets_init', 'webindustries_theme_widgets_init' );

/**
 *  Enqueue scripts and styles for the front end.
 */
function webindustries_theme_scripts() {

    // Load the main stylesheet and public-facing js.
    wp_enqueue_style( 'webindustries-style', get_stylesheet_uri() );
    wp_enqueue_script( 'webindustries-public', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), '1.0', true );

    // Load comment-reply script if necessary.
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

}
add_action( 'wp_enqueue_scripts', 'webindustries_theme_scripts' );

/**
 *  Custom body classes for Web Industries.
 */
function webindustries_theme_body_class( $classes ) {
    return $classes;
}
add_filter( 'body_class', 'webindustries_theme_body_class' );

/**
 *  Create a nicely formatted and more specific title element text for output
 *  in head of document, based on current view. Taken from Twenty Fourteen.
 */
function webindustries_theme_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() ) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 ) {
        $title = "$title $sep " . sprintf( __( 'Page %s', 'web-industries-theme' ), max( $paged, $page ) );
    }

    return $title;
}
add_filter( 'wp_title', 'webindustries_theme_wp_title', 10, 2 );