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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/invites', 'ApiController@getAllInvites');
Route::get('/invites/pending', 'ApiController@getPendingInvites');
Route::get('/invites/completed', 'ApiController@getCompletedInvites');
Route::get('/users/admin', 'ApiController@getAdminUsers');
Route::get('/users/agent', 'ApiController@getAgentUsers');
Route::get('/find/admin/{phone}', 'ApiController@getAdminByPhone');
Route::get('/find/agent/{phone}', 'ApiController@getAgentByPhone');

Route::post('/invite/complete', 'ApiController@updateInviteStatus');
Route::post('/admin/create', 'ApiController@createAdmin');


