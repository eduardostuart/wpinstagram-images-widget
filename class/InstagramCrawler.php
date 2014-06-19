<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class InstagramCrawler {

	const INSTAGRAM_URL   = 'http://instagram.com/';

	const MAX_IMAGES = 10;

	public static $default = array(
		'caption' => array(
			'created_time' => null,
			'text' => null
		),
		'images' => array(
			'standard_resolution' => array(
				'url' => null
			)
		),
		'id'  => null,
		'link'=> null,
		'created_time' => null,
		'text' => null
	);

	public static function get( $username )
	{

		$username = preg_replace('/[@\s]/','',$username);

		if( empty($username) )
		{
			return null;
		}

		$cacheKey = 'wpi_' . $username;

		$data = WPICache::get( $cacheKey );

		if( !is_null( $data) && !empty($data) )
		{
			return $data;
		}

		$instance = new static;

		try
		{

			$data = $instance->request( self::INSTAGRAM_URL . $username );

			if( is_null($data) )
			{
				return null;
			}

			$parsed = $instance->parse( $data );

			WPICache::set( $cacheKey , $parsed , WPINSTAGRAM_CACHE_TIME );

			return $parsed;

		}catch( WPICouldNotParse $e )
		{
			return null;
		}
	}

	public function isValidJSON( $string )
	{
		@json_decode( $string  );

		if( @json_last_error() !== JSON_ERROR_NONE){
			return false;
		}

		return true;
	}


	protected function request( $url )
	{

		$response = wp_remote_get( $url,
			array(
				'timeout' => 60
			)
		);

		if( $response['response']['code'] === 200 ){
			return $response['body'];
		}

		return null;
	}

	private function parse( $htmlcode )
	{

		$html    = str_get_html( $htmlcode );

		$script  = null;
		$scripts = $html->find('script');

		if( sizeof( $scripts) < 1 )
		{
			throw new WPICouldNotParse(__('Could not parse', WPINSTAGRAM_TXT_DOMAIN ) );
		}

		foreach( $scripts as $item )
		{
			if(!is_null($script)) break;

			if( preg_match("/(window\.(_jscalls|_sharedData))/i",$item->innertext) )
			{
				$script = $item->innertext;
				break;
			}
		}

		if( $script === null ){
			throw new WPICouldNotParse( __('Could not parse',WPINSTAGRAM_TXT_DOMAIN));
		}

		preg_match_all('/(window\._(sharedData|jscall)[\s=]+[^{\"](.*?\})(\;))/isU',$script,$matches);

		$data  = isset( $matches[3][0] ) ? $matches[3][0] : null;

		if( is_null( $data ) )
		{
			return null;
		}

	 	if( $this->isValidJSON( $data ) !== true )
	 	{
	 		throw new WPICouldNotParse( __('Could not parse - Invalid JSON', WPINSTAGRAM_TXT_DOMAIN ));
	 	}

	 	$userData = json_decode( $data , true );

	 	if( ( $images = $this->parseResult( $userData ) ) !== null )
	 	{
	 		return $images;
	 	}

		return null;
	}

	private function parseResult( $userData )
	{

		if(! isset($userData['entry_data']['UserProfile'][0]) )
		{
			return null;
		}

		$userProfile = $userData['entry_data']['UserProfile'][0];

		if( !isset($userProfile['userMedia']) )
		{
			return null;
		}

		$userMedia = $userProfile['userMedia'];

		if( !isset($userMedia) || !is_array($userMedia) )
		{
			return null;
		}

		$images = array();

		foreach( $userMedia as $current => $result )
		{

			if( $current > WPINSTAGRAM_MAX_IMAGES ) break;

			$result = array_merge( self::$default, $result );

			if( $result['images']['standard_resolution'] === null )
			{
				continue;
			}

			$caption      = $result['caption'];
			$createdTime  = $caption['created_time'];
			$captionText  = $caption['text'];

			$imageUrl     = $result['images']['standard_resolution']['url'];

			$id           = $result['id'];
			$link         = $result['link'];

			$fileName     = strtolower( substr( strrchr( $imageUrl , '/' ) , 1 ) );
			$fileExt      = strtolower( substr( strrchr( $fileName , '.' ) , 1 ) );

			$file         = md5($id) . '.' . $fileExt;

			try
			{

				$downloadImage = WPIImageDownload::save( $imageUrl , WPINSTAGRAM_PATH_CACHE ,  $file );

				array_push( $images ,
					array(
						'id'          => $id,
						'created_time'=> $createdTime,
						'text'        => $captionText,
						'image'       => $downloadImage->name,
						'link'        => $link
					)
				);


			}catch( WPICouldNotCreateImageDirectoryException $e )
			{
				return null;

			}catch( WPICouldNotCreateLocalImageException $e )
			{
				return null;
			}
		}

		return $images;
	}



}