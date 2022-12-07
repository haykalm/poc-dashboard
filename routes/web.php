<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
	DashboardController,
	PeopleController,
};

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
    return view('auth.login');
});

Auth::routes();

Route::get('/tap', [PeopleController::class, 'submitform']);
Route::post('/people', [PeopleController::class, 'store'])->name('submit-form-a');
Route::get('people/detail_absent',['as' => 'people.detail_absent','uses' => 'App\Http\Controllers\PeopleController@detail_absent']);
Route::get('/people', [PeopleController::class, 'index']);

Route::resource('/dashboard', DashboardController::class);

// Route::resource('/people', PeopleController::class);

