<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/image', 'ImageController@form');
Route::post('/image', 'ImageController@save');
Route::get('/image', 'ImageController@display_image_page');
Route::get('/image_data', 'ImageController@show');

Route::post('/profile_image', 'ImageController@save_profile_image');
Route::post('/contact_image', 'ImageController@save_contact_image');

Route::get('/demo', function() {
  return view('demo');
});

/* API ROUTES WILL DEFINE HERE */
Route::get('/signup', function() {dd("cool"); });