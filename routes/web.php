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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/agent/invite', 'AgentController@inviteAgent');

Route::get('/invite/agent/{name}', 'AgentController@showForm');

Route::get('/info/{status}', 'HomeController@showStatus');

Route::post('/agent/invite', 'AgentController@storeAgentInvite');

Route::post('/agent/new', 'AgentController@createAgent');
