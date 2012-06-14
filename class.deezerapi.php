<?php


class deezerapi {

	public $config = array(
			'app_id' 		=> "YOUR_APP_ID",
			'app_secret' 	=> "YOUR_APP_SECRET",
			'my_url'     	=> "YOUR_CALLBACK_URL"
		);

	private $apiurl = 'http://api.deezer.com/2.0/';

	public $access_token = '';
	
	public function __construct( $config = array() ){

		// surcharge config si present
		if (!empty($config)) {
			$this->config = $config;
		}

	}


	// public function track( $id ) {

	//    if (!is_numeric($id)) {
	// 		throw new Exception("Bad ",1);
	// 	}

	// 	$params = array();

	// 	return $this->_callMethod('track/'.$id, $params, 'get');

	// }

	// public function artist( $id ) {

	//    	if (!is_numeric($id)) {
	// 		throw new Exception("Bad data",1);
	// 	}

	// 	$params = array();

	// 	return $this->_callMethod('artist/'.$id, $params, 'get');

	// }

	public function postAlbumComment($album_id, $comment) {
	
	   	if (!is_numeric($album_id)) {
			throw new Exception("Bad data",1);
		}

		// Sanitize string
		$comment = strip_tags($comment);
		$comment = filter_var($comment, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

		$params = array("comment" => $comment);

		return $this->_callMethod('album/'.$album_id.'/comments', $params, 'post');
	}

	// public function playlist($id){

	// 	if (!is_numeric($id)) {
	// 		throw new Exception("Bad data",1);
	// 	}

	// 	$params = array();

	// 	return $this->_callMethod('playlist/'.$id, $params, 'get');
	
	// }

	// public function album( $id ) {

	//    	if (!is_numeric($id)) {
	// 		throw new Exception("Bad data",1);
	// 	}

	// 	$params = array();

	// 	return $this->_callMethod('album/'.$id, $params, 'get');

	// }

	public function __call( $method, $args ){

	   	if (!is_numeric($id)) {
			throw new Exception("Bad data",1);
		}

		$authorized_method = array(
			"track",
			"album",
			"playlist"
		);
		if(!in_array($method, $authorized_method)){
			throw new Exception("Unauthorized method", 1);	
		}

		$id = $args[0];
		$params = array();

		return $this->_callMethod($method'/'.$id, $params, 'get');

	}

	public function getFolder(){}

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

		if($type == 'get'){
			/* GET METHOD */
			$result = json_decode(file_get_contents($this->apiurl.$method));
		
		}else{
			/* POST METHOD */

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

			curl_setopt($ch,CURLOPT_URL,$this->apiurl.$method);
			curl_setopt($ch,CURLOPT_POST, count($params)+1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$params_post);

			$result = json_decode(curl_exec($ch));

			curl_close($ch);
		}

		return $result;

	}


}

?>