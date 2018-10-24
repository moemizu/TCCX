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
Route::post('/quest/create', 'TCCX\QuestController@createQuestPost');
// Edit quest
Route::get('/quest/edit', 'TCCX\QuestController@editQuest')->name('tccx.quest.edit');
Route::post('/quest/edit', 'TCCX\QuestController@updateQuest');
// Delete quest
Route::post('/quest/delete', 'TCCX\QuestController@deleteQuest');
// View quest
Route::get('/quest/view/{code}', 'TCCX\QuestController@getQuest')->name('tcx.quest.view');
Route::get('/quest/view/id/{id}', 'TCCX\QuestController@getQuestById')->name('tcx.quest.view.id')
    ->where('id', '[0-9]+');
// Assign
Route::post('/quest/assign', 'TCCX\QuestController@assignQuest');

// Quest Location
// view
Route::get('/quest/locations', 'TCCX\QuestLocationController@index')->name('tccx.quest.locations');
// create/edit
Route::get('/quest/location/edit', 'TCCX\QuestLocationController@edit')->name('tccx.quest.location.edit');
Route::post('/quest/location/edit', 'TCCX\QuestLocationController@editPost');
// delete
Route::post('/quest/location/delete', 'TCCX\QuestLocationController@delete');

//Route::get('/quest/zones','')->name('tccx.quests.locations');

//Route::get('/quest/types','')->name('tccx.quests.locations');

// People

// Team list
Route::get('/people/teams', 'TCCX\TeamController@index')->name('tccx.people.teams');