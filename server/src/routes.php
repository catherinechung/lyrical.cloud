<?php

# ROUTES

# In this file, we specify our application's HTTP routes 
# and provide Closure callbacks to deal with user requests

# Helper variable so that we don't reinstantiate the cache

# On landing route, store session-wide variables for future use
# This includes instances of the API and Cache managers
$app->get('/', function ($request, $response, $args) {
	# if managers do not exist, create them and place in session!
	if (!isset($_SESSION['api']) && !isset($_SESSION['cache'])) {
		# define new api manager
		$api = new APIManager();

		# define new cache manager
		$cache = new CacheManager();

		# store managers in session
		$_SESSION['api'] = serialize($api);
		$_SESSION['cache'] = serialize($cache);

		# new response to return headers
		$res = $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081');
		return $res;
	}

	# new response to return headers
	$res = $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081');
	return $res;
});

# On this route, perform all operations requied to get the
# dropdown suggestions for the Word Cloud search bar, and
# return these suggestions to the frontend
$app->get('/api/dropdown/suggestions/{search}', function ($request, $response, $args) {
	# get api manager from session
	$api = unserialize($_SESSION['api']);

	# get query params for jsonp callback
	$callback = $request->getQueryParam('callback');

	# get and sanitize params
	$search = $args['search'];
	$search = str_replace(' ', '%20', trim($search));

	# query api through manager
	$suggestions = $api->get_search_suggestions($search);
	$suggestions = json_encode($suggestions);

	# convert current response to jsonp callback with new response
	$new_response = $response->withHeader('Content-Type', 'application/javascript');

	# create string with callback and suggestions data
	# write it to the body of the new response and return
	$callback = "{$callback}({$suggestions})";
	$new_response->getBody()->write($callback);
	return $new_response;
});

# On this route, perform all computations to get word cloud information
# for a newly-searched artist, and return this information to the frontend
$app->get('/api/wordcloud/new/{artist}', function ($request, $response, $args) {
	# get managers from session
	$api = unserialize($_SESSION['api']);
	$cache = unserialize($_SESSION['cache']);

	# change api key vlaue
	$api->switchKeys();

	# get query params for jsonp callback
	$callback = $request->getQueryParam('callback');

	# get and sanitize params
	$artist = $args['artist'];
	$artist = str_replace(' ', '%20', trim($artist));

	# declare formatted result variable
	$overall_freq_formatted;

	# does this artist exist in the search cache?
	if ($cache->contains($artist)) {
		$overall_freq_formatted = $cache->get_overall_frequencies($artist);
	}
	else {
		# clear all cache
		$cache->clear();

		# query api through manager
	    $songs = $api->get_songs($artist);

	    # compute frequency through helper
	    $overall_freq_formatted = $api->add_artist_to_wordcloud($songs, $cache);
	}

	# reserialize cache and api into session
	$_SESSION['cache'] = serialize($cache);
	$_SESSION['api'] = serialize($api);

	# encode into json
	$overall_freq_formatted = json_encode($overall_freq_formatted);

	# convert current response to jsonp callback with new response
	$new_response = $response->withHeader('Content-Type', 'application/javascript');

	# create string with callback and frequency data
	# write it to the body of the new response and return
	$callback = "{$callback}({$overall_freq_formatted})";
	$new_response->getBody()->write($callback);
	return $new_response;
});

# On this route, perform all computations to merge a newly-searched
# artist into the current word cloud, and return this updated cloud
# to the frontend
$app->get('/api/wordcloud/merge/{artist}', function ($request, $response, $args) {
	# get managers from session
	$api = unserialize($_SESSION['api']);
	$cache = unserialize($_SESSION['cache']);

	# get query params for jsonp callback
	$callback = $request->getQueryParam('callback');

	# get and sanitize params
	$artist = $args['artist'];
	$artist = str_replace(' ', '%20', trim($artist));

	# declare formatted result variable
	$overall_freq_formatted;

	# does this artist exist in the search cache?
	if ($cache->contains($artist)) {
		# tell the user that we can't merge in an already merged artist!
		# throw some sort of HTTP response error in the header status code
	} 
	else {
		# query api through manager
	    $songs = $api->get_songs($artist);

	    # compute frequency through helper
	    $overall_freq_formatted = $api->add_artist_to_wordcloud($songs, $cache);
	}

	# reserialize cache into session
	$_SESSION['cache'] = serialize($cache);

	# encode into json
	$overall_freq_formatted = json_encode($overall_freq_formatted);

	# convert current response to jsonp callback with new response
	$new_response = $response->withHeader('Content-Type', 'application/javascript');

	# create string with callback and frequency data
	# write it to the body of the new response and return
	$callback = "{$callback}({$overall_freq_formatted})";
	$new_response->getBody()->write($callback);
	return $new_response;
});

# On this route, perform all operations to get the lyrics of 
# a song written by a particular artist, and return these lyrics
# to the frontend
$app->get('/api/lyrics/{artist}/{song}', function ($request, $response, $args) {
	# get managers from session
	$api = unserialize($_SESSION['api']);
	$cache = unserialize($_SESSION['cache']);

	# get query params for jsonp callback
	$callback = $request->getQueryParam('callback');

	# get params and sanitize song name
	$artist = $args['artist'];
	$song = $args['song'];
	$song = str_replace(' ','-', $song);

	# query api through manager
	$track_id = $api->get_track_id($artist, $song);
	$lyrics = $api->get_lyrics($track_id);
	$lyrics = json_encode($lyrics);

	# convert current response to jsonp callback with new response
	$new_response = $response->withHeader('Content-Type', 'application/javascript');

	# create string with callback and lyrics data
	# write it to the body of the new response and return
	$callback = "{$callback}({$lyrics})";
	$new_response->getBody()->write($callback);
	return $new_response;
});

# On this route, perform all operations to get the list of songs
# that a particular word appears in, as well as the chosen word's
# frequency within each song
$app->get('/api/songlist/{word}', function ($request, $response, $args) {
	# get managers from session
	$api = unserialize($_SESSION['api']);
	$cache = unserialize($_SESSION['cache']);

	# get query params for jsonp callback
	$callback = $request->getQueryParam('callback');

	# get param
	$word = $args['word'];

	# query api through manager
	$song_list = $api->get_song_list($word, $cache->search_freq_cache());
	$song_list = json_encode($song_list);

	# convert current response to jsonp callback with new response
	$new_response = $response->withHeader('Content-Type', 'application/javascript');

	# create string with callback and lyrics data
	# write it to the body of the new response and return
	$callback = "{$callback}({$song_list})";
	$new_response->getBody()->write($callback);
	return $new_response;
});