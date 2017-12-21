<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('auth/twitter', 'Auth\TwitterAuthController@redirectToProvider')->name('login');
Route::get('auth/twitter/callback', 'Auth\TwitterAuthController@handleProviderCallback');
Route::get('auth/twitter/logout', 'Auth\TwitterAuthController@logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('bookmarks', 'BookmarkController');
