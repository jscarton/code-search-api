<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
	$api->get('search', 'App\Http\Controllers\CodeSearchController@index');
	$api->get('search/{q}', 'App\Http\Controllers\CodeSearchController@index');
	$api->get('search/{q}/{page}', 'App\Http\Controllers\CodeSearchController@index');
	$api->get('search/{q}/{page}/{per_page}', 'App\Http\Controllers\CodeSearchController@index');
});