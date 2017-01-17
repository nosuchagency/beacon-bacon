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

/**
 * WEB ROUTES
 */

//Route::auth();
Auth::routes();

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::resource('places', 'PlaceController');
Route::resource('pois', 'PoiController');
Route::resource('findables', 'FindableController');
Route::resource('blocks', 'BlockController');

Route::get('beacons/import', ['as' => 'beacons.import', 'uses' => 'BeaconController@import']);
Route::post('beacons/import', ['as' => 'beacons.importing', 'uses' => 'BeaconController@importing']);
Route::resource('beacons', 'BeaconController');

Route::group(['prefix' => 'places/{place}'], function(){

	/* Menu Routes */
    Route::post('menu', ['as' => 'menu.store', 'uses' => 'PlaceController@storeMenuItem']);
    Route::post('menu/order', ['as' => 'menu.update', 'uses' => 'PlaceController@updateMenuOrder']);
    Route::delete('menu', ['as' => 'menu.destroy', 'uses' => 'PlaceController@destroyMenuItem']);

	/* Floors Routes */
    Route::get('floors', ['as' => 'floors.index', 'uses' => 'FloorController@index']);
    Route::get('floors/create', ['as' => 'floors.create', 'uses' => 'FloorController@create']);
    Route::post('floors', ['as' => 'floors.store', 'uses' => 'FloorController@store']);
    Route::get('floors/{floor}', ['as' => 'floors.show', 'uses' => 'FloorController@show']);
    Route::get('floors/{floor}/edit', ['as' => 'floors.edit', 'uses' => 'FloorController@edit']);
    Route::put('floors/{floor}', ['as' => 'floors.update', 'uses' => 'FloorController@update']);
    Route::delete('floors/{floor}', ['as' => 'floors.destroy', 'uses' => 'FloorController@destroy']);



    Route::group(['prefix' => 'floors/{floor}'], function(){
        // Locations
        Route::get('locations', ['as' => 'locations.index', 'uses' => 'LocationController@index']);
        Route::get('locations/create/{type}', ['as' => 'locations.create', 'uses' => 'LocationController@create']);
        Route::post('locations', ['as' => 'locations.store', 'uses' => 'LocationController@store']);
        Route::get('locations/{location}', ['as' => 'locations.show', 'uses' => 'LocationController@show']);
        Route::get('locations/{location}/edit', ['as' => 'locations.edit', 'uses' => 'LocationController@edit']);
        Route::put('locations/{location}', ['as' => 'locations.update', 'uses' => 'LocationController@update']);
        Route::delete('locations/{location}', ['as' => 'locations.destroy', 'uses' => 'LocationController@destroy']);
    });
});

// Teamwork routes
Route::group(['prefix' => 'teams', 'namespace' => 'Teamwork'], function()
{
    Route::get('/', 'TeamController@index')->name('teams.index');
    Route::get('switch/{id}', 'TeamController@switchTeam')->name('teams.switch');

    // For now we dont allow user creation of teams
    //Route::get('create', 'TeamController@create')->name('teams.create');
    //Route::post('teams', 'TeamController@store')->name('teams.store');
    //Route::get('edit/{id}', 'TeamController@edit')->name('teams.edit');
    //Route::put('edit/{id}', 'TeamController@update')->name('teams.update');
    //Route::delete('destroy/{id}', 'TeamController@destroy')->name('teams.destroy');

    // We rewrite these a bit further down
    // Route::get('members/{id}', 'TeamMemberController@show')->name('teams.members.show');
    // Route::get('members/resend/{invite_id}', 'TeamMemberController@resendInvite')->name('teams.members.resend_invite');
    // Route::post('members/{id}', 'TeamMemberController@invite')->name('teams.members.invite');
    // Route::delete('members/{id}/{user_id}', 'TeamMemberController@destroy')->name('teams.members.destroy');

    Route::get('accept/{token}', 'AuthController@acceptInvite')->name('teams.accept_invite');
});

// Use a "users" route instead of the default "members"
Route::group(['prefix' => 'users', 'namespace' => 'Teamwork'], function(){
    Route::get('/', 'TeamMemberController@show')->name('teams.members.show');
    Route::post('/', 'TeamMemberController@store')->name('teams.members.store');
    Route::get('resend/{invite_id}', 'TeamMemberController@resendInvite')->name('teams.members.resend_invite');
    Route::delete('invite/{invite_id}', 'TeamMemberController@deleteInvite')->name('teams.members.delete_invite');
    Route::post('/invite', 'TeamMemberController@invite')->name('teams.members.invite');
    Route::delete('/{user_id}/uninvite', 'TeamMemberController@uninvite')->name('teams.members.uninvite');
    Route::delete('/{user_id}', 'TeamMemberController@destroy')->name('teams.members.destroy');
});

Route::group(['middleware' => 'auth'], function(){
    // Profile routes
    Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    // Api keys
    Route::get('apikeys', ['as' => 'apikeys.index', 'uses' => 'ApiController@index']);
    Route::post('apikeys', ['as' => 'apikeys.store', 'uses' => 'ApiController@store']);
    Route::delete('apikeys/{id}', ['as' => 'apikeys.destroy', 'uses' => 'ApiController@destroy']);

    // Settings
    Route::get('settings/email', ['as' => 'settings.email', 'uses' => 'SettingController@email']);
    Route::put('settings/email', ['as' => 'settings.email.update', 'uses' => 'SettingController@emailUpdate']);
    Route::get('settings/templates', ['as' => 'settings.templates', 'uses' => 'SettingController@templates']);
    Route::put('settings/templates', ['as' => 'settings.templates.update', 'uses' => 'SettingController@templatesUpdate']);

    Route::get('/logout', 'Auth\LoginController@logout');
});

/**
 * API ROUTES
 */

Route::group(['prefix' => 'api', 'namespace' => 'API', 'middleware' => 'auth:api'], function(){
    Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function(){
        // Profile routes
        Route::get('profile', ['uses' => 'ProfileController@index']);
        Route::put('profile', ['uses' => 'ProfileController@update']);

        // Places
        Route::get('place', ['uses' => 'PlaceController@index']);
        Route::get('place/deleted', ['uses' => 'PlaceController@deleted']);
        Route::get('place/{id}', ['uses' => 'PlaceController@show']);
        Route::put('place/{id}', ['uses' => 'PlaceController@update']);
        Route::delete('place/{id}', ['uses' => 'PlaceController@destroy']);

        Route::group(['prefix' => 'place/{id}'], function(){
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
    });
});
