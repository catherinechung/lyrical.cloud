<?php

function findTrackID($artist, $track) {
  $result = file_get_contents("http://api.musixmatch.com/ws/1.1/track.search?q_track={$track}&q_arist={$artist}&page_size=10&page=1&s_track_rating=desc&apikey=a820a7147e13aa7c816324dc7c2c57b9");

  $all_track_names = json_decode($result, true);
  $track_id = $all_track_names[message][body][track_list][0][track][track_id];

  return $track_id;
}

function findSongLyrics($artist, $track) {

  $track_id = findTrackID($artist, $track);

  $result = file_get_contents("http://api.musixmatch.com/ws/1.1/track.lyrics.get?track_id={$track_id}&apikey=a820a7147e13aa7c816324dc7c2c57b9");

  $lyrics_json = json_decode($result, true);
  $lyrics = $lyrics_json[message][body][lyrics][lyrics_body];

  return $lyrics;
}

function parseSongLyrics($lyrics, &$overall_freq) {
  // Convert string to lowercase
  $lyrics = strtolower($lyrics);

  // Remove symbols from lyrics string
  $symbols_to_remove = array(",", ".", ";", "!", ")", "(", "/", "?", "\"", "'", "-", "*", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

  $lyrics = str_replace($symbols_to_remove, "", $lyrics);
  $lyrics = str_replace("\n", " ", $lyrics);
  $lyrics = substr($lyrics, 0, -50);

  echo $lyrics;

  $array_of_words = explode(" ", $lyrics);
  // print_r($array_of_words);

  // Remove conjunctions
  $array_of_words = array_diff($array_of_words, ["i", "you", "he", "she", "we", "you", "they", "and", "but", "or", "yet", "for", "nor", "so"]);

  $frequency_counts = array();

  foreach ($array_of_words as $word) {
    if (array_key_exists($word, $array_of_words)) {
      $frequency_counts[$word]++;
    }
    else {
      $frequency_counts[$word] = 1;
    }

    if (array_key_exists($word, $overall_freq)) {
      $overall_freq[$word]++;
    }
    else {
      $overall_freq[$word] = 1;
    }
  }

  return $frequency_counts;
}

function parseAllLyrics(&$artist_and_song_list, &$overall_freq) {
  $artist_name = $artist_and_song_list["artist"];
  $song_list = $artist_and_song_list["songs"];

  // Individual song frequency list
  $song_frequency_list = array();

  foreach($song_list as $song) {
    $lyrics = findSongLyrics($artist_name, $song);
    $individual_song_freq = parseSongLyrics($lyrics, $overall_freq);
    array_push($song_frequency_list, $individual_song_freq);
  }

  arsort($overall_freq);
  print_r($overall_freq);
  print_r($song_frequency_list);
}

$arr = array();
$arr["artist"] = "justin+beiber";
$arr["songs"] = array("what+do+you+mean", "baby", "boyfriend", "never+say+never");

$overall_freq = array();
parseAllLyrics($arr, $overall_freq);

?>
