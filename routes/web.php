<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['web']], function () {
    Route::get('/play', 'PlayController@index');
    Route::get('/reset', 'PlayController@reset');
    Route::post('ajaxRequest', 'PlayController@ajaxGuessCharPost')->name('ajaxRequest.post');
});