<?php

use App\Http\Controllers\recordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    // Route::post('register', 'Api\AuthController@register');
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('refresh', 'Api\AuthController@refresh');
    Route::get('user', 'Api\AuthController@me');
});

//show allRecords
Route::get('/records', 'recordController@index');
//create record
Route::post('/records', 'recordController@store');
//user get records
Route::get('/records/user/{id}','recordController@getUserrecords');
//serch record id
Route::get('/records/{id}', 'recordController@show');//2


