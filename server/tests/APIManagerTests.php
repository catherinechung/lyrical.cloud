<?php

use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../src/CacheManager.php');
/*
 * @covers APIManager Class Methods
 */
final class APIManagerTests extends TestCase {

	// Test get_songs($artist) function
	public function testGetSongs() {
		$apiManager = new APIManager();
		
		// Example artist Nav
		$artist_name = "Nav";
		$songs = $apiManager->get_songs($artist_name);

		$this->assertEquals(1, is_array($songs));
		echo "Get Songs Type Test: Asserts Return Type to be Array \n";

		$this->assertEquals($artist_name, $songs['artist']);
		echo "Get Song Artist Validity Test: Asserts Correct Value of Song Artist Name \n";

		$this->assertEquals(1, isset($songs['songs']));
		echo "Get Song Artist Validity Test: Asserts that Field 'songs' is Set \n";
	}

	// Test get_search_suggestions($search) function
	public function testGetSearchSuggestions() {
		$apiManager = new APIManager();
		
		// Example artist Nav
		$artist_name = "Nav";

		// Retrieve search suggestions for artist name
		$suggestions = $apiManager->get_search_suggestions($artist_name);

		$this->assertEquals(1, is_array($suggestions));
		echo "Get Search Suggestions Type Test: Asserts Return Type to be Array \n";

		foreach ($suggestions as $suggestion) {
			$this->assertEquals(1, isset($suggestion['artist']));
			$this->assertEquals(1, isset($suggestion['id']));
			$this->assertEquals(1, isset($suggestion['img']));
		}

		echo "Get Songs Artist Validity Test: Asserts that Field 'artist' is Set \n";
		echo "Get Songs ID Validity Test: Asserts that Field 'id' is Set \n";
		echo "Get Songs Image Validity Test: Asserts that Field 'img' is Set \n";

		
	}

	// Test get_track_id($artist, $track) function
	public function testGetTrackID() {
		$apiManager = new APIManager();
		
		// Example artist, song, and verified track_id using https://market.mashape.com/musixmatch-com/musixmatch
		$artist_name = "Drake";
		$artist_song = "Hype";
		$track_id = "110370890";
		$return_id = $apiManager->get_track_id($artist_name, $artist_song);

		$this->assertEquals($track_id, $return_id);
		echo "Get Track ID Validity Test: Asserts Correct Value of Track ID \n";

	}


	// Test get_lyrics($track_id) function
	public function testGetLyrics() {
		$apiManager = new APIManager();
		
		// Example track ID for Drake - Hype using https://market.mashape.com/musixmatch-com/musixmatch
		$track_id = "110370890";
		$lyrics = $apiManager->get_lyrics($track_id);
		$this->assertEquals(1, is_string($lyrics));
		echo "Get Lyrics Type Test: Asserts Return Type to be String \n";
	}

	// Test parse_song_lyrics($lyrics, $overall_freq) function
	public function testParseSongLyrics() {
		$apiManager = new APIManager();
		
		// Example track ID for Drake - Hype using https://market.mashape.com/musixmatch-com/musixmatch
		$track_id = "110370890";
		$lyrics = $apiManager->get_lyrics($track_id);

		// Overall Frequency map init
		$overall_freq = array();

		// Retrive the individual word frequency counts for the song
		$song_frequency_counts = $apiManager->parse_song_lyrics($lyrics, $overall_freq);

		$this->assertEquals(0, empty($overall_freq));
		echo "Parse Song Lyrics Validity Test: Asserts that Overall Freq. Array is Empty  \n";

		$this->assertEquals(1, is_array($song_frequency_counts));
		echo "Parse Song Lyrics Type Test: Asserts Return Type to be Array \n";

		// Array of filtered words for should not appear in lyrics
		$array_of_filtered_words = ["i", "you", "he", "she", "we", "you", "they", "and", "but", "or", "yet", "for", "nor", "so", "it", "", "the", "its", "if", "at", "to", "too", "then", "them", "when", "ill", "ive", "got", "be", "been", "was", "of", "aint", "me", "is", "what", "from", "here", "there", "where", "will", "would", "uh", "my", "on", "that", "im", "in", "with", "dont", "your", "this", "some", "how", "oh", "about", "these", "are", "can", "still", "cant", "youre", "cant", "have", "why", "went", "yours", "as", "had", "went", "should", "maybe", "every", "tryna", "going", "whose", "myself", "yourself", "herself", "hisself", "a"];

		foreach($overall_freq as $word) {
			$this->assertEquals(0, in_array($word, $array_of_filtered_words));
		}

		echo "Parse Song Lyrics Validity Test: Asserts Lyrics Contain no Illegal Words \n";

	}

	// Test add_artist_to_wordcloud($songs, $cache) function
	public function testAddArtistToWordCloud() {
		$api = new APIManager();
		$cache = new CacheManager();

		// Declare formatted result variable
		$overall_freq_formatted;

		// Query api through manager
		$songs = $api->get_songs("Nav");

	    // Compute frequency through helper
		$overall_freq_formatted = $api->add_artist_to_wordcloud($songs, $cache);

		$this->assertEquals(1, sizeof($cache->search_freq_cache()));
		echo "Add Artist to WordCloud Validity Test: Asserts that Frequency Cache Size Increase by 1 \n";

	}

	// Test get_song_list($word, $cache) function
	public function testGetSongList() {
		// Get managers
		$api = new APIManager();
		$cache = new CacheManager();

		// Query api through manager
		$songs = $api->get_songs("Nav");

   	 	// compute frequency through helper
		$overall_freq_formatted = $api->add_artist_to_wordcloud($songs, $cache);

		// Set word to query
		$word = "up";

		// Query api through manager
		$song_list = $api->get_song_list($word, $cache->search_freq_cache());

		$this->assertEquals(1, is_array($song_list));
		echo "Get Song List Type Test: Asserts Return Type to be Array \n";
	}
}
?>