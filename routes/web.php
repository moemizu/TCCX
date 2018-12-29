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

Route::view('/', 'home');

Auth::routes();

Route::redirect('/home', '/');

// Scoreboard
Route::get('/scoreboard', 'TCCX\ScoreboardController@index')->name('tccx.scoreboard');
Route::post('/scoreboard/change', 'TCCX\ScoreboardController@changeScore')->middleware('auth');

// Quest system

// Quest list
Route::redirect('/quest', '/quest/quests');
Route::get('/quest/quests', 'TCCX\QuestController@index')->name('tccx.quest.quests')->middleware('auth');
// Create a new quest
Route::get('/quest/create', 'TCCX\QuestController@createQuest')->name('tccx.quest.create')->middleware('auth');
Route::post('/quest/create', 'TCCX\QuestController@createQuestPost')->middleware('auth');
// Edit quest
Route::get('/quest/edit', 'TCCX\QuestController@editQuest')->name('tccx.quest.edit')->middleware('auth');
Route::post('/quest/edit', 'TCCX\QuestController@updateQuest')->middleware('auth');
// Delete quest
Route::post('/quest/delete', 'TCCX\QuestController@deleteQuest')->middleware('auth');
// View quest
Route::get('/quest/view/{code}', 'TCCX\QuestController@getQuest')->name('tcx.quest.view')->middleware('auth');
Route::get('/quest/view/id/{id}', 'TCCX\QuestController@getQuestById')->name('tcx.quest.view.id')->middleware('auth')
    ->where('id', '[0-9]+');
Route::get('/quest/view-all', 'TCCX\QuestController@getAllQuest')->name('tccx.quest.view-all')->middleware('auth');
// Assign
Route::post('/quest/assign', 'TCCX\QuestController@assignQuest')->middleware('auth');
// Finish
Route::post('/quest/finish', 'TCCX\QuestController@finishQuest')->middleware('auth');

// Quest Location
// view
Route::get('/quest/locations', 'TCCX\QuestLocationController@index')->name('tccx.quest.locations')->middleware('auth');
// create/edit
Route::get('/quest/location/edit', 'TCCX\QuestLocationController@edit')->name('tccx.quest.location.edit')->middleware('auth');
Route::post('/quest/location/edit', 'TCCX\QuestLocationController@editPost')->middleware('auth');
// delete
Route::post('/quest/location/delete', 'TCCX\QuestLocationController@delete')->middleware('auth');
// tracking
Route::get('/quest/tracking', 'TCCX\QuestTrackingController@index');
Route::post('/quest/tracking/set-group', 'TCCX\QuestTrackingController@setGroup')->middleware('auth');
Route::post('/quest/tracking/set-item', 'TCCX\QuestTrackingController@setItem')->middleware('auth');

//Route::get('/quest/zones','')->name('tccx.quests.locations');

//Route::get('/quest/types','')->name('tccx.quests.locations');

// People

// Team list
Route::get('/people/teams', 'TCCX\TeamController@index')->name('tccx.people.teams')->middleware('auth');

// GATE Land
Route::get('/gate-land', 'TCCX\GateLandController@index')->name('tccx.gate_land');