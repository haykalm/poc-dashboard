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
Route::post('people/taping_b',['as' => 'pembayaran.taping_b','uses' => 'App\Http\Controllers\PeopleController@taping_b']);
Route::post('people/taping_c',['as' => 'pembayaran.taping_c','uses' => 'App\Http\Controllers\PeopleController@taping_c']);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/dashboard', DashboardController::class);

Route::get('/people', [PeopleController::class, 'index']);
// submitform

// Route::resource('/people', PeopleController::class);

