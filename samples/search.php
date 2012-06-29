<?php 
require '../class.deezerapi.php';

$dz = new deezerapi();

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