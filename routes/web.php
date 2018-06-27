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

/* auto generates all routes relating to authentication
 * register
 * login
 */
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/agent/invite', 'AgentController@inviteAgent');

//only guest i.e logged out users should be able to access the create agent form
//since you can be logged in when creating a new account (agent account) 
//and also it's is not the logged in admin that will create the account
//hence you can't be logged in.
Route::get('/invite/agent/{name}', 'AgentController@showForm');

Route::get('/info/{status}', 'HomeController@showStatus');

Route::post('/agent/invite', 'AgentController@storeAgentInvite');

Route::post('/agent/new', 'AgentController@createAgent');
