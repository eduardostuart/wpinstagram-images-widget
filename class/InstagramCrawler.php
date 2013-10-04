<?php

class InstagramCrawler{

	const USERAGENT       = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36';
	const INSTAGRAM_URL   = 'http://instagram.com/';


	public static function get( $username ){

		if( empty($username) ){
			return;
		}

		$url       = self::INSTAGRAM_URL . $username;

		$Instagram = new static;
		$data      = $Instagram->request( $url );
		$parsed    = $Instagram->parse( $data );

		return $parsed;
	}


	protected function request( $url ){

		$response = null;

		$ch = curl_init();
		if( $ch ){

			$options[CURLOPT_URL]            = $url;
			$options[CURLOPT_RETURNTRANSFER] = true;
			$options[CURLOPT_HEADER]         = false;
			$options[CURLOPT_USERAGENT]      = self::USERAGENT;

			curl_setopt_array($ch, $options);
			$response = curl_exec($ch);
			curl_close($ch);
		}

		return $response;
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


}