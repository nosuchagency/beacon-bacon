<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::resource('places', 'PlaceController');
Route::resource('categories', 'CategoryController');
//Route::resource('maps', 'MapController');
//Route::resource('locations', 'LocationController');
Route::resource('beacons', 'BeaconController');

// Places
/*Route::get('places', ['as' => 'places.index', 'uses' => 'PlaceController@index']);
Route::get('places/create', ['as' => 'places.create', 'uses' => 'PlaceController@create']);
Route::post('places', ['as' => 'places.store', 'uses' => 'PlaceController@store']);
Route::get('places/{place}', ['as' => 'places.show', 'uses' => 'PlaceController@show']);
Route::put('places/{place}', ['as' => 'places.update', 'uses' => 'PlaceController@update']);
Route::delete('places/{place}', ['as' => 'places.destroy', 'uses' => 'PlaceController@destroy']);*/

Route::group(['prefix' => 'places/{place}'], function(){
    // Maps
    Route::get('maps', ['as' => 'maps.index', 'uses' => 'MapController@index']);
    Route::get('maps/create', ['as' => 'maps.create', 'uses' => 'MapController@create']);
    Route::post('maps', ['as' => 'maps.store', 'uses' => 'MapController@store']);
    Route::get('maps/{map}', ['as' => 'maps.show', 'uses' => 'MapController@show']);
    Route::get('maps/{map}/edit', ['as' => 'maps.edit', 'uses' => 'MapController@edit']);
    Route::put('maps/{map}', ['as' => 'maps.update', 'uses' => 'MapController@update']);
    Route::delete('maps/{map}', ['as' => 'maps.destroy', 'uses' => 'MapController@destroy']);

    Route::group(['prefix' => 'maps/{map}'], function(){
        // Locations
        Route::get('locations', ['as' => 'locations.index', 'uses' => 'LocationController@index']);
        Route::get('locations/create', ['as' => 'locations.create', 'uses' => 'LocationController@create']);
        Route::post('locations', ['as' => 'locations.store', 'uses' => 'LocationController@store']);
        Route::get('locations/{location}', ['as' => 'locations.show', 'uses' => 'LocationController@show']);
        Route::get('locations/{location}/edit', ['as' => 'locations.edit', 'uses' => 'LocationController@edit']);
        Route::put('locations/{location}', ['as' => 'locations.update', 'uses' => 'LocationController@update']);
        Route::delete('locations/{location}', ['as' => 'locations.destroy', 'uses' => 'LocationController@destroy']);
    });
});

/**
 * Teamwork routes
 */
Route::group(['prefix' => 'teams', 'namespace' => 'Teamwork'], function()
{
    Route::get('/', 'TeamController@index')->name('teams.index');
    //Route::get('create', 'TeamController@create')->name('teams.create');
    //Route::post('teams', 'TeamController@store')->name('teams.store');
    //Route::get('edit/{id}', 'TeamController@edit')->name('teams.edit');
    //Route::put('edit/{id}', 'TeamController@update')->name('teams.update');
    //Route::delete('destroy/{id}', 'TeamController@destroy')->name('teams.destroy');
    Route::get('switch/{id}', 'TeamController@switchTeam')->name('teams.switch');

    /*Route::get('members/{id}', 'TeamMemberController@show')->name('teams.members.show');
    Route::get('members/resend/{invite_id}', 'TeamMemberController@resendInvite')->name('teams.members.resend_invite');
    Route::post('members/{id}', 'TeamMemberController@invite')->name('teams.members.invite');
    Route::delete('members/{id}/{user_id}', 'TeamMemberController@destroy')->name('teams.members.destroy');*/

    Route::get('accept/{token}', 'AuthController@acceptInvite')->name('teams.accept_invite');
});

/**
 * Use a users page instead
 */
Route::group(['prefix' => 'users', 'namespace' => 'Teamwork'], function(){
    Route::get('/', 'TeamMemberController@show')->name('teams.members.show');
    Route::get('resend/{invite_id}', 'TeamMemberController@resendInvite')->name('teams.members.resend_invite');
    Route::post('/', 'TeamMemberController@invite')->name('teams.members.invite');
    Route::delete('/{user_id}', 'TeamMemberController@destroy')->name('teams.members.destroy');
});
