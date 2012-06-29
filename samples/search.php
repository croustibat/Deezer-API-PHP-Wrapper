<?php 
require '../class.deezerapi.php';

$dz = new deezerapi();

/* SEARCH TRACKS */
$term = 'weezer'; // term to search on
$context = ''; // by default search title
$orderby = 'RANKING'; 

$searchDataArtist = $dz->search($term, $context, $orderby);
 

/* SEARCH ARTIST */
$term = 'weezer'; // term to search on
$context = 'artist'; // by default search title
$orderby = 'RANKING'; 

$searchDataArtist = $dz->search($term, $context, $orderby);
 

/* SEARCH ALBUM */
$term = 'war on errorism'; // term to search on
$context = 'album';
$orderby = 'RANKING'; 

$searchDataAlbum = $dz->search($term, $context, $orderby);