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
// dd(1);
Route::get('/', 'StaticController@index');
Route::get('/myPosts', 'HomeController@index')->name('home');
Route::get('/create-post', 'PostController@createPost');
Route::post('/addPost', 'PostController@addPost');
Route::get('/view/{id}', 'PostController@view');
Route::get('/edit/{id}', 'PostController@edit');
Route::post('/editPost/{id}', 'PostController@editPost');
Route::get('/delete/{id}', 'PostController@deletePost');
Route::get('/deletePath/{id}/{postid}', 'PostController@deletePath');
Route::post('/comment/{id}', 'PostController@comment');
Route::post('/comment-edit', 'PostController@editComment');
Route::get('/deleteComment/{id}', 'PostController@deleteComment');
Route::post('/addCommentCom/{id}', 'PostController@addCommentCom');
Route::post('/commentCom-edit', 'PostController@editCommentCom');
Route::get('/deleteCommentCom/{id}', 'PostController@deleteCommentCom');
Route::post('/profile', 'PostController@addProfileImage');
Route::get('/admin', 'AdminController@index');
Route::post('/add-like', 'PostController@addLike');
Route::post('/add-comment-like', 'PostController@addCommentLike');
Route::get('/deleteCommentCom/{id}', 'PostController@deleteCommentCom');
Route::get('/addFriend/{id}', 'PostController@sendFrienqRequest');
Route::get('/undoRequest/{id}', 'PostController@undoRequest');
Route::get('/deleteFriend/{id}', 'PostController@deleteFriend');
Route::get('/acceptFriend/{id}', 'PostController@acceptRequest');
Route::get('/liveSearch/action', 'PostController@action');   


