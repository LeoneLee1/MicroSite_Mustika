<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PollingController;

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
})->middleware('auth');

Route::get('/login',[LoginController::class,'login'])->name('login');
Route::post('/login/proses',[LoginController::class,'proses'])->name('login.proses');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');
Route::get('/login/register',[LoginController::class,'register'])->name('register');
Route::post('/login/register/insert',[LoginController::class,'insert'])->name('register.insert');

Route::get('/user',[UserController::class,'index'])->name('user');
Route::get('/user/create',[UserController::class,'create'])->name('user.create');
Route::post('/user/create/insert',[UserController::class,'insert'])->name('user.insert');
Route::get('/user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
Route::post('/user/edit/update/{id}',[UserController::class,'update'])->name('user.update');
Route::get('/user/delete/{id}',[UserController::class,'delete'])->name('user.delete');

Route::get('/post',[PostController::class,'index'])->name('post');
Route::post('/post/insert',[PostController::class,'insert'])->name('post.insert');

Route::get('/polling/create',[PollingController::class,'create'])->name('polling.create');
Route::post('/polling/create/insert',[PollingController::class,'insert'])->name('polling.insert');