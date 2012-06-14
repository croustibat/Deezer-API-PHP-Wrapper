<?php


class deezerapi {

	public $config = array(
			'app_id' 		=> "YOUR_APP_ID",
			'app_secret' 	=> "YOUR_APP_SECRET",
			'my_url'     	=> "YOUR_CALLBACK_URL"
		);
	
	public function __construct( $config = array() ){

		// surcharge config si present
		if (!empty($config)) {
			$this->config = $config;
		}

	}


	public function getTrack(){}

	public function getPlaylist(){}

	public function getAlbum(){}

	public function getFolder(){}

	private final function call_method($method, $params = array()){

		if(!isset($method) || empty($method)){
			throw new Exception("Error Method isn't set or is empty", 1);
		}



	}

}

?>