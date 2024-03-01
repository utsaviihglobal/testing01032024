<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubuserController;
use App\Http\Controllers\DropdownController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/sub-user', [SubuserController::class, 'index']);
Route::get('/create-sub-user', [SubuserController::class, 'create']);

Route::post('/create-sub-user', [SubuserController::class, 'store']);
Route::delete('/delete/{id}', [SubuserController::class, 'destroy']);

Route::get('/edit/{id}', [SubuserController::class, 'edit']);

Route::post('/create-sub-user-update', [SubuserController::class, 'update']);

Route::post('/fetch-states', [DropdownController::class, 'fetchState']);
Route::post('/fetch-cities', [DropdownController::class, 'fetchCity']);
