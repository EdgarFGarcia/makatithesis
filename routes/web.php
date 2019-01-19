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
    return view('main');
});

Auth::routes();

// Route::group(['middleware' => ['preventbackhistory']], function () {

//     Route::group(['middleware' => ['checkislogin']], function () {
//         Route::get('/', 'API\MainController@index');
//         Route::get('/login', 'API\MainController@index')->name('login');
//     });
    
//     Route::group(['middleware' => ['checkisuser']], function () {
//         Route::get('/main', 'API\MainController@login');
//     });

// });

Route::get('/home', 'HomeController@index')->name('home');
Route::post('login', 'API\MainController@login');
Route::get('logout', 'API\MainController@logout');
Route::get('sales', 'API\MainController@sales');