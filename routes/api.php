<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
	PeopleController,
};

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/people', [PeopleController::class, 'store']);
Route::post('people/taping_b',['as' => 'pembayaran.taping_b','uses' => 'App\Http\Controllers\PeopleController@taping_b']);
Route::post('people/taping_c',['as' => 'pembayaran.taping_c','uses' => 'App\Http\Controllers\PeopleController@taping_c']);



