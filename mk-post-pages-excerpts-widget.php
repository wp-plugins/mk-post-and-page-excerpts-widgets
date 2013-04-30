<?php
/*
  Plugin Name: MK Post and Page Excerpts Widgets
  Plugin URI: https://manojranawpblog.wordpress.com/
  Description: Creates widgets that display excerpts from posts or pages in the sidebar. You may use 'more' links, show featured image, set excerpt length of the post or page.
  Version: 1.1
  Author: Manoj Kumar
  Author URI: https://manojranawpblog.wordpress.com/
  Tags: Wordpress Post Widget,Wordpress Page Widget, Sidebar widget, Widget, Wodgets, Post Widgets, Post Widget, Page Widgets, Page Widget, Wordpress Widget 
 */

/*
 * Add Stylesheet
 */


add_action('wp_enqueue_scripts', 'mk_posts_pages_style');
function mk_posts_pages_style() {
  wp_register_style('mk_posts_pages_style', plugins_url('/css/styles.css', __FILE__));
  wp_enqueue_style('mk_posts_pages_style');
}

/*
 * Add the Post Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "mk_post_widget" );' ) );
require_once 'mk-post-widget.php';

/*
 * Add the Page Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "mk_page_widget" );' ) );
require_once 'mk-page-widget.php';
