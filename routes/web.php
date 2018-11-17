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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','PagesController@index');
Route::get('/about','PagesController@about');
Route::get('/services','PagesController@services');
Route::get('/create','PagesController@create');

Route::resource('posts', 'PostsController');
Auth::routes();

Route::get('auth/admin', 'AdminController@index')->name('admin');

//Admin Posts Area
Route::resource('auth/posts', 'AuthPostController');

//Import Area
Route::get('auth/tools/import', 'ImportController@index')->name('import');
Route::get('auth/tools/import/wp', 'WPImportController@import');
Route::resource('wp', 'WPImportController');
Route::get('auth/tools/import/m2', 'M2ImportController@import');
Route::resource('m2', 'M2ImportController');