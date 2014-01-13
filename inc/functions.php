<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function wpinstagram_cache_set( $key, $values , $lifetime = 300 ){

	$value = array(
		'expires'  => time() + $lifetime,
		'values'   => $values
	);

	delete_option( $key );
	add_option( $key , serialize($value) );

	return $values;
}


function wpinstagram_cache_get( $key ){

	if( !WPINSTAGRAM_CACHE_ENABLED ){
		return null;
	}

	$cached = get_option( $key );

	if( !$cached ){
		return null;
	}

	$cached = @unserialize($cached);

	if( !$cached ){
		return null;
	}

	if( !isset($cached['expires']) ){
		return null;
	}

	if( $cached['expires'] > time() ){
		return $cached['values'];
	}

	return null;
}

function wpinstagram_widget_content( $username ){


	$key = 'wpi_'.md5($username);

	$data = wpinstagram_cache_get($key);

	if( is_null($data) || empty($data) ){

		$cache_time_minutes = defined('WPINSTAGRAM_CACHE_TIME') ? WPINSTAGRAM_CACHE_TIME : 10;

		if( $cache_time_minutes < 1 ){
			$cache_time_minutes = 10;
		}

		$cache_time = $cache_time_minutes * 60;

		return wpinstagram_cache_set( $key , InstagramCrawler::get($username), $cache_time );
	}

	return $data;
}