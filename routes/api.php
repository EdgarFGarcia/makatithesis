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
Route::post('appoint', 'API\MainController@appoint');
Route::get('loadAppointment', 'API\MainController@loadAppointment');
Route::get('loadTableUser', 'API\MainController@loadTableUser');

// load user data appointment
Route::post('loadDataAppointment', 'API\MainController@loadDataAppointment');

Route::post('approveAppointment', 'API\MainController@approveAppointment');
Route::post('approveAppointmentDone', 'API\MainController@approveAppointmentDone');