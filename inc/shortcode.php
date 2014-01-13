<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_shortcode( 'wpinstagram_images' , 'wpinstagram_images' );


function wpinstagram_images( $atts ){

    extract( shortcode_atts( array(
        'show'             => 1,
        'show_description' => false,
        'username'         => null,
        'target'           => '_blank',
        'image_size'       => '150x150'
    ), $atts ) );

    $show     = intval($show);
    $username = preg_replace("#[@\s]#","",$username);
    $show     = $show < 1 ? 1 : $show;

    if( !$username || empty($username) ){
    	return;
    }

    $width = $height = 100;

    if( !empty($image_size) ){

    	if( preg_match("#x#i",$image_size) ){
    		list($width,$height) = explode('x',$image_size);
    	}

    	if( $width < 1)  $width = 100;
    	if( $height < 1) $height = 100;
    }

    $images = wpinstagram_widget_content( $username );

    $images_to_show = array();
    if( is_array($images) && sizeof($images)>0 ){
    	for( $i=0; $i<$show; $i++ ){
    		array_push( $images_to_show , $images[$i] );
    	}
    }

    _wpinstagram_template( 'shortcode_images' , array(
    	'images' => $images_to_show,
    	'target' => $target,
    	'show_description'=> $show_description,
    	'width'  => $width,
    	'height' => $height
    ));

}