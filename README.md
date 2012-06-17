Deezer-API-PHP-Wrapper
======================

Simple wrapper of the Deezer Open API for PHP

[See the original documentation on the Deezer API](http://developers.deezer.com)

How to use the wrapper
---------------------

Download or fork this project. Then just require the class.deezerapi.php in your project and start use it like that :

`require 'class.deezerapi.php';

$config = array(
        "app_id"        => YOUR API KEY,
        "app_secret"    => YOUR SECRET KEY,
        "my_url"        => YOUR DOMAIN NAME or localhost
);

$dz = new deezerapi($config);`


You should also read the method.md file to see what you can do with the wrapper. 

Sources
---------------------
[Deezer API doc](http://developers.deezer.com)
