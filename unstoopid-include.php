<?php
/**
 * @package UnstoopidInclude
 * @version 0.1
 */
/*
Plugin Name: Unstoopid Include
Plugin URI: http://wordpress.org/extend/plugins/unstoopid-include/
Description: A simple, hassle free way to include post content into another. No weird interfaces, no extra features.
Author: Jason Martin
Version: 0.1
Author URI: http://red-e.eu
*/
define( 'REDE_PLUGIN_BASE_PATH', plugin_dir_path(__FILE__) );
require_once( plugin_dir_path(__FILE__) . 'classes/class-unstoopid-include-widget.php' );

function unstoopid_widgets_init() {
  register_widget( 'Widget_UnstoopidInclude' );
}
function unstoopid_disable_richedit( $default ) {
  return false;
}
function unstoopid_include_init() {
  
  add_shortcode('unstoopid_include', 'unstoopid_include_shortcode');
  register_post_type( 'unstoopid_partial', array(
    'labels' => array (
      'name' => __('Partials','unstoopid_include'),
      'singular_name' => __('Partial','unstoopid_include'),
      'add_new' => __('Add New','unstoopid_include'),
      'add_new_item' => __('Add New Partial','unstoopid_include'),
      'all_items' => __('All Partials','unstoopid_include'),
      'view_item' => __('View Partial','unstoopid_include'),
      'search_items' => __('Search Partials','unstoopid_include'),
      'not_found' => __('No partials found','unstoopid_include'),
      'not_found_in_trash' => __('No partials found in trash','unstoopid_include'),
      'menu_name' => __('Partials','unstoopid_include')
    ),
    'public' => true,
    'has_archive' => false,
    'publicly_queryable' => false,
  ));
  add_action( "wp_enqueue_scripts", "unstoopid_include_enqueue_scripts" );
  add_action( "wp_footer", "unstoopid_include_footer" );
  add_filter( "manage_unstoopid_partial_posts_columns","unstoopid_include_manage_columns_header" );
  add_filter( "manage_unstoopid_partial_posts_custom_column","unstoopid_include_manage_columns_content",10,2 );
  add_filter( "user_can_richedit", "unstoopid_disable_richedit" );
  
  
  
}

function unstoopid_include_manage_columns_header($defaults) {
  $defaults['unstoopid_partial_shortcode'] = __('Shortcode','unstoopid_include');
  return $defaults; 
}
function unstoopid_include_manage_columns_content($column_name,$post_ID) {

  if ($column_name == "unstoopid_partial_shortcode") {
    echo "[unstoopid_include ids=\"$post_ID\"]";
  }
}
function unstoopid_include_enqueue_scripts() {
		wp_enqueue_style('unstoopid-css',  plugins_url('assets/css/unstoopid-include.css',               __FILE__) );
}
function unstoopid_include_footer() {

}
function unstoopid_include_shortcode($attr) {
  $post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) ) {
			$attr['orderby'] = 'post__in';
	  }
		$attr['include'] = $attr['ids'];
		unset($attr['ids']);
	}

	$attr['post_status'] = array('publish','private','protected');
  $attr['post_type'] = array('unstoopid_partial');


  $posts = get_posts( $attr );
	$output = '';
	foreach ( $posts as $post ) {
	  $output .= $post->post_content;
	}
	return do_shortcode($output);
}

add_action("init","unstoopid_include_init",10);
// Let's register the widget
add_action(
  'widgets_init',
  'unstoopid_widgets_init'
);

?>
