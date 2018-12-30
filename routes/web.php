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
Route::post('/scoreboard/change', 'TCCX\ScoreboardController@changeScore')->middleware('auth', 'can:manage_scoreboard');

// Quest system
// tracking
Route::get('/quest/tracking', 'TCCX\QuestTrackingController@index');

// Quest list
Route::redirect('/quest', '/quest/quests');
Route::get('/quest/quests', 'TCCX\QuestController@index')->name('tccx.quest.quests')->middleware('auth');
// View quest
Route::get('/quest/view/{code}', 'TCCX\QuestController@getQuest')->name('tcx.quest.view')->middleware('auth');
Route::get('/quest/view/id/{id}', 'TCCX\QuestController@getQuestById')->name('tcx.quest.view.id')->middleware('auth')
    ->where('id', '[0-9]+');
Route::get('/quest/view-all', 'TCCX\QuestController@getAllQuest')->name('tccx.quest.view-all')->middleware('auth');

Route::middleware(['auth', 'can:mange_quest'])->group(function () {
    // General
    // Create a new quest
    Route::get('/quest/create', 'TCCX\QuestController@createQuest')->name('tccx.quest.create');
    Route::post('/quest/create', 'TCCX\QuestController@createQuestPost');
    // Edit quest
    Route::get('/quest/edit', 'TCCX\QuestController@editQuest')->name('tccx.quest.edit');
    Route::post('/quest/edit', 'TCCX\QuestController@updateQuest');
    // Delete quest
    Route::post('/quest/delete', 'TCCX\QuestController@deleteQuest');
    // Assign
    Route::post('/quest/assign', 'TCCX\QuestController@assignQuest');
    // Finish
    Route::post('/quest/finish', 'TCCX\QuestController@finishQuest');
    // Quest Location
    // view
    Route::get('/quest/locations', 'TCCX\QuestLocationController@index')->name('tccx.quest.locations');
    Route::get('/quest/location/edit', 'TCCX\QuestLocationController@edit');
    Route::post('/quest/location/edit', 'TCCX\QuestLocationController@editPost');
    // delete
    Route::post('/quest/location/delete', 'TCCX\QuestLocationController@delete');
    // tracking
    Route::post('/quest/tracking/set-group', 'TCCX\QuestTrackingController@setGroup');
    Route::post('/quest/tracking/set-item', 'TCCX\QuestTrackingController@setItem');
});

// GATE Land
Route::get('/gate-land', 'TCCX\GateLandController@index')->name('tccx.gate_land');