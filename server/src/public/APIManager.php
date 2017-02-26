<?php
	class APIManager {

		# musixmatch
		private $mmAPI = 'http://api.musixmatch.com/ws/1.1/';
		private $mmKey = '&apikey=a820a7147e13aa7c816324dc7c2c57b9';

		# spotify
		private $spAPI = 'https://api.spotify.com/v1/';

		/* SPOTIFY API METHODS */

		# get search suggestions for the given search input
		# parameter: Search Input 
		# return: 
		public function get_search_suggestions($search) {
			$response = file_get_contents($this->spAPI . "search?q=" . $search . "&type=artist&limit=5");
			$data = json_decode($response, true);
			$suggestions = array();


			foreach(@$data[artists][items] as $suggestion) {
				$name = $this->validate_name($suggestion);
				$id = $this->validate_id($suggestion);
				$img = $this->validate_image($suggestion);

				$suggestions[] = array($name, $id, $img);
			}

			return $suggestions;
		}

		private function validate_name($entry) {
			if (isset($entry["name"])) {
				return @$entry[name];
			}
			return "";
		}

		private function validate_id($entry) {
			if (isset($entry["id"])) {
				return @$entry[id];
			}
			return "";
		}

		private function validate_image($entry) {
			if (isset($entry["images"]["2"])) {
				return @$entry[images][2];
			}
			return "";
		}

		# get all songs from an artist's discography
		# parameter: Artist Name
		# return: List of all songs by this artist
		public function get_songs($artist) {
			$id = $this->get_artist_id($artist);
			$albumIDs = $this->get_albums($id);
			$songs = array();
			$songs[artist] = $artist;
			$songs[songs] = array();
			
			foreach($albumIDs as $albumID) {
				$this->get_songs_from_album($albumID, $songs[songs]);
			}

			print_r($songs);
			return $songs;
		}

		# utility function to get encoded artist id
		# parameter: Artist Name
		# return: Spotify Artist ID
		private function get_artist_id($artist) {
			$response = file_get_contents($this->spAPI . "search?q=" . $artist . "&type=artist&limit=1");
			$data = json_decode($response, true);

			return @$data[artists][items][0][id];
		}

		# get albums from an artist's discography
		# parameter: Spotify Artist ID
		# return: List of albums
		private function get_albums($artistID) {
			$response = file_get_contents($this->spAPI . "artists/" . $artistID . "/albums?limit=30");
			$data = json_decode($response, true);
			$duplicates = array();
			$albumIDs = array();

			$albums = array_filter(@$data[items], function($album) {
				$albumName = @$album[name];
				return strpos($albumName, "(Deluxe)") === false;
			});

			foreach($albums as $albumInfo) {
				$name = @$albumInfo[name];
				$id = @$albumInfo[id];
				
				if (!in_array($name, $duplicates)) {
					$albumIDs[] = $id;
					$duplicates[] = $name;
				}
			}

			return $albumIDs;
		}

		# get songs from an artist's album
		# parameter: Spotify Album ID
		# return: List of songs in this album
		private function get_songs_from_album($albumID, &$arr) {
			$response = file_get_contents($this->spAPI . "albums/" . $albumID . "/tracks");
			$data = json_decode($response, true);

			foreach(@$data[items] as $song) {
				$arr[] = strtolower(str_replace(' ', '+', @$song[name]));
			}
		}

		/* MUSIXMATCH API METHODS */

		# get track id, given name of artist and track
		private function get_track_id($artist, $track) {
			$result = file_get_contents($this->mmAPI . "track.search?q_track={$track}&q_arist={$artist}&page_size=10&page=1&s_track_rating=desc" . $this->mmKey);

			$all_track_names = json_decode($result, true);
  			$track_id = $all_track_names[message][body][track_list][0][track][track_id];

  			return $track_id;
		}

		# get lyrics for track, given name of artist and track
		public function get_lyrics($artist, $track) {
			$track_id = $this->get_track_id($artist, $track);

			$result = file_get_contents($this->mmAPI . "track.lyrics.get?track_id={$track_id}" . $this->mmKey);

			$lyrics_json = json_decode($result, true);
  			$lyrics = $lyrics_json[message][body][lyrics][lyrics_body];

  			return $lyrics;
		}

		# merge the searched artist's discography with the current map
	}
?>