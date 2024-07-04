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
     redirect()->route('login')->send();
})->name('home');


Route::get('/login',[\App\Http\Controllers\PageController::class,'page_login'])->name('login');
Route::get('/log_out',[\App\Http\Controllers\PageController::class,'log_out'])->name('log_out');
Route::middleware('user')->get('/panel',[\App\Http\Controllers\PageController::class,'page_panel'])->name('panel');
Route::middleware('user')->get('/panel/{page}',[\App\Http\Controllers\PageController::class,'page_panel'])->name('page');

Route::post('/login',[\App\Http\Controllers\ApiController::class,'login'])->name('api_login');
Route::post('/sub_traffic',[\App\Http\Controllers\ApiController::class,'sub_location'])->name('sub_traffic');
Route::get('/sub_playload',[\App\Http\Controllers\ApiController::class,'sub_playload'])->name('sub_playload');
Route::post('/sub_view_m',[\App\Http\Controllers\ApiController::class,'sub_view_m'])->name('sub_view_m');
Route::post('/get_active_users_namem',[\App\Http\Controllers\ApiController::class,'get_active_users_namem'])->name('get_active_users_namem_api');
Route::post('/get_code_sub_traffic',[\App\Http\Controllers\ApiController::class,'get_code_sub_traffic'])->name('get_code_sub_traffic');
Route::post('/sub_answer_ticket',[\App\Http\Controllers\ApiController::class,'sub_answer_ticket'])->name('sub_answer_ticket');
Route::post('/sub_ticket',[\App\Http\Controllers\ApiController::class,'sub_ticket'])->name('sub_ticket');
Route::post('/sub_repjop',[\App\Http\Controllers\ApiController::class,'sub_repjop'])->name('sub_repjop');
Route::post('/sub_new_vacation',[\App\Http\Controllers\ApiController::class,'sub_new_vacation'])->name('sub_new_vacation');

