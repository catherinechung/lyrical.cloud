<?php

function findTrackID($artist, $track) {
  $result = file_get_contents("http://api.musixmatch.com/ws/1.1/track.search?q_track={$track}&q_arist={$artist}&page_size=10&page=1&s_track_rating=desc&apikey=a820a7147e13aa7c816324dc7c2c57b9");

  $all_track_names = json_decode($result, true);
  $track_id = $all_track_names[message][body][track_list][0][track][track_id];

  return $track_id;
}

function findLyrics($artist, $track) {

  $track_id = findTrackID($artist, $track);

  $result = file_get_contents("http://api.musixmatch.com/ws/1.1/track.lyrics.get?track_id={$track_id}&apikey=a820a7147e13aa7c816324dc7c2c57b9");
  // echo $result;

  $lyrics_json = json_decode($result, true);
  $lyrics = $lyrics_json[message][body][lyrics][lyrics_body];

  return $lyrics;
}

findLyrics('justinbeiber', 'baby');

?>
