<?php


use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../src/CacheManager.php');

/*
 * @covers APIManager Class Methods
 */
final class APIManagerTests extends TestCase {

	// Test get_songs($artist) function
	public function testGetSongs() {
		echo "TEST NAME: testGetSongs \n \n";

		$apiManager = new APIManager();
		
		// Example artist Nav
		$artist_name = "Nav";
		$songs = $apiManager->get_songs($artist_name);

		$this->assertEquals(1, is_array($songs));
		echo "PASS - Get Songs Type Test: Asserts Return Type to be Array \n";

		$this->assertEquals($artist_name, $songs['artist']);
		echo "PASS - Get Song Artist Validity Test: Asserts Correct Value of Song Artist Name \n";

		$this->assertEquals(1, isset($songs['songs']));
		echo "PASS - Get Song Artist Validity Test: Asserts that Field 'songs' is Set \n";
		
		echo "Code Coverage : 47/196 statements = 24.0% | 6/34 branches = 17.6% \n \n";
	}

	// Test get_search_suggestions($search) function
	public function testGetSearchSuggestions() {
		echo "TEST NAME: testGetSearchSuggestions \n \n";

		$apiManager = new APIManager();
		
		// Example artist Nav
		$artist_name = "Nav";

		// Retrieve search suggestions for artist name
		$suggestions = $apiManager->get_search_suggestions($artist_name);

		$this->assertEquals(1, is_array($suggestions));
		echo "PASS - Get Search Suggestions Type Test: Asserts Return Type to be Array \n";

		foreach ($suggestions as $suggestion) {
			$this->assertEquals(1, isset($suggestion['artist']));
			$this->assertEquals(1, isset($suggestion['id']));
			$this->assertEquals(1, isset($suggestion['img']));
		}

		echo "PASS - Get Songs Artist Validity Test: Asserts that Field 'artist' is Set \n";
		echo "PASS - Get Songs ID Validity Test: Asserts that Field 'id' is Set \n";
		echo "PASS - Get Songs Image Validity Test: Asserts that Field 'img' is Set \n";

		echo "Code Coverage : 31/196 statements = 15.8% | 4/34 branches = 11.8% \n \n";
	}

	// Test get_track_id($artist, $track) function
	public function testGetTrackID() {
		echo "TEST NAME: testGetTrackID \n \n";

		$apiManager = new APIManager();
		
		// Example artist, song, and verified track_id using https://market.mashape.com/musixmatch-com/musixmatch
		$artist_name = "Drake";
		$artist_song = "Hype";
		$track_id = "110370890";
		$return_id = $apiManager->get_track_id($artist_name, $artist_song);

		$this->assertEquals($track_id, $return_id);
		echo "PASS - Get Track ID Validity Test: Asserts Correct Value of Track ID \n";

		echo "Code Coverage : 6/196 statements = 3.1% | 0/34 branches = 0.0% \n \n";

	}


	// Test get_lyrics($track_id) function
	public function testGetLyrics() {
		echo "TEST NAME: testGetLyrics \n \n";

		$apiManager = new APIManager();
		
		// Example track ID for Drake - Hype using https://market.mashape.com/musixmatch-com/musixmatch
		$track_id = "110370890";
		$lyrics = $apiManager->get_lyrics($track_id);
		$this->assertEquals(1, is_string($lyrics));
		echo "PASS - Get Lyrics Type Test: Asserts Return Type to be String \n";

		echo "Code Coverage : 12/196 statements = 6.1% | 0/34 branches = 0.0% \n \n";

	}

	// Test parse_song_lyrics($lyrics, $overall_freq) function
	public function testParseSongLyrics() {
		echo "TEST NAME: testParseSongLyrics \n \n";

		$apiManager = new APIManager();
		
		// Example track ID for Drake - Hype using https://market.mashape.com/musixmatch-com/musixmatch
		$track_id = "110370890";
		$lyrics = $apiManager->get_lyrics($track_id);

		// Overall Frequency map init
		$overall_freq = array();

		// Retrive the individual word frequency counts for the song
		$song_frequency_counts = $apiManager->parse_song_lyrics($lyrics, $overall_freq);

		$this->assertEquals(0, empty($overall_freq));
		echo "PASS - Parse Song Lyrics Validity Test: Asserts that Overall Freq. Array is Empty  \n";

		$this->assertEquals(1, is_array($song_frequency_counts));
		echo "PASS - Parse Song Lyrics Type Test: Asserts Return Type to be Array \n";

		// Array of filtered words for should not appear in lyrics
		$array_of_filtered_words = ["i", "you", "he", "she", "we", "you", "they", "and", "but", "or", "yet", "for", "nor", "so", "it", "", "the", "its", "if", "at", "to", "too", "then", "them", "when", "ill", "ive", "got", "be", "been", "was", "of", "aint", "me", "is", "what", "from", "here", "there", "where", "will", "would", "uh", "my", "on", "that", "im", "in", "with", "dont", "your", "this", "some", "how", "oh", "about", "these", "are", "can", "still", "cant", "youre", "cant", "have", "why", "went", "yours", "as", "had", "went", "should", "maybe", "every", "tryna", "going", "whose", "myself", "yourself", "herself", "hisself", "a"];

		foreach($overall_freq as $word) {
			$this->assertEquals(0, in_array($word, $array_of_filtered_words));
		}

		echo "PASS - Parse Song Lyrics Validity Test: Asserts Lyrics Contain no Illegal Words \n";

		echo "Code Coverage : 24/196 statements = 12.2% | 5/34 branches = 14.7% \n \n";

	}

	// Test add_artist_to_wordcloud($songs, $cache) function
	public function testAddArtistToWordCloud() {
		echo "TEST NAME: testAddArtistToWordCloud \n \n";

		$api = new APIManager();
		$cache = new CacheManager();

		// Declare formatted result variable
		$overall_freq_formatted;

		// Query api through manager
		$songs = $api->get_songs("Nav");

	    // Compute frequency through helper
		$overall_freq_formatted = $api->add_artist_to_wordcloud($songs, $cache);

		$this->assertEquals(1, sizeof($cache->search_freq_cache()));
		echo "PASS - Add Artist to WordCloud Validity Test: Asserts that Frequency Cache Size Increase by 1 \n";

		echo "Code Coverage : 67/196 statements = 34.2% | 8/34 branches = 23.5% \n \n";

	}

	// Test get_song_list($word, $cache) function
	public function testGetSongList() {
		echo "TEST NAME: testGetSongList \n \n";

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
		echo "PASS - Get Song List Type Test: Asserts Return Type to be Array \n";

		echo "Code Coverage : 28/196 statements = 14.3% | 3/34 branches = 8.8% \n \n";
	}
}
?>