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

Route::get('/image', 'DemoController@image_form');
Route::post('/image', 'DemoController@image_save');
Route::get('/image/{filename}', 'DemoController@image_show');
Route::get('/demo', function() {
  return view('demo');
});