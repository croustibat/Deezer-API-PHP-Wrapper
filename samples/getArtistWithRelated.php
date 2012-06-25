<?php
require 'class.deezerapi.php';

// get your config data by creating a project here :
// http://developers.deezer.com/myapps 
$config = array(
        "app_id"        => YOUR_APP_ID,
        "app_secret"    => "YOUR_SECRET_KEY",
        "my_url"        => "http://YOUR_DOMAIN" //you must specify the same domain as in your apps (it could be localhost)
);

$artist_id = $_GET['artist_id']; // script is called with artist id args 

$dz = new deezerapi($config);
$artist = $dz->getArtist($artist_id); // main artist

$related = $dz->getArtist($artist_id, 'related'); // here we fetch the related artists 

$result = array_unshift($related->data, $artist); // merge array so we can have one array with main artist at the top

echo json_encode($related->data); // return json encoded array for ajax call by example
