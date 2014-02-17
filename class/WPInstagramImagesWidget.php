<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPInstagramImagesWidget extends WP_Widget{

	public function __construct() {
		parent::__construct(
			'wpinstagramimageswidget',
			__('WP Instagram Images Widget', WPINSTAGRAM_TXT_DOMAIN),
			array( 
				'description' => __('Easy way to show instagram images', WPINSTAGRAM_TXT_DOMAIN),
			)
		);
	}

	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );


		$params = array();
		$params['before_widget'] = $args['before_widget'];
		$params['before_title']  = $args['before_title'];
		$params['after_widget']  = $args['after_widget'];
		$params['after_title']   = $args['after_title'];

		$params['title']         = $instance['title'];

		if(isset($instance['instagram_username'])){
			$images = wpinstagram_widget_content($instance['instagram_username']);

			if(sizeof($images)>0){

				if(!isset($instance['number_of_thumbs'])){
					$instance['number_of_thumbs'] = 1;
				}

				if($instance['number_of_thumbs'] > 5){
					$instance['number_of_thumbs'] = 5;
				}

				$values = array();
				for( $i=0; $i<$instance['number_of_thumbs']; $i++ ){
					$values[] = $images[$i];
				}

				$params['images'] = $values;
			}
		}

		if(!empty($instance['thumbnail_size'])){
			$params['thumbnail_size'] = explode('x',$instance['thumbnail_size']);
		}

		$params['show_description'] = isset($instance['show_description']) ? $instance['show_description'] : true;
		
		$params['new_tab'] = $instance['new_tab'];

		_wpinstagram_template( 'widget_frontend' , $params );
	}

 	public function form( $instance ) {

 		$title              = isset($instance['title']) ? trim($instance['title']) : '';
 		$instagram_username = isset($instance['instagram_username']) ? trim($instance['instagram_username']) : '';
 		$thumbnail_size     = isset($instance['thumbnail_size']) ? trim($instance['thumbnail_size']) : '';
 		$number_of_thumbs   = isset($instance['number_of_thumbs']) ? (int) $instance['number_of_thumbs'] : 1;
 		$new_tab            = isset($instance['new_tab']) ?  (boolean) $instance['new_tab'] : true;
 		$show_description   = isset($instance['show_description']) ? (boolean) $instance['show_description'] : true;

 		$params = array();
 		$params['title']  = $title;

 		$params['field'] = array(
 			'title'    => array(
	 			'id'   => $this->get_field_id('title'),
	 			'name' => $this->get_field_name('title')
 			),
 			'instagram_username'=> array(
 				'id'   => $this->get_field_id('instagram_username'),
 				'name' => $this->get_field_name('instagram_username')
 			),
 			'thumbnail_size' => array(
 				'id'   => $this->get_field_id('thumbnail_size'),
 				'name' => $this->get_field_name('thumbnail_size')	
 			),
 			'number_of_thumbs'=>array(
 				'id'   => $this->get_field_id('number_of_thumbs'),
 				'name' => $this->get_field_name('number_of_thumbs')
 			),
 			'new_tab' => array(
 				'id'   => $this->get_field_id('new_tab'),
 				'name' => $this->get_field_name('new_tab')
 			),
 			'show_description'=>array(
 				'id'   => $this->get_field_id('show_description'),
 				'name' => $this->get_field_name('show_description')
 			)
 		);

 		$params['instagram_username'] = $instagram_username;
 		$params['thumbnail_size']     = $thumbnail_size;
 		$params['number_of_thumbs']   = $number_of_thumbs;
 		$params['new_tab']            = $new_tab;
 		$params['show_description']   = $show_description;


 		_wpinstagram_template( 'widget_form' , $params );
	}

	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title']              = ( ! empty( $new_instance['title'] ) ) ? trim(strip_tags($new_instance['title'])) : '';
		$instance['instagram_username'] = ( ! empty( $new_instance['instagram_username'] ) ) ? trim(strip_tags($new_instance['instagram_username'])) : '';
		$instance['thumbnail_size']     = ( ! empty( $new_instance['thumbnail_size'] ) ) ? trim(strip_tags($new_instance['thumbnail_size'])) : '';
		$instance['number_of_thumbs']   = isset($new_instance['number_of_thumbs']) ? (int) $new_instance['number_of_thumbs'] : 1;
		$instance['new_tab']            = isset($new_instance['new_tab']) ? (boolean) $new_instance['new_tab'] : false;
		$instance['show_description']   = isset($new_instance['show_description']) ? (boolean) $new_instance['show_description'] : false;

		return $instance;
	}

}