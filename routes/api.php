<?php

use App\Http\Controllers\recordController;
use Illuminate\Http\Request;
// use Illuminate\Routing\Route;

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
//show allRecords
Route::get('/records','recordController@index');
//create record
Route::post('/records','recordController@store');
//serch record keyword
Route::get('/records/keyword','recordController@serchRecord');//１
//serch record id
Route::get('/records/{id}','recordController@show');//2

Route::post('/register','Api\AuthController@register');



