<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class InstagramCrawler{

	const INSTAGRAM_URL   = 'http://instagram.com/';

	public static function get( $username ){

		if( empty($username) ){
			return;
		}

		$url       = self::INSTAGRAM_URL . $username;

		$Instagram = new static;
		$data      = $Instagram->request( $url );

		$parsed = array();
		if( !is_null($data)){
			$parsed  = $Instagram->parse( $data );
		}

		return $parsed;
	}


	protected function request( $url ){

		$response = wp_remote_get($url,array('timeout'=>60));

		if( $response['response']['code'] === 200 ){
			return $response['body'];
		}

		return null;
	}

	private function parse( $htmlcode ){
		$html = str_get_html( $htmlcode );

		$script = null;
		$images = array();

		foreach ($html->find('script') as $item) {

			if(!is_null($script)) break;

			if( preg_match("#(window\._jscalls)#i",$item->innertext) ){
				$script = $item->innertext;
			}
		}


		if( !is_null($script) ){

			preg_match_all("#(\"userMedia\"\:)(\[)(.*?)(\]\,\"prerelease\")#isU",$script,$matches);

			$data  = isset($matches[3][0]) ? $matches[3][0] : null;

			if( !is_null($data) ){

				$results_json = "[".$data."]";
				$results      = json_decode($results_json,true);

				if(json_last_error() !== JSON_ERROR_NONE){
					return;
				}

				if(is_array($results)){
					foreach ($results as $current=>$result) {

						if($current > 5) break;

						$caption      = $result['caption'];
						$image        = $result['images']['standard_resolution'];
						$id           = $result['id'];
						$image        = $image['url'];
						$link         = $result['link'];
						$created_time = $caption['created_time'];
						$text         = $caption['text'];

						$fileformat   = end(explode('.',$image));
						$image        = $this->download_image($image , md5($id) . '.' . $fileformat );

						array_push($images, array(
							'id'          => $id,
							'created_time'=> $created_time,
							'text'        => $text,
							'image'       => $image,
							'link'        => $link
						));
					}
				}
			}
		}

		return $images;
	}

	private function download_image( $url , $file ){

		wp_mkdir_p( WPINSTAGRAM_PATH_CACHE );

		$filename  = WPINSTAGRAM_PATH_CACHE . $file;

		if(file_exists($filename)){
			return $file;
		}

		$get       = wp_remote_get( $url );
		$body      = wp_remote_retrieve_body( $get );

		$fp = @fopen( $filename , 'wb');
		if($fp){
			fwrite($fp,$body);
			fclose($fp);
			clearstatcache();

			return $file;
		}

		return $url;
	}


}