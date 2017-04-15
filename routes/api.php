<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/signup', 'Api\\UserController@create');
Route::post('/login', 'Api\\UserController@login');
Route::post('/getallportfolyo', 'Api\\UserController@getAllPortfolyo');
Route::post('/getimgportfolyo', 'Api\\UserController@getImgPortfolyo');

Route::resource('/contact', 'Api\\ContactController');
Route::post('/index', 'Api\\ContactController@index');

Route::post('/createorder', 'Api\\OrderController@createOrder');
Route::post('/getallorder', 'Api\\OrderController@getAllOrder');
Route::post('/getorder', 'Api\\OrderController@getOrder');
Route::post('/orderstatus', 'Api\\OrderController@orderStatus');
Route::post('/updateorder', 'Api\\OrderController@updateOrder');
Route::post('/deleteorder', 'Api\\OrderController@deleteOrder');
Route::post('/updatestatus', 'Api\\OrderController@updateStatus');

Route::post('/sendchatmsg', 'Api\\ChatController@sendChatMsg');
Route::post('/getchatcontact', 'Api\\ChatController@getChatContact');
Route::post('/getallcontact', 'Api\\ChatController@getAllContact');

Route::post('/makersignup', 'Api\\MakerController@makerSignp');
Route::post('/getallmaker', 'Api\\MakerController@getAllMaker');
Route::post('/getmaker', 'Api\\MakerController@getMaker');
Route::post('/updatemaker', 'Api\\MakerController@updateMaker');
Route::post('/deletemaker', 'Api\\MakerController@deleteMaker');
