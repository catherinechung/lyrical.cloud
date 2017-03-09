<?php

use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../src/CacheManager.php');
/*
 * @covers APIManager Class Methods
 */
final class APIManagerTests extends TestCase {

	// # tests for APIManager class

	// Return validity test of get_songs($artist) function
	public function testValidSongsForArtist() {
		$apiManager = new APIManager();
		
		// Example artist
		$artist_name = "Nav";
		$songs = $apiManager->get_songs($artist_name);

		$this->assertEquals(1, is_array($songs));
		$this->assertEquals($artist_name, $songs['artist']);
		$this->assertEquals(1, isset($songs['songs']));
	}

	// Return validity test of get_search_suggestions($search) function
	public function testValidSearchSuggestions() {
		$apiManager = new APIManager();
		
		// Example artist
		$artist_name = "Nav";
		$suggestions = $apiManager->get_search_suggestions($artist_name);

		$this->assertEquals(1, is_array($suggestions));

		foreach ($suggestions as $suggestion) {
			$this->assertEquals(1, isset($suggestion['artist']));
			$this->assertEquals(1, isset($suggestion['id']));
			$this->assertEquals(1, isset($suggestion['img']));
		}
		
	}

	// Return validity test of get_track_id($artist, $track) function
	public function testValidTrackID() {
		$apiManager = new APIManager();
		
		// Example artist, song, and verified track_id using https://market.mashape.com/musixmatch-com/musixmatch
		$artist_name = "Drake";
		$artist_song = "Hype";
		$track_id = "110370890";
		$return_id = $apiManager->get_track_id($artist_name, $artist_song);

		$this->assertEquals($track_id, $return_id);
	}


	// Return validity test of ge_lyrics($track_id) function
	public function testValidLyrics() {
		$apiManager = new APIManager();
		
		// Example track ID for Drake - Hype
		$track_id = "110370890";
		$lyrics = $apiManager->get_lyrics($track_id);
		$this->assertEquals(1, is_string($lyrics));
	}

	// Return validity test of parse_song_lyrics($lyrics, $overall_freq) function
	public function testParseSongLyrics() {
		$apiManager = new APIManager();
		
		// Example track ID for Drake - Hype
		$track_id = "110370890";
		$lyrics = $apiManager->get_lyrics($track_id);

		// Overall Frequency map
		$overall_freq = array();
		$song_frequency_counts = $apiManager->parse_song_lyrics($lyrics, $overall_freq);

		$this->assertEquals(0, empty($overall_freq));
		$this->assertEquals(1, is_array($song_frequency_counts));

		$array_of_filtered_words = ["i", "you", "he", "she", "we", "you", "they", "and", "but", "or", "yet", "for", "nor", "so", "it", "", "the", "its", "if", "at", "to", "too", "then", "them", "when", "ill", "ive", "got", "be", "been", "was", "of", "aint", "me", "is", "what", "from", "here", "there", "where", "will", "would", "uh", "my", "on", "that", "im", "in", "with", "dont", "your", "this", "some", "how", "oh", "about", "these", "are", "can", "still", "cant", "youre", "cant", "have", "why", "went", "yours", "as", "had", "went", "should", "maybe", "every", "tryna", "going", "whose", "myself", "yourself", "herself", "hisself", "a"];

		foreach($overall_freq as $word) {
			$this->assertEquals(0, in_array($word, $array_of_filtered_words));
		}
	}

	public function testAddArtistToWordCloud() {
		$api = new APIManager();
		$cache = new CacheManager();

		# declare formatted result variable
		$overall_freq_formatted;

		# query api through manager
		$songs = $api->get_songs("Nav");

	    # compute frequency through helper
		$overall_freq_formatted = $api->add_artist_to_wordcloud($songs, $cache);

		$this->assertEquals(1, sizeof($cache->search_freq_cache()));
	}

	public function testSongList() {
		# get managers from session
		$api = new APIManager();
		$cache = new CacheManager();

		# query api through manager
		$songs = $api->get_songs("Nav");

   	 	# compute frequency through helper
		$overall_freq_formatted = $api->add_artist_to_wordcloud($songs, $cache);

		# get param
		$word = "up";

		# query api through manager
		$song_list = $api->get_song_list($word, $cache->search_freq_cache());

		$this->assertEquals(1, is_array($song_list));
	}
}
?>