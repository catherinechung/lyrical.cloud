<?php

use PHPUnit\Framework\TestCase;

/*
 * @covers CacheManager Class Methods
 */
final class CacheManagerTest extends TestCase {

	# tests for CacheManager class

	// Test overall_freq_cache() function
	public function testOverallFrequencyCache() {
		$cache = new CacheManager();
		$this->assertInternalType("array", $cache->overall_freq_cache());
		echo "Overall Frequency Cache Type Test : Asserts Return Type to be Array\n";
	}

	// Test search_freq_cache() function
	public function testSearchFrequencyCache() {
		$cache = new CacheManager();
		$this->assertInternalType("array", $cache->search_freq_cache());
		echo "Search Frequency Cache Type Test : Asserts Return Type to be Array\n";
	}

	// Test lifetime_freq_cache() function
	public function testLifetimeFrequencyCache() {
		$cache = new CacheManager();
		$this->assertInternalType("array", $cache->lifetime_freq_cache());
		echo "Lifetime Frequency Cache Type Test : Asserts Return Type to be Array\n";
	}

	// Test contains() function
	public function testCacheContainsArtist() {
		$cache = new CacheManager();
		$cache->insert_into_lifetime_cache('test_input', 'test_entry');
		$this->assertSame(isset($cache->lifetime_freq_cache()['test_input']), $cache->contains('test_input'));
		echo "Cache Contains Artist Validity Test : Asserts that Field 'test_input' is Set in Lifetime Cache\n";
		$this->assertSame(isset($cache->lifetime_freq_cache()['not_test_input']), $cache->contains('not_test_input'));
		echo "Cache Contains Artist Validity Test: Asserts that Field 'not_test_input' is not Set in Lifetime Cache\n";
	}

	// Test insert_into_search_cache() function
	public function testInsertIntoSearchCache() {
		$cache = new CacheManager();
		$cache->insert_into_search_cache('test_input', 'test_entry');
		$this->assertArrayHasKey('test_input', $cache->search_freq_cache());
		echo "Insert Into Search Cache Validity Test : Asserts that Search Cache has Key 'test_input'\n";
		$this->assertArrayNotHasKey('not_test_input', $cache->search_freq_cache());
		echo "Insert Into Search Cache Validity Test : Asserts that Search Cache does not have Key 'not_test_input'\n";
	}

	// Test insert_into_lifetime_cache() function
	public function testInsertIntoLifetimeCache() {
		$cache = new CacheManager();
		$cache->insert_into_lifetime_cache('test_input', 'test_entry');
		$this->assertArrayHasKey('test_input', $cache->lifetime_freq_cache());
		echo "Insert Into Lifetime Cache Validity Test : Asserts that Lifetime Cache has Key 'test_input'\n";
		$this->assertArrayNotHasKey('not_test_input', $cache->lifetime_freq_cache());
		echo "Insert Into Lifetime Cache Validity Test : Asserts that Lifetime Cache does not have Key 'not_test_input'\n";
	}

	// Test merge_into_overall_cache() function with small input size
	public function testMergeIntoOverallCacheSmall() {
		$cache = new CacheManager();
		$test_input_small = array("a" => 10);
		$cache->merge_into_overall_cache($test_input_small);
		$this->assertSame($test_input_small, $cache->overall_freq_cache());
		echo "Merge Into Overall Cache Validity Test : Asserts that Overall Frequency Cache deep-equals Expected, Correctly-Ordered Output Array for Small-sized Input\n";
	}

	// Test merge_into_overall_cache() function with medium input size
	public function testMergeIntoOverallCacheMedium() {
		$cache = new CacheManager();
		$test_input_small = array("a" => 10);
		$cache->merge_into_overall_cache($test_input_small);

		$test_input_medium = array("b" => 11, "c" => 58, "d" => 1, "e" => 4, "f" => 27, "g" => 33, "h" => 41, "i" => 26, "j" => 212);
		$cache->merge_into_overall_cache($test_input_medium);
		$input_medium_expected_merge_result = array("j" => 212, "c" => 58, "h" => 41, "g" => 33, "f" => 27, "i" => 26, "b" => 11, "a" => 10, "e" => 4, "d" => 1);
		$this->assertSame($input_medium_expected_merge_result, $cache->overall_freq_cache());
		echo "Merge Into Overall Cache Validity Test : Asserts that Overall Frequency Cache deep-equals Expected, Correctly-Ordered Output Array for Medium-sized Input\n";
	}

	// Test merge_into_overall_cache() function with large input size
	public function testMergeIntoOverallCacheLarge() {
		$cache = new CacheManager();
		$test_input_small = array("a" => 10);
		$cache->merge_into_overall_cache($test_input_small);

		$test_input_medium = array("b" => 11, "c" => 58, "d" => 1, "e" => 4, "f" => 27, "g" => 33, "h" => 41, "i" => 26, "j" => 212);
		$cache->merge_into_overall_cache($test_input_medium);
		$test_input_large = array("k" => 505, "three" => 811, "four" => 14, "hey" => 32, "go" => 12, "like" => 55, "clouds" => 4, "cloud" => 22, "talkin" => 44, "girl" => 44, "money" => 14, "twenties" => 82, "motivation" => 2, "foreign" => 77, "checks" => 9, "soul" => 2, "dior" => 19, "ends" => 40, "benz" => 5, "make" => 3, "grand" => 94, "rose" => 42, "wires" => 5, "wake" => 72, "do" => 11, "california" => 28, "cash" => 69, "vitamin" => 234, "lucky" => 239, "pipes" => 228, "flow" => 92, "grand" => 47, "vibe" => 155, "quiet" => 56, "chalice" => 59, "gravity" => 132, "apricot" => 178, "generator" => 164, "arms" => 87, "therefore" => 20, "stars" => 54, "legends" => 74, "prophet" => 38, "lake" => 33, "dice" => 14);
		$cache->merge_into_overall_cache($test_input_large);
		$input_large_expected_merge_result = array("three" => 811, "k" => 505, "lucky" => 239, "vitamin" => 234, "pipes" => 228, "j" => 212, "apricot" => 178, "generator" => 164, "vibe" => 155, "gravity" => 132, "flow" => 92, "arms" => 87, "twenties" => 82, "foreign" => 77, "legends" => 74, "wake" => 72, "cash" => 69, "chalice" => 59, "c" => 58, "quiet" => 56, "like" => 55, "stars" => 54, "grand" => 47, "talkin" => 44, "girl" => 44, "rose" => 42, "h" => 41, "ends" => 40, "prophet" => 38, "lake" => 33, "g" => 33, "hey" => 32, "california" => 28, "f" => 27, "i" => 26, "cloud" => 22, "therefore" => 20, "dior" => 19, "four" => 14, "money" => 14, "dice" => 14, "go" => 12, "b" => 11, "do" => 11, "a" => 10, "checks" => 9, "wires" => 5, "benz" => 5, "clouds" => 4, "e" => 4, "make" => 3, "soul" => 2, "motivation" => 2, "d" => 1);
		$this->assertSame($input_large_expected_merge_result, $cache->overall_freq_cache());
		echo "Merge Into Overall Cache Validity Test : Asserts that Overall Frequency Cache deep-equals Expected, Correctly-Ordered Output Array for Large-sized Input\n";
	}

	// Test get_overall_frequencies() function with small input size
	public function testGetOverallFrequenciesSmall() {
		$cache = new CacheManager();
		$test_input_small = array(
			array(
				"song_1_id", 
				"song_1" => array(
								"word_1" => 1, 
								"word_2" => 4
							)
			), 
			array(
				"song_2_id", 
				"song_2" => array(
								"word_1" => 4, 
								"word_2" => 6, 
								"word_3" => 5
							)
			)
		);
		$cache->insert_into_lifetime_cache("artist_1", $test_input_small);
		$expected_output_small = array(array("key" => "word_2", "value" => 10), array("key" => "word_1", "value" => 5), array("key" => "word_3", "value" => 5));
		$overall_freq_map_artist_1 = $cache->get_overall_frequencies("artist_1");
		$this->assertSame($expected_output_small, $overall_freq_map_artist_1);
		echo "Get Overall Frequencies Validity Test : Asserts that Overall Frequencies Array for Artist deep-equals Expected, Correctly-Ordered Output Array for Small-sized Input\n";
	}

	// Test get_overall_frequencies() function with medium input size
	public function testGetOveerallFrequenciesMedium() {
		$cache = new CacheManager();
		$test_input_medium = array(
			array(
				"song_1_id", 
				"song_1" => array(
								"word_1" => 1, 
								"word_2" => 4,
								"word_3" => 5,
								"word_4" => 10,
								"word_5" => 3,
								"word_6" => 22,
								"word_7" => 33,
								"word_8" => 30,
								"word_9" => 101,
								"word_10" => 112,
								"word_11" => 74,
								"word_12" => 63,
								"word_13" => 65,
								"word_14" => 37,
								"word_15" => 33,
								"word_16" => 78,
								"word_17" => 6,
								"word_18" => 221,
								"word_19" => 179,
								"word_20" => 146
							)
			),
			array(
				"song_2_id", 
				"song_2" => array(
								"word_1" => 6, 
								"word_4" => 86,
								"word_9" => 156,
								"word_23" => 43,
								"word_54" => 37,
								"word_10" => 112,
								"word_11" => 74,
								"word_12" => 63,
								"word_2" => 22,
								"word_3" => 54,
								"word_17" => 6,
								"word_18" => 221,
								"word_15" => 33,
								"word_16" => 78,
								"word_19" => 179,
								"word_20" => 146
							)
			),
			array(
				"song_3_id", 
				"song_3" => array(
								"word_28" => 56,
								"word_32" => 12,
								"word_33" => 31,
								"word_34" => 32,
								"word_35" => 36,
								"word_36" => 22,
								"word_42" => 12,
							)
			)
		);
		$cache->insert_into_lifetime_cache("artist_1", $test_input_medium);
		$expected_output_medium = array(array("key" => "word_18", "value" => 442), array("key" => "word_19",
			"value" => 358), array("key" => "word_20", "value" => 292), array("key" => "word_9", "value" => 257), array("key" => "word_10", "value" => 224), array("key" => "word_16", "value" => 156), array("key" => "word_11", "value" => 148), array("key" => "word_12", "value" => 126), array("key" => "word_4", "value" => 96), array("key" => "word_15", "value" => 66), array("key" => "word_13", "value" => 65,), array("key" => "word_3", "value" => 59), array("key" => "word_28", "value" => 56), array("key" => "word_23", "value" => 43), array("key" => "word_14",
	        	"value" => 37), array("key" => "word_54", "value" => 37), array("key" => "word_35", "value" => 36), array("key" => "word_7", "value" => 33), array("key" => "word_34", "value" => 32), array("key" => "word_33", "value" => 31), array("key" => "word_8", "value" => 30), array("key" => "word_2", "value" => 26), array("key" => "word_6", "value" => 22), array("key" => "word_36", "value" => 22), array("key" => "word_42", "value" => 12), array("key" => "word_32", "value" => 12), array("key" => "word_17", "value" => 12), array("key" => "word_1", "value" => 7), array("key" => "word_5", "value" => 3));
		$overall_freq_map_artist_1 = $cache->get_overall_frequencies("artist_1");
		$this->assertSame($expected_output_medium, $overall_freq_map_artist_1);
		echo "Get Overall Frequencies Validity Test : Asserts that Overall Frequencies Array for Artist deep-equals Expected, Correctly-Ordered Output Array for Medium-sized Input\n";
	}

	// Test get_overall_frequencies() function with large input size
	public function testGetOveerallFrequenciesLarge() {
		$cache = new CacheManager();
		$test_input_large = array(
			array(
				"song_1_id", 
				"song_1" => array(
								"word_1" => 1, 
								"word_2" => 4,
								"word_3" => 5,
								"word_4" => 10,
								"word_5" => 3,
								"word_6" => 22,
								"word_7" => 33,
								"word_8" => 30,
								"word_9" => 101,
								"word_10" => 112,
								"word_11" => 74,
								"word_12" => 63,
								"word_13" => 65,
								"word_14" => 37,
								"word_15" => 33,
								"word_16" => 78,
								"word_17" => 6,
								"word_18" => 221,
								"word_19" => 179,
								"word_20" => 146
							)
			),
			array(
				"song_2_id", 
				"song_2" => array(
								"word_1" => 6, 
								"word_4" => 86,
								"word_9" => 156,
								"word_23" => 43,
								"word_54" => 37,
								"word_10" => 112,
								"word_11" => 74,
								"word_12" => 63,
								"word_2" => 22,
								"word_3" => 54,
								"word_17" => 6,
								"word_18" => 221,
								"word_15" => 33,
								"word_16" => 78,
								"word_19" => 179,
								"word_20" => 146
							)
			),
			array(
				"song_3_id", 
				"song_3" => array(
								"word_28" => 56,
								"word_32" => 12,
								"word_33" => 31,
								"word_34" => 32,
								"word_35" => 36,
								"word_36" => 22,
								"word_42" => 12,
							)
			),
			array(
				"song_4_id",
				"song_4" => array(
								"word_82" => 46,
								"word_92" => 58,
								"word_94" => 51,
								"word_62" => 12,
								"word_88" => 4,
								"word_89" => 24,
								"word_90" => 28,
							)
			),
			array(
				"song_5_id",
				"song_5" => array(
								"word_82" => 1,
								"word_84" => 12,
								"word_90" => 2,
								"word_46" => 588,
								"word_22" => 48,
								"word_56" => 32,
								"word_76" => 79,
								"word_72" => 35,
								"word_69" => 80
							)
			)
		);
		$cache->insert_into_lifetime_cache("artist_1", $test_input_large);
		$expected_output_large = array(array("key" => "word_46", "value" => 588), array("key" => "word_18", "value" => 442), array("key" => "word_19", "value" => 358), array("key" => "word_20", "value" => 292), array("key" => "word_9", "value" => 257), array("key" => "word_10", "value" => 224), array("key" => "word_16", "value" => 156), array("key" => "word_11", "value" => 148), array("key" => "word_12", "value" => 126), array("key" => "word_4", "value" => 96), array("key" => "word_69", "value" => 80), array("key" => "word_76", "value" => 79), array("key" => "word_15", "value" => 66), array("key" => "word_13", "value" => 65), array("key" => "word_3", "value" => 59), array("key" => "word_92", "value" => 58), array("key" => "word_28", "value" => 56), array("key" => "word_94", "value" => 51), array("key" => "word_22", "value" => 48), array("key" => "word_82", "value" => 47), array("key" => "word_23", "value" => 43), array("key" => "word_54", "value" => 37), array("key" => "word_14", "value" => 37), array("key" => "word_35", "value" => 36), array("key" => "word_72", "value" => 35), array("key" => "word_7", "value" => 33), array("key" => "word_34", "value" => 32), array("key" => "word_56", "value" => 32), array("key" => "word_33", "value" => 31), array("key" => "word_90", "value" => 30), array("key" => "word_8", "value" => 30), array("key" => "word_2", "value" => 26), array("key" => "word_89", "value" => 24), array("key" => "word_36", "value" => 22), array("key" => "word_6", "value" => 22), array("key" => "word_62", "value" => 12), array("key" => "word_84", "value" => 12), array("key" => "word_32", "value" => 12), array("key" => "word_17", "value" => 12), array("key" => "word_42", "value" => 12), array("key" => "word_1", "value" => 7), array("key" => "word_88", "value" => 4), array("key" => "word_5", "value" => 3)
		);
		$overall_freq_map_artist_1 = $cache->get_overall_frequencies("artist_1");
		$this->assertSame($expected_output_large, $overall_freq_map_artist_1);
		echo "Get Overall Frequencies Validity Test : Asserts that Overall Frequencies Array for Artist deep-equals Expected, Correctly-Ordered Output Array for Large-sized Input\n";
	}
}
?>