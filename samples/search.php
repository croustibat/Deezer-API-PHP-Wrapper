<?php 
// We need to be auth for search

require '../class.deezerapi.php';

// get your config data by creating a project here :
// http://developers.deezer.com/myapps 
$config = array(
        "app_id"        => YOUR_APP_ID,
        "app_secret"    => "YOUR_SECRET_KEY",
        "my_url"        => "http://YOUR_DOMAIN" //you must specify the same domain as in your apps (it could be localhost)
);

$dz = new deezerapi();


// Pass token after Oauth login
// see doc here : http://developers.deezer.com/api/oauth
$dz->setToken("YOUR ACCESS TOKEN");



/* SEARCH AN ARTIST */
$term = 'weezer'; // term to search on
$context = ''; // by default search by artist
$orderby = 'RANKING'; 

$searchDataArtist = $dz->search($term, $context, $orderby);
 



/* SEARCH AN ALBUM */
$term = 'war on errorism'; // term to search on
$context = 'album';
$orderby = 'RANKING'; 

$searchDataAlbum = $dz->search($term, $context, $orderby);