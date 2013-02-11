<?php

include "../class.deezerapi.php"; 

// INSTANCIATE DEEZER API CLASS
$dzapi = new deezerapi(array(
	'app_id'		=> "my_app_id",
	'app_secret' 	=> "my_app_secret",
	'my_url' 		=> "http://example.com"
));

// ACCESS TOKEN 
/*
 * Access token is useful when you need to push or delete stuff on behalf of user
 * Most of the time you get an access token using the JS SDK - see here : http://developers.deezer.com/sdk/javascript
 * Also you must ask for the good permission - see here : http://developers.deezer.com/api/permissions
 */
$access_token = "YOU_SHOULD_PROVIDE_A_VALID_ACCESS_TOKEN";
$dzapi->setToken($access_token);

// CREATE A FOLDER 
$dzfolder 	= $dzapi->addFolder("IMPORT_ITUNE");
$folder_id 	= $dzfolder->id;


// CREATE PLAYLIST
$dz_playlist = $dzapi->addPlaylist("PLAYLIST_NAME");
$playlist_id = $dz_playlist->id;

// MOVE PLAYLIST TO FOLDER
$dzapi->setFolder($folder_id, 'items', array('playlist_id' => $playlist_id));

//ADD TRACKS TO PLAYLIST

$array_of_tracks = array(3135556); // Here we add only one track. You could add until 400 tracks per playlist (deezer's limit)
$dzapi->setPlaylist($playlist_id, 'tracks', array('songs' => implode(',', $array_of_tracks)));

// That's it !