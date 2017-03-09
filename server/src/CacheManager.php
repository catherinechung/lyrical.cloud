<?php
final class CacheManager {

	# holds overall freq cache (per currently searched artists)
	private $overall_freq_cache = array();

	# holds search freq cache (per-search [aka per-artist] per-song)
	private $search_freq_cache = array();

	# holds lifetime freq cache (per total lifetime of server)
	private $lifetime_freq_cache = array();

	# constructor
	public function __construct() {}

	# accessor helper function to access overall cache
	public function overall_freq_cache() {
		return $this->overall_freq_cache;
	}

	# accessor helper function to access search freq cache
	public function search_freq_cache() {
		return $this->search_freq_cache;
	}

	# accessor helper function to access lifetime freq cache
	public function lifetime_freq_cache() {
		return $this->lifetime_freq_cache;
	}

	# does the search cache contain the artist?
	public function contains($artist) {
		return array_key_exists($artist, $this->lifetime_freq_cache);
	}

	# inserts a new search entry into the per-artist
	# per-song frequency cache
	public function insert_into_search_cache($artist_name, $entry) {
		$this->search_freq_cache[$artist_name] = $entry;
	}

	# inserts a new search entry into the lifetime server cache
	public function insert_into_lifetime_cache($artist_name, $entry) {
		$this->lifetime_freq_cache[$artist_name] = $entry;
	}

	# merge two different overall freq maps into one, 
	# arsort, and deposit result into overall freq cache
	public function merge_into_overall_cache($to_merge) {
		# merge params with overall_req_cache, and use arsort to sort by desc. freq
		$this->overall_freq_cache = array_merge($to_merge, $this->overall_freq_cache);
		arsort($this->overall_freq_cache);
	}

	# takes an artist's name and outputs an overall frequency 
	# map for the artist, based on cached information over server lifetime
	public function get_overall_frequencies($artist) {
		# get specific artist-song freq list from param
		$artist_song_frequencies_list = $this->lifetime_freq_cache[$artist];

		# declare overall frequency list
		$overall_freq = array();

		# iterate through param list
		foreach($artist_song_frequencies_list as $song_frequency_map) {
			$keys = array_keys($song_frequency_map);
			foreach($song_frequency_map[$keys[1]] as $word => $freq) {
				if (array_key_exists($word, $overall_freq)) {
					$overall_freq[$word] += $freq;
				}
				else {
					$overall_freq[$word] = $freq;
				}
			}
		}

		# sort overall freqs for this artist in desc. freq. order
		arsort($overall_freq);

		# new array to format data for front-end
		$overall_freq_formatted = array();
		foreach($overall_freq as $word => $freq) {
			$entry = array();
			$entry["key"] = $word;
			$entry["value"] = $freq;
			array_push($overall_freq_formatted, $entry);
		}

		return (sizeof($overall_freq_formatted) >= 250) ? array_slice($overall_freq_formatted, 0, 250) : $overall_freq_formatted;
	}

	# clear out the cache
	public function clear() {
		# reinstantiate overall and search cache, not lifetime cache!
		$this->overall_freq_cache = array();
		$this->search_freq_cache = array();
	}
}
?>