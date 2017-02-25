<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require './APIManager.php';

# define new api manager
$api = new APIManager();

# define new slim app router
$router = new \Slim\App;

# get word cloud for given artist
$router->get('/api/wordcloud/new/{artist}', function (Request $request, Response $response) use ($api) {
	# get params
    $artist = $request->getAttribute('artist');

    # query api through manager
    $results = $api->get_songs($artist);
});

# get word cloud for merged set of artists (can be merged into previous route)
$router->get('/api/wordcloud/merge/{artist}', function (Request $request, Response $response) use ($api) {
	$artist = $request->getAttribute('artist');
});

# get lyrics for a song 
$router->get('/api/lyrics/{artist}/{song}', function (Request $request, Response $response) use ($api) {
	# get params
	$artist = $request->getAttribute('artist');
	$song = $request->getAttribute('song');

	# query api through manager
	$lyrics = $api->get_lyrics($artist, $song);
});

# run routing server
$router->run();