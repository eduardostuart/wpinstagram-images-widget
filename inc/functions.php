<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function wpinstagram_cache_set( $key, $values , $lifetime = 300 )
{
	return WPICache::set( $key , $value , $lifetime );
}


function wpinstagram_cache_get( $key )
{
	return WPICache::get( $key );
}

function wpinstagram_widget_content( $username )
{
	return InstagramCrawler::get( $username );
}