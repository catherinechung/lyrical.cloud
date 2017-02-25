<?php

function getSongsFromAlbum($albumID) {
	$content = file_get_contents("https://api.spotify.com/v1/albums/" . $albumID . "/tracks");
	$data=json_decode($content, true);

	print_r($data);
}

function getSongs($artistID) {

	$content = file_get_contents("https://api.spotify.com/v1/artists/" . $artistID . "/albums");
	$data=json_decode($content, true);

	$albums = array();
	$name = array();

	foreach($data["items"] as $x => $x_value) {
     	$albums[] = $data["items"][$x]["id"];
 	}

 	getSongsFromAlbum($albums[0]);

}

getSongs("3TVXtAsR1Inumwj472S9r4");

?>