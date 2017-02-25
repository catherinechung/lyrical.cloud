<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

# define new slim app router
$router = new \Slim\App;

# get word cloud for given artist
$router->get('/api/wordcloud/new/{artist}', function (Request $request, Response $response) {
    $artist = $request->getAttribute('artist');
    return $artist;
});

# get word cloud for merged set of artists (can be merged into previous route)
$router->get('/api/wordcloud/new/{artist}' function (Request $request, Response $response) {
	$artist = $request->getAttribute('artist');
	return $artist;
});

# get lyrics for a song 
$router->get('/api/lyrics/{song}', function (Request $request, Response $response) {
	$song = $request->getAttribute('song');
	return $song;
});

# run routing server
$router->run();