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

Route::get('/', 'StaticController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/post', 'PostController@post');
Route::get('/profile', 'ProfileController@profile');
Route::post('/addProfile', 'ProfileController@addProfile');
Route::post('/addPost', 'PostController@addPost');
Route::get('/view/{id}', 'PostController@view');
Route::get('/edit/{id}', 'PostController@edit');
Route::post('/editPost/{id}', 'PostController@editPost');
Route::get('/delete/{id}', 'PostController@deletePost');
Route::post('/comment/{id}', 'PostController@comment');
Route::post('/comment-edit', 'PostController@editComment');
Route::get('/deleteComment/{id}', 'PostController@deleteComment');