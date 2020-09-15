<?php

use App\Http\Controllers\recordController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:airlock']], function () {
    Route::get('user', function (Request $request) {
        return response()->json(['user' => $request->user()]);
    });
    Route::post('logout', 'Api\LoginController@logout')->name('api.logout');
});

Route::post('/register', 'Api\RegisterController@register')->name('api.register');
Route::post('/login', 'Api\LoginController@login')->name('api.login');


//show allRecords
Route::get('/records','recordController@index');
//create record
Route::post('/records','recordController@store');
//serch record keyword
Route::get('/records/keyword','recordController@serchRecord');//１
//serch record id
Route::get('/records/{id}','recordController@show');//2





