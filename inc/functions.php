<?php


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

	if( is_null($data) ){
		return wpinstagram_cache_set( $key , InstagramCrawler::get($username) );
	}

	return $data;
}