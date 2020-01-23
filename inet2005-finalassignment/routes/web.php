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

Route::get('/home', 'HomeController@index')->name('home');

//users
Route::resource('/admin/users', 'UsersController')->middleware('user_admin');
Route::post('/admin/users/filter', 'UsersController@filter')->middleware('user_admin');
Route::post('/admin/users/search', 'UsersController@search')->middleware('user_admin');
Route::post('/admin/users/{user}/restore', 'UsersController@restore')->middleware('user_admin');

//themes
Route::resource('/admin/themes', 'ThemesController')->middleware('theme_admin');
Route::post('/admin/themes/filter', 'ThemesController@filter')->middleware('theme_admin');
Route::get('/admin/themes/{theme}/restore', 'ThemesController@restore')->middleware('theme_admin');

//posts
Route::resource('/posts', 'PostsController');
Route::get('/feed', 'PostsController@index')->name('posts.index');
Route::post('/feed/cookie', 'PostsController@cookie')->name('feed.cookie');
Route::post('/posts/cookie', 'PostsController@postCookie')->name('posts.cookie');
Route::get('/ajax', 'PostsController@ajax');

//likes
Route::resource('/likes', 'LikesController');

//comments
Route::resource('/comments', 'CommentsController');

