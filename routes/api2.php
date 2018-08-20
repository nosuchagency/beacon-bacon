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
Route::get('place/{place}', ['uses' => 'PlaceController@show']);
Route::put('place/{place}', ['uses' => 'PlaceController@update']);
Route::delete('place/{place}', ['uses' => 'PlaceController@destroy']);

Route::group(['prefix' => 'place/{place}'], function () {
    Route::get('menu', ['uses' => 'PlaceController@menu']);
    Route::post('find', ['uses' => 'PlaceController@find']);
});

// floors
Route::get('floor', ['uses' => 'FloorController@index']);
Route::post('floor', ['uses' => 'FloorController@store']);
Route::get('floor/deleted', ['uses' => 'FloorController@deleted']);
Route::get('floor/{floor}', ['uses' => 'FloorController@show']);
Route::put('floor/{floor}', ['uses' => 'FloorController@update']);
Route::delete('floor/{floor}', ['uses' => 'FloorController@destroy']);

// Locations
Route::get('location', ['uses' => 'LocationController@index']);
Route::post('location', ['uses' => 'LocationController@store']);
Route::get('location/deleted', ['uses' => 'LocationController@deleted']);
Route::get('location/{location}', ['uses' => 'LocationController@show']);
Route::put('location/{location}', ['uses' => 'LocationController@update']);
Route::delete('location/{location}', ['uses' => 'LocationController@destroy']);

// Pois
Route::get('poi', ['uses' => 'PoiController@index']);
Route::post('poi', ['uses' => 'PoiController@store']);
Route::get('poi/deleted', ['uses' => 'PoiController@deleted']);
Route::get('poi/{poi}', ['uses' => 'PoiController@show']);
Route::put('poi/{poi}', ['uses' => 'PoiController@update']);
Route::delete('poi/{poi}', ['uses' => 'PoiController@destroy']);

// Beacons
Route::get('beacons', ['uses' => 'BeaconController@index']);
Route::post('beacons', ['uses' => 'BeaconController@store']);
Route::get('beacons/deleted', ['uses' => 'BeaconController@deleted']);
Route::get('beacons/{beacon}', ['uses' => 'BeaconController@show']);
Route::put('beacons/{beacon}', ['uses' => 'BeaconController@update']);
Route::delete('beacons/{beacon}', ['uses' => 'BeaconController@destroy']);

// Media
Route::get('floors/{floor}/image', ['uses' => 'MediaController@image']);
Route::post('floors/{floor}/image', ['uses' => 'MediaController@imageUpdated']);
Route::get('pois/{poi}/icon', ['uses' => 'MediaController@icon']);
Route::post('pois/{poi}/icon', ['uses' => 'MediaController@iconUpdated']);
