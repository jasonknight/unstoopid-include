<?php
require_once( plugin_dir_path(__FILE__) . '/class-rede-helpers.php' );
class Widget_UnstoopidInclude extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'unstoopid_widget', 'description' => __('Include Partials','unstoopid_include'));
		
		$control_ops = array('width' => 300, 'height' => 250);
		
		parent::__construct('unstoopid_include_widget', __('Partial Widget'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		
		$text = apply_filters( 'widget_unstoopid_include', empty( $instance['text'] ) ? '' : $instance['text'], $instance );

		$text = do_shortcode($text);
		
		if (isset( $instance['show_title'] ) && $instance['show_title'] == 'yes' ) {
		  $helpers = new RedEHelpers();
		  $title = strip_tags($instance['title']);
		  echo $helpers->renderTemplate('unstoopid-widget.php', array(
		
		      'instance'    => $instance,
		      'text'        => $text,
		      'title'       => $title,
		      'self'        => $this,
		      'id'          => $this->id,
		      
		    )
		  );
		  
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title']  = $new_instance['title'];
		
		$instance['text']   = $new_instance['text'];
		
		$instance['show_title']   = $new_instance['show_title'];
		
		return $instance;
	}

	function form( $instance ) {
	  $helpers = new RedEHelpers();
	  
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		
		$title = strip_tags($instance['title']);
		isset($instance['show_title']) ? $show_title = $instance['show_title'] : $show_title = 'yes';
		
		$text = $instance['text'];
		
		$partials = get_posts( array('post_type' => 'unstoopid_partial') );
		
		echo $helpers->renderTemplate('unstoopid-widget-form.php', array(
		
		    'instance'    => $instance,
		    'text'        => $text,
		    'title'       => $title,
		    'show_title'  => $show_title,
		    'partials'    => $partials,
		    'self'        => $this,
		    
		  )
		);
  
	}
}

