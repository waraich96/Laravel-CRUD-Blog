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



Route::get('/', 'PostController@all');

Route::get('/posts/{post}', 'PostController@single');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/posts', 'PostController@costumPosts')->name('posts');

Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');


Route::get('/{post}/comments', 'CommentController@index');
Route::post('/{post}/comments', 'CommentController@store');



Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('posts', 'PostController@index');
    Route::get('posts/{id}', 'PostController@show');
    Route::post('posts', 'PostController@store');
    Route::post('editPost/{id}', 'PostController@update');
    Route::delete('posts/{id}', 'PostController@destroy');
});