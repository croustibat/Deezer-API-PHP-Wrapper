<?php

// do not need an APP ID or access token for that

require '../class.deezerapi.php';

$dz = new deezerapi();

$trackData = $dz->getTrack(3135556); 

print_r($trackData);