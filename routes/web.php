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

// Scoreboard
Route::get('/scoreboard', 'TCCX\ScoreboardController@index')->name('tccx.scoreboard');
Route::post('/scoreboard/change', 'TCCX\ScoreboardController@changeScore');

// Quest system

// Quest list
Route::redirect('/quest', '/quest/quests');
Route::get('/quest/quests', 'TCCX\QuestController@index')->name('tccx.quest.quests');
// Create a new quest
Route::get('/quest/create', 'TCCX\QuestController@createQuest')->name('tccx.quest.create');
Route::post('/quest/create', 'TCCX\QuestController@createQuest');

//Route::get('/quest/locations','')->name('tccx.quests.locations');

//Route::get('/quest/zones','')->name('tccx.quests.locations');

//Route::get('/quest/types','')->name('tccx.quests.locations');