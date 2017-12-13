<?php

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

// Profile routes
Route::get('profile', ['uses' => 'ProfileController@index']);
Route::put('profile', ['uses' => 'ProfileController@update']);

// Places
Route::get('place', ['uses' => 'PlaceController@index']);
Route::get('place/deleted', ['uses' => 'PlaceController@deleted']);
Route::get('place/{id}', ['uses' => 'PlaceController@show']);
Route::put('place/{id}', ['uses' => 'PlaceController@update']);
Route::delete('place/{id}', ['uses' => 'PlaceController@destroy']);

Route::group(['prefix' => 'place/{id}'], function () {
    Route::get('menu', ['uses' => 'PlaceController@menu']);
    Route::post('find', ['uses' => 'PlaceController@find']);
});

// floors
Route::get('floor', ['uses' => 'FloorController@index']);
Route::post('floor', ['uses' => 'FloorController@store']);
Route::get('floor/deleted', ['uses' => 'FloorController@deleted']);
Route::get('floor/{id}', ['uses' => 'FloorController@show']);
Route::put('floor/{id}', ['uses' => 'FloorController@update']);
Route::delete('floor/{id}', ['uses' => 'FloorController@destroy']);

// Locations
Route::get('location', ['uses' => 'LocationController@index']);
Route::post('location', ['uses' => 'LocationController@store']);
Route::get('location/deleted', ['uses' => 'LocationController@deleted']);
Route::get('location/{id}', ['uses' => 'LocationController@show']);
Route::put('location/{id}', ['uses' => 'LocationController@update']);
Route::delete('location/{id}', ['uses' => 'LocationController@destroy']);

// Pois
Route::get('poi', ['uses' => 'PoiController@index']);
Route::post('poi', ['uses' => 'PoiController@store']);
Route::get('poi/deleted', ['uses' => 'PoiController@deleted']);
Route::get('poi/{id}', ['uses' => 'PoiController@show']);
Route::put('poi/{id}', ['uses' => 'PoiController@update']);
Route::delete('poi/{id}', ['uses' => 'PoiController@destroy']);

// Beacons
Route::get('beacons', ['uses' => 'BeaconController@index']);
Route::post('beacons', ['uses' => 'BeaconController@store']);
Route::get('beacons/deleted', ['uses' => 'BeaconController@deleted']);
Route::get('beacons/{id}', ['uses' => 'BeaconController@show']);
Route::put('beacons/{id}', ['uses' => 'BeaconController@update']);
Route::delete('beacons/{id}', ['uses' => 'BeaconController@destroy']);

// Media
Route::get('floors/{id}/image', ['uses' => 'MediaController@image']);
Route::post('floors/{id}/image', ['uses' => 'MediaController@imageUpdated']);
Route::get('pois/{id}/icon', ['uses' => 'MediaController@icon']);
Route::post('pois/{id}/image', ['uses' => 'MediaController@iconUpdated']);
