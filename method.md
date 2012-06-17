Album Method
============

Global function :

`getAlbum($id, $connection)`
 $id => Album id (int)
 $connection => String of connection (tracks, fans, comments)

`getAlbum($id)` : Get metadata from album 
 $id => Album id (int)

getAlbum($id, 'tracks') : Get list of tracks from album
 $id =>  Album id (int)

getAlbum($id, 'fans') : Get fans from album
 $id =>  Album id (int)

getAlbum($id, 'comments') : Get comments from album
 $id =>  Album id (int)

setAlbum($id, 'comments', $value) : Add comment
 $id => Album id (int)
 $value => Comment (string)

Artist Method
=============

Global function :

getArtist($id, $connection)
 $id => Artist id (int)
 $connection => String of connection (top, albums, fans, comments, related, radio)

getArtist($id) : Get data from artist 
 $id => Artist id (int)

getArtist($id, 'top') : Get top tracks from artist
 $id =>  Artist id (int)

getArtist($id, 'albums') : Get list of albums from artist
 $id =>  Artist id (int)

getArtist($id, 'fans') : Get fans from artist
 $id =>  Artist id (int)

getArtist($id, 'comments') : Get comments from artist
 $id =>  Artist id (int)

getArtist($id, 'related') : Get related artist 
 $id =>  Artist id (int)

getArtist($id, 'radio') : Get a smartradio from artist
 $id =>  Artist id (int)

setArtist($id, 'comments', $value) : Add comment
 $id => Artist id (int)
 $value => Comment (string)

Comments Method
===============

getComment($id) : Get comment data
 $id => comment id (int)

Editorial Method
================

Notice : all editorial methods are geolocalised by country

getEditorial() : get List of editorial genre 

getEditorial($id) : get data of editorial genre
 $id => editorial id (int)

getEditorial($id, 'selection') : get list of album of editorial selection from genre
 $id => editorial id (int)

getEditorial($id, 'charts') : get list of top charts (tracks, albums, artists) of editorial selection from genre
 $id => editorial id (int)

Folder Method
=============

Notice : To access this method, you should have a valid access token 

getFolder() : get list of user folder

getFolder($id) : get data of selected folder
 Permission : basic_access
 $id => folder id (int) (existing folder id)

addFolder($title) : Add new folder
 return : folder id
 Permission : manage_library
 $title => title of folder (string)

deleteFolder($id) : Delete folder
 Permission : delete_library
 $id => folder id

getFolder($id, 'items') : get list albums or playlist in the user folder
 Permission : basic_access
 $id => folder id

Genre Method
============

 Notice : all genre methods are geolocalised by country

 getGenre : get list of genre

 getGenre($id) : get data of selected genre
 $id => genre id

 getGenre($id, 'artist') : get list of artist for selected genre
 $id => genre id

Playlist Method
===============

Notice : To access this method, you should have a valid access token 

 getPlaylist() : get list of playlists for user

 getPlaylist($id) : get list of tracks of selected playlist & data of playlist
 $id = playlist id (int)

 addPlaylist($title) : add Playlist in user account
 Permission : manage_library
 $title => title of playlist (string)
 
 deletePlaylist($id) : delete selected playlist
 Permission : delete_library
 $id => playlist id (int)

 getPlaylist($id, 'comments') : get list of comments
 $id => playlist id (int)

 getPlaylist($id, 'fans') : get list of fans
 $id => playlist id (int)

 getPlaylist($id, 'tracks') : get list of tracks
 $id => playlist id (int)

 setPlaylist($id, 'comments', $value) : Add comment 
 $id => playlist id (int)
 a$value => comment (string)

Radio Method
============
 
 getRadio() : get list of radio (geolocated)

 getRadio($id) : get data of radio
 $id => radio id (int)

 getRadio('genres') : get list of radio by genre
 getRadio('top') : get top of radios

 getRadio($id, 'tracks') : get list of tracks by selected radios
 $id => radio id (int)

Search Method :

 search($query, $context, $order) : search in deezer database
 $query = query string 
 $context =  type of context 'album' or 'artist' (string)
 $order => type of order (RANKING, TRACK_ASC, TRACK_DESC, ARTIST_ASC, ARTIST_DESC, ALBUM_ASC, ALBUM_DESC, RATING_ASC, RATING_DESC, DURATION_ASC, DURATION_DESC) default : RANKING (popularity)

 return list of tracks





