<?php
class CacheManager {

	# holds overall freq cache (per-current-search-tree)
	# stores information PER ip
	private $overall_freq_cache = array();

	# holds single-search freq cache (per-artist-per-song)
	# stores information PER ip
	private $search_freq_cache = array();

	# access overall freq cache
	public function overall_freq_cache() {
		return $this->overall_freq_cache;
	}

	# access single-search freq cache
	public function search_freq_cache() {
		return $this->search_freq_cache;
	}

}
?>