<?php

// Helper function for dropdownArtists

function checkImageURL($array, $x) {
	if(isset($array[$x]["url"]))
    		return $array[$x]["url"];
    	else
    		return "";
}

// Pass in artist name you'd like dropdown for
// Function will return in the following format (max 5 artists):

/*
	Artist Name: Drake
	Image URL: https://i.scdn.co/image/cb080366dc8af1fe4dc90c4b9959794794884c66

	Artist Name: Drake
	Image URL: https://i.scdn.co/image/f4a465c6022a30ee187452f7923e509d480c4c1a

	Artist Name: Drake White
	Image URL: https://i.scdn.co/image/8b7d34461462466d5a5b32d9d7a3a94729767c13

	Artist Name: Nick Drake
	Image URL: https://i.scdn.co/image/267080662cf3c019ea8020a4e0e8dd5a7be4d909

	Artist Name: Drake Bell
	Image URL: 

*/

function dropdownArtists($aname) {

	$content = file_get_contents("https://api.spotify.com/v1/search?q=" . $aname . "&type=artist&limit=5");
	$data=json_decode($content, true);
	
	foreach($data["artists"]["items"] as $x => $x_value) {
    	echo "Artist Name: " . $data["artists"]["items"][$x]["name"];
    	echo "<br>";
    	echo "Image URL: " . checkImageURL($data["artists"]["items"][$x]["images"], $x);
    	echo "<br>";
    	echo "<br>";
	}

}

?>