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

// TODO: new authentication pages
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/scoreboard', 'TCCX\ScoreboardController@index')->name('tccx.scoreboard');

// Quest system
//Route::get('/quest/quests','')->name('tccx.quests');

//Route::get('/quest/locations','')->name('tccx.quests.locations');

//Route::get('/quest/zones','')->name('tccx.quests.locations');

//Route::get('/quest/types','')->name('tccx.quests.locations');