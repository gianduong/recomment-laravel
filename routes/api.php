<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuleController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// algorithm
Route::get('algorithm', 'App\Http\Controllers\AlgorithmController@reading');
Route::get('mark', 'App\Http\Controllers\MarkController@mark');

// entities
Route::get('rule/type', 'App\Http\Controllers\RuleController@distinctType');
Route::get('rule/{id}', 'App\Http\Controllers\RuleController@getById');
Route::resource('rule', RuleController::class);

Route::get('event/type', 'App\Http\Controllers\RuleController@distinctType');
Route::get('event/{id}', 'App\Http\Controllers\RuleController@getById');
Route::resource('event', RuleController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
