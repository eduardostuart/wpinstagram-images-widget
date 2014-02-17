<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class InstagramCrawler{

	const INSTAGRAM_URL   = 'http://instagram.com/';

	public static function get( $username ){

		$username = preg_replace('/[@\s]/','',$username);

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

		$script  = null;
		$images  = array();
		$scripts = $html->find('script');

		if( sizeof( $scripts) > 0 ){
			foreach( $scripts as $item){

				if(!is_null($script)) break;

			
				if( preg_match("/(window\.(_jscalls|_sharedData))/i",$item->innertext) ){
					$script = $item->innertext;
					break;
				}
			}
		}


		if( !is_null($script) ){


			preg_match_all('/(window\._(sharedData|jscall)[\s=]+[^{\"](.*?\})(\;))/isU',$script,$matches);

			$data  = isset($matches[3][0]) ? $matches[3][0] : null;

			if( !is_null($data) ){

				$results  = json_decode($data,true);

				if(json_last_error() !== JSON_ERROR_NONE){
					return;
				}

				if(!isset($results['entry_data']['UserProfile'][0])){
					return;
				}

				$userProfile = $results['entry_data']['UserProfile'][0];

				if(!isset($userProfile['userMedia'])){
					return;
				}

				$userMedia = $userProfile['userMedia'];


				if(isset($userMedia) && is_array($userMedia)){
					foreach( $userMedia as $current=>$result ) {

						if($current > 5) break;

						$caption      = $result['caption'];
						$image        = $result['images']['standard_resolution'];
						$id           = $result['id'];
						$image        = $image['url'];
						$link         = $result['link'];
						$created_time = $caption['created_time'];
						$text         = $caption['text'];

						$filename_data= explode('.',$image);

						if( is_array($filename_data) ){

							$fileformat   = end( $filename_data );

							if( $fileformat !== false ){
								$image = $this->download_image($image , md5($id) . '.' . $fileformat );

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