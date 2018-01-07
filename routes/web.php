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

Auth::routes();

Route::get('auth/twitter', 'Auth\TwitterAuthController@redirectToProvider')->name('login');
Route::get('auth/twitter/callback', 'Auth\TwitterAuthController@handleProviderCallback');
Route::get('/logout', 'Auth\TwitterAuthController@logout');

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home');
Route::get('/tag/{tag}', 'TagController@list');

Route::resource('bookmarks', 'BookmarkController');
