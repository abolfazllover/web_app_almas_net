<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
})->name('home');


Route::get('/login',[\App\Http\Controllers\PageController::class,'page_login'])->name('login');
Route::middleware('user')->get('/panel',[\App\Http\Controllers\PageController::class,'page_panel'])->name('panel');
Route::middleware('user')->get('/panel/{page}',[\App\Http\Controllers\PageController::class,'page_panel'])->name('page');

Route::post('/login',[\App\Http\Controllers\ApiController::class,'login'])->name('api_login');
