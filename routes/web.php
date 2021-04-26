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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('user.home');
Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('admin.home')->middleware('Admin');
Route::post('/sotre', [App\Http\Controllers\UserController::class, 'store'])->name('store');
Route::get('/edit/{post}', [App\Http\Controllers\UserController::class, 'edit'])->name('edit');
Route::put('/update',[App\Http\Controllers\UserController::class, 'update'])->name('update');
Route::get('/calc', [App\Http\Controllers\UserController::class, 'calc'])->name('calc');
Route::get('/extraTime', [App\Http\Controllers\UserController::class, 'extraTime'])->name('extraTime');



