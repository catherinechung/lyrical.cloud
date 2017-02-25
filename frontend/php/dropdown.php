<?php

// Helper functions for dropdownArtists

function checkImageURL($array, $x) {
	if(isset($array[$x]["images"][$x]["url"]))
    		return $array[$x]["images"][$x]["url"];
    	else
    		return "";
}

function checkArtistName($array, $x) {
	if(isset($array[$x]["name"]))
    		return $array[$x]["name"];
    	else
    		return "";
}

function checkArtistID($array, $x) {
	if(isset($array[$x]["id"]))
    		return $array[$x]["id"];
    	else
    		return "";
}

// Pass in artist name you'd like dropdown for
// Function will return JSON with the following format (max 5 artists):

/*
	( [name] => Array ( [0] => Drake 
						[1] => Drake 
						[2] => Drake White 
						[3] => Nick Drake 
						[4] => Drake Bell ) 
	  [image] => Array ( [0] => https://i.scdn.co/image/cb080366dc8af1fe4dc90c4b9959794794884c66 
	  					 [1] => https://i.scdn.co/image/f4a465c6022a30ee187452f7923e509d480c4c1a 
	  					 [2] => https://i.scdn.co/image/8b7d34461462466d5a5b32d9d7a3a94729767c13 
	  					 [3] => https://i.scdn.co/image/267080662cf3c019ea8020a4e0e8dd5a7be4d909 
	  					 [4] => ) 
	 )

*/

function dropdownArtists($aname) {

	$content = file_get_contents("https://api.spotify.com/v1/search?q=" . $aname . "&type=artist&limit=5");
	$array=json_decode($content, true);

	$rtrnJSON = new stdClass();
	$rtrnJSON->name= array(checkArtistName($array["artists"]["items"], 0),
						   checkArtistName($array["artists"]["items"], 1),
						   checkArtistName($array["artists"]["items"], 2),
						   checkArtistName($array["artists"]["items"], 3),
						   checkArtistName($array["artists"]["items"], 4));
	$rtrnJSON->artistid= array(checkArtistID($array["artists"]["items"], 0),
						   	   checkArtistID($array["artists"]["items"], 1),
						   	   checkArtistID($array["artists"]["items"], 2),
						       checkArtistID($array["artists"]["items"], 3),
						       checkArtistID($array["artists"]["items"], 4));
	$rtrnJSON->image= array(checkImageURL($array["artists"]["items"], 0),
						    checkImageURL($array["artists"]["items"], 1),
						    checkImageURL($array["artists"]["items"], 2),
						    checkImageURL($array["artists"]["items"], 3),
						    checkImageURL($array["artists"]["items"], 4));
	print_r($rtrnJSON);
	return $rtrnJSON;

}

dropdownArtists("drake");

?>