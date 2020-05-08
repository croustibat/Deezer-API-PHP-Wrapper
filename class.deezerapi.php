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

	private $apiurl = 'https://api.deezer.com/';

	public $access_token = '';
	
	public $output_format = 'array'; // set to json to get json string 
	
	public function __construct( $config = array() ){

		// override config
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

		$params = array();

		if (!preg_match('/(get|set|delete)(.*)/',$method, $matches)) {
			throw new Exception("Looks like you call inexisting method", 1);				
		}

		$type 	= strtolower($matches[1]);
		$method = strtolower($matches[2]);

		if ( $type == 'get') {

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

			if (!in_array($method, $authorized_method)) {
				throw new Exception("Unauthorized method", 1);	
			}
			
			if ($method == 'user') {
				$method = 'user/me';
			}

			$params = array();

			if (!empty($args)) {
				
				$id = array_shift($args);
					
			   	if (empty($id)) {
					throw new Exception("Bad request",1);
				}

				$connection = array_shift($args);

				if ($connection) {
					$ressource = $method.'/'.$id.'/'.$connection;
				}
				else {
					$ressource = $method.'/'.$id;
				}
			
			}
			else {
				$ressource = $method;
			}

			return $this->_callMethod($ressource, $params, 'get');
		}
		elseif ($type == 'set') {
			
			$id = array_shift($args);
			$context = array_shift($args);
			$content = array_shift($args);
			
			return $this->_add($method, $id, $context, $content);
		}
		elseif ($type == 'delete') {

			$id = array_shift($args);

			return $this->_callMethod($method.'/'.$id, $params, 'delete');
		}
	}

	public function setToken($access_token){

		if (!isset($access_token) || empty($access_token)) {
			throw new Exception("Invalid access token", 1);
		}

		$this->access_token = $access_token;

		return true;
	}

	public function getToken(){

		if ($this->access_token) {
			return $this->access_token;
		}else{
			return false;
		}
	}

	public function addFolder($title){

		$title = strip_tags($title);
		
		if (empty($title)) {
			throw new Exception("You must provide a valid title.", 1);
		}

		return $this->_add('user/me/folders', null, "title", $title);	
	}

	public function getFolder($id = null, $context = null) {
		if ($id && is_numeric($id)) {
			if ($context) {
				return $this->_callMethod('folder/'.$id.'/items', array(), 'get');
			}
			else{
				return $this->_callMethod('folder/'.$id, array(), 'get');
			}
		}
		else{
			return $this->_callMethod('user/me/folders', array(), 'get');
		}
	}


	public function addPlaylist($title){

		$title = strip_tags($title);
		
		if (empty($title)) {
			throw new Exception("You must provide a valid title.", 1);
		}

		return $this->_add('user/me/playlists', null, "title", $title);	
	}

	public function getPlaylist($id = null, $context = null) {
		if ($id && is_numeric($id)) {
			if ($context) {
				return $this->_callMethod('playlist/'.$id.'/'.$context, array(), 'get');
			}
			else{
				return $this->_callMethod('playlist/'.$id, array(), 'get');
			}
		}
		else{
			return $this->_callMethod('user/me/playlists', array(), 'get');
		}
	}

	public function getUser($context = null) {
		if ($context) {
			return $this->_callMethod('user/me/'.$context, array(), 'get');
		}
		else{
			return $this->_callMethod('user/me', array(), 'get');
		}
	}
	
	/* Private function to add, create element in Deezer API*/
	private final function _add($type, $id=null, $context=null, $content=null) {
		
		$params = array();
		$result = false;

		if ($id == null) {

			if (isset($context) && isset($content)) {
				$content = strip_tags($content);
				$params  = array("$context" => $content);
			}
			$result = $this->_callMethod($type, $params, 'post');	

		}
		elseif (isset($id) && isset($context) && isset($content)) {

			if (is_array($content)) {
				$params = $content;
			} else {
				$content = strip_tags($content);
				$params  = array("$context" => $content);
			} 
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

		$token = $this->getToken();

		switch ($type) {

			case 'get':

				$url = $this->apiurl.$method;
				if ($token) {
					$url .= "?access_token=".$token;
				}
				if ($this->output_format == 'json') {

					$result = file_get_contents($url);
				}
				else {
					$result = json_decode(file_get_contents($url));	
				}
			break;

			case 'post':

				$params_post = '';
				foreach($params as $key => $value) { 
					$params_post .= $key.'='.$value.'&'; 
				}

				// token is not required for search
				if (strpos($method, 'search') === false) {
					if ($token === false) {
						throw new Exception("Token error", 1);
					} else {
						$params_post .= "access_token=".$token;
					}
				}
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $this->apiurl.$method);
				curl_setopt($ch, CURLOPT_POST, count($params)+1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$params_post);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				if ($this->output_format == 'json') {
					$result = curl_exec($ch);
				}
				else {
					$result = json_decode(curl_exec($ch));
				}

				curl_close($ch);

			break;

			case 'delete':

				if ($token === false) {
					throw new Exception("Token error", 1);
				}

				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $this->apiurl.$method."?access_token=".$token);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				
				if ($this->output_format == 'json') {
					$result = curl_exec($ch);
				}
				else {
					$result = json_decode(curl_exec($ch));
				}
				curl_close($ch);	 	

			break;
		}

		return $result;

	}


} //end of class deezerapi
