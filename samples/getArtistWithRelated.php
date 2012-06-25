<?php
// do not need an APP ID or access token for that

require '../class.deezerapi.php';

$artist_id = $_GET['artist_id']; // script is called with artist id args 

$dz = new deezerapi();

$artist = $dz->getArtist($artist_id); // main artist

$related = $dz->getArtist($artist_id, 'related'); // here we fetch the related artists 

$result = array_unshift($related->data, $artist); // merge array so we can have one array with main artist at the top

echo json_encode($related->data); // return json encoded array for ajax call by example
