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

Route::post("/login", ['uses' => 'LoginController@login']);

Route::post("/optional", ['uses' => 'OptionalController@store']);
Route::get("/optional", ['uses' => 'OptionalController@dispatcher']);
Route::get("/optional/{id}", ['uses' => 'OptionalController@dispatcher']);
Route::put("/optional/{id}", ['uses' => 'OptionalController@store']);
Route::delete("/optional/{id}", ['uses' => 'OptionalController@delete']);