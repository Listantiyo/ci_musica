<?php

use App\Controllers\AJAXRequest;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

service('auth')->routes($routes);

$routes->get('/music', static function () {
    return view('hero_section/index');
});

$routes->get('/music/show', static function () {
    return view('music_list_section/index');
});
// Playlist routes
$routes->get('/profile', 'ProfileController::index');
$routes->post('/profile/delete', 'ProfileController::delete');

$routes->get('/playlist', 'PlaylistController::index');

$routes->get('/playlist/create', 'PlaylistController::create');
$routes->post('/playlist/store', 'PlaylistController::store', ['filter' => 'csrf']);

$routes->get('/playlist/show/(:num)', 'PlaylistController::show/$1');
$routes->post('/playlist/update', 'PlaylistController::update', ['filter' => 'csrf']);
$routes->post('/playlist/delete', 'PlaylistController::delete', ['filter' => 'csrf']);
$routes->post('/playlist/itemAdd', 'PlaylistController::addItem', ['filter' => 'csrf']);
$routes->post('playlistItemDelete', 'PlaylistController::deleteItem', ['filter' => 'csrf']);

$routes->post('requestDataLikedSong', 'PlaylistController::requestDataLikedSong', ['filter' => 'csrf']);
// Playlist routes

$routes->get('/likelist', 'LikelistController::index');
$routes->post('likelistDeleteSong', 'LikelistController::delete', ['filter' => 'csrf']);
$routes->post('addToPlaylist', 'LikelistController::addToPlaylist', ['filter' => 'csrf']);
$routes->post('requestPlaylist', 'LikelistController::requestPlaylist', ['filter' => 'csrf']);

$routes->post('requestData', 'AJAXRequest::requestData', ['filter' => 'csrf']);
$routes->post('requestDataNextPrev', 'AJAXRequest::requestDataNextPrev', ['filter' => 'csrf']);
$routes->post('storeLove', 'AJAXRequest::storeLove', ['filter' => 'csrf']);

$routes->get('tes', 'AJAXRequest::tes');
