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
