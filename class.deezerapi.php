<?php


class deezerapi {

	public $config = array(
			'app_id' 		=> "YOUR_APP_ID",
			'app_secret' 	=> "YOUR_APP_SECRET",
			'my_url'     	=> "YOUR_CALLBACK_URL"
		);

	private $apiurl = 'http://api.deezer.com/2.0/';
	
	public function __construct( $config = array() ){

		// surcharge config si present
		if (!empty($config)) {
			$this->config = $config;
		}

	}


	public function getTrack( $id ) {

	   if (!is_numeric($id)) {
			throw new Exception("Bad ",1);
		}

		$params = array('id' => $id);

		$this->_callMethod('track',$params);

	}

	public function getPlaylist(){}

	public function getAlbum(){}

	public function getFolder(){}

	private final function _callMethod( $method, $params ){

		if(!isset($method) || empty($method)){
			throw new Exception("Error Method isn't set or is empty", 1);
		}

		if(!isset($params) || !is_array($params)){
			throw new Exception("Error Param isn't set or is empty", 1);
		}

		$params_post = '';
		foreach($params as $key => $value) { 
			$params_post .= $key.'='.$value.'&'; 
		}

		$params_post .= "request_method=get";


			$ch = curl_init();

			curl_setopt($ch,CURLOPT_URL,$this->apiurl.$method);
			curl_setopt($ch,CURLOPT_POST, count($params)+1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$params_post);

			$result = curl_exec($ch);

			curl_close($ch);
	

		return $result;

	}

}

?>