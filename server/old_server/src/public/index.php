<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

session_start();

require '../vendor/autoload.php';
require './APIManager.php';
require './CacheManager.php';

# define new slim app router
$router = new \Slim\App;

# add session middleware to the router
$router->add(new \RKA\SessionMiddleware(['name', 'server_session']));

# on landing route, use to store session variables for future use
$router->get('/', function (Request $request, Response $response) {
	# get session from middleware
	$session = new \RKA\Session();

	# define new api manager
	$api = new APIManager();

	# define new cache manager
	$cache = new CacheManager();

	# store managers in session
	$session->set('api', $api);
	$session->set('cache', $cache);

	# new response to return headers
	$res = $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081');
	return $res;
});

# get word cloud for given artist
$router->get('/api/wordcloud/new/{artist}', function (Request $request, Response $response) {
	# get session from middleware
	$session = new \RKA\Session();

	# get managers from session
	$api = $session->get('api');
	print_r($api);
	$cache = $session->get('cache');

	# get and sanitize params
    $artist = $request->getAttribute('artist');
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

    # new response to return json
	$res = $response->withJson($overall_freq_formatted)->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081');
	return $res;
});

# get word cloud for merged set of artists (can be merged into previous route)
$router->get('/api/wordcloud/merge/{artist}', function (Request $request, Response $response) {
	# get session from middleware
	$session = new \RKA\Session();

	# get managers from session
	$api = $session->get('api');
	$cache = $session->get('cache');

	# get and sanitize params
    $artist = $request->getAttribute('artist');
    $artist = str_replace(' ', '%20', $artist);

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

    # new response to return json
	$res = $response->withJson($overall_freq_formatted)->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081');
	return $res;
});

# get lyrics for a song 
$router->get('/api/lyrics/{artist}/{song}', function (Request $request, Response $response) {
	# get session from middleware
	$session = new \RKA\Session();

	# get managers from session
	$api = $session->get('api');
	$cache = $session->get('cache');

	# get params
	$artist = $request->getAttribute('artist');
	$song = $request->getAttribute('song');

	# query api through manager
	$track_id = $api->get_track_id($artist, $song);
	$lyrics = $api->get_lyrics($track_id);

	# new response to return json
	$res = $response->withJson($lyrics)->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081');
	return $res;
});

# get  suggestions for the search bar's dropdown
$router->get('/api/dropdown/suggestions/{search}', function (Request $request, Response $response) {
	# get session from middleware
	$session = new \RKA\Session();

	# get managers from session
	$api = $session->get('api');
	$cache = $session->get('cache');

	# get params
	$search = $request->getAttribute('search');
	$search = str_replace(' ', '%20', trim($search));

	# query api through manager
	$suggestions = $api->get_search_suggestions($search);

	# new response to return json
	$res = $response->withJson($suggestions)->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081');
	return $res;
});

# run routing server
$router->run();