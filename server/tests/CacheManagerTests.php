<?php

use PHPUnit\Framework\TestCase;

/*
 * @covers CacheManager Class Methods
 */
final class CacheManagerTest extends TestCase {

	# tests for CacheManager class

	// Return type test of overall_freq_cache() function
	public function testGetterReturnsOverallFrequencyCache() {
		$cache = new CacheManager();
		$this->assertEquals(1, is_array($cache->overall_freq_cache()));
		echo "Overall Frequency Cache of CacheManager is of type Array\n";
	}

	// Return type test of search_freq_cache() function
	public function testGetterReturnsSearchFrequencyCache() {
		$cache = new CacheManager();
		$this->assertEquals(1, is_array($cache->search_freq_cache()));
		echo "Search Frequency Cache of CacheManager is of type Array\n";
	}
}
?>