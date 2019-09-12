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


//return JSON listing users and how many seconds they have logged
Route::get('user-timelogs', 'TimeKeeperController@userTimelogs');


//return JSON describing how many users worked on the component, and how many seconds were logged in total
Route::get('component-metadata', 'TimeKeeperController@componentMetaData');


