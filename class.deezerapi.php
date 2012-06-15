<?php

/*
Deezer API Wrapper - PHP
http://developers.deezer.com/

Created at 14-06-2012 on MusicHackDay BCN

* Baptiste Bouillot : http://twitter.com/bbbaptiste 
* Aurelien Herault : http://twitter.com/dokydeezer

Deezer API Documentation & SDK:
http://developers.deezer.com/api

*/

class deezerapi {

	public $config = array(
			'app_id'		=> "YOUR_APP_ID",
			'app_secret' 	=> "YOUR_APP_SECRET",
			'my_url' 		=> "YOUR_CALLBACK_URL"
		);

	private $apiurl = 'http://api.deezer.com/2.0/';

	public $access_token = '';
	
	public function __construct( $config = array() ){

		// surcharge config si present
		if (!empty($config)) {
			$this->config = $config;
		}

	}

	public function search($term, $context = '', $order = 'RANKING') {
		$order_available = "RANKING, TRACK_ASC, TRACK_DESC, ARTIST_ASC, ARTIST_DESC, ALBUM_ASC, ALBUM_DESC, RATING_ASC, RATING_DESC, DURATION_ASC, DURATION_DESC";
		
		// force order if not in list
		if (substr_count($order, $order_available) == 0) {
			$order = 'RANKING';
		}

		$params = array(
			'q' => $term,
			'order' => $order,
			'request_method' => 'get'
		);

		if ($context) {
			$ressource = "search/$context";
		}
		else{
			$ressource = "search";
		}
		return $this->_callMethod($ressource, $params, 'post');		
	}

	/**
	 * Use for get method only
	 * 
	 */
	public function __call($method, $args){

		$authorized_method = array(
			"track",
			"album",
			"playlist",
			"artist",
			"comment",
			"editorial",
			"folder",
			"genre",
			"radio", 
			"user"
		);
		if(!in_array($method, $authorized_method)){
			throw new Exception("Unauthorized method", 1);	
		}

		$params = array();

		if (!empty($args)) {
			
			$id = array_shift($args);
			
		   	if (!is_numeric($id)) {
				throw new Exception("Bad data",1);
			}
			
			$params = $args; //put the rest of array even if empty
			$ressource = $method.'/'.$id;
		
		}
		else{
			$ressource = $method;
		}

		return $this->_callMethod($ressource, $params, 'get');

	}

	public function setToken($access_token){

		if(!isset($access_token) || empty($access_token)){
			throw new Exception("Invalid access token", 1);
		}

		$this->access_token = $access_token;

		return true;
	}

	public function getToken(){

		if($this->access_token){
			return $this->access_token;
		}else{
			return false;
		}
	}

	/* Private function to add, create element in Deezer API*/
	private final function _add($type, $id=null, $context=null, $content=null) {
		
		$params = array();
		$result = false;

		if ($id == null){

			$result = $this->_callMethod($type, $params, 'post');	

		}elseif( isset($id) && isset($context) && isset($content) ){

			$content = strip_tags($content);
			$params  = array("$context" => $content);
			$result  = $this->_callMethod($type.'/'.$id.'/'.$context, $params, 'post');
			
		}

		return $result;

	}

	/* Private function to call Deezer API with cURL */
	private final function _callMethod( $method, $params, $type ){

		if(!isset($method) || empty($method)){
			throw new Exception("Error Method isn't set or is empty", 1);
		}

		if(!isset($params) || !is_array($params)){
			throw new Exception("Error Param isn't set or is empty", 1);
		}

		if(!isset($type)){
			throw new Exception("Error Type isn't set", 1);
		}

		switch($type){

			case 'get':
				$result = json_decode(file_get_contents($this->apiurl.$method));	
			break;

			case 'post':

				$token = $this->getToken();

				if($token == false){
					throw new Exception("Token error", 1);
				}

				$params_post = '';
				foreach($params as $key => $value) { 
					$params_post .= $key.'='.$value.'&'; 
				}

				$params_post .= "access_token=".$token;


				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $this->apiurl.$method);
				curl_setopt($ch, CURLOPT_POST, count($params)+1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$params_post);

				$result = json_decode(curl_exec($ch));

				curl_close($ch);

			break;

			case 'delete':

				$token = $this->getToken();

				if($token == false){
					throw new Exception("Token error", 1);
				}


				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL,$this->apiurl.$method);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

				$result = json_decode(curl_exec($ch));

				curl_close($ch);	 	

			break;
		}

		return $result;

	}


}

?>