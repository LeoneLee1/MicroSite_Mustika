<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PollingController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\DashboardController;

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

// DASHBOARD CONTROLLER
Route::get('/',[DashboardController::class,'index'])->name('/')->middleware('auth');
Route::get('/chart/json/{id}',[DashboardController::class,'chart'])->name('chart.json');
Route::post('/like/{postId}',[DashboardController::class,'like'])->name('like.post');
Route::post('/save/{id}',[DashboardController::class,'save'])->name('save');
Route::get('/viewVote/{id}',[DashboardController::class,'viewVote'])->name('viewVote');

// LOGIN CONTROLLER
Route::get('/login',[LoginController::class,'login'])->name('login');
Route::post('/login/proses',[LoginController::class,'proses'])->name('login.proses');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');
Route::get('/login/register',[LoginController::class,'register'])->name('register');
Route::post('/login/register/insert',[LoginController::class,'insert'])->name('register.insert');


// POST CONTROLLER
Route::get('/comment/{id}',[PostController::class,'viewComment'])->name('comment');
Route::post('/comment/insert',[PostController::class,'komen'])->name('comment.insert');
Route::get('/comment/delete/{id_comment}',[PostController::class,'deleteComment'])->name('comment.delete');
Route::get('/post',[PostController::class,'index'])->name('post');
Route::post('/post/insert',[PostController::class,'insert'])->name('post.insert');
Route::get('/post/lihat/{id}',[PostController::class,'lihat'])->name('post.lihat');
Route::get('/search', [PostController::class, 'search'])->name('post.search');
Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
Route::post('/post/edit/update/{id}', [PostController::class, 'update'])->name('post.update');
Route::post('/post/edit/update/soal/{id_post}', [PostController::class, 'updateSoal'])->name('post.update.soal');
Route::post('/post/edit/update/jawaban/{id_post}', [PostController::class, 'updateJawaban'])->name('post.update.jawaban');
Route::get('/post/delete/{id}',[PostController::class,'delete'])->name('post.delete');


// USER CONTROLLER
Route::get('/user',[UserController::class,'index'])->name('user');
Route::get('/user/json',[UserController::class,'json'])->name('user.json');
Route::get('/user/create',[UserController::class,'create'])->name('user.create');
Route::post('/user/create/insert',[UserController::class,'insert'])->name('user.insert');
Route::get('/user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
Route::post('/user/edit/update/{id}',[UserController::class,'update'])->name('user.update');
Route::get('/user/delete/{id}',[UserController::class,'delete'])->name('user.delete');
Route::get('/register/data',[UserController::class,'dataRegis'])->name('user.regis');
// Route::get('/register/data/cari',[UserController::class,'dataRegisCari'])->name('user.regis.cari');
Route::post('/register/data/approve/{id}',[UserController::class,'dataRegisApprove'])->name('user.approve');
Route::get('/register/data/reject/{id}',[UserController::class,'dataRegisReject'])->name('user.reject');
Route::get('/profile',[UserController::class,'profile'])->name('profile');
Route::get('/profile/tersimpan',[UserController::class,'tersimpan'])->name('profile.tersimpan');
Route::get('/profile/tersimpan/delete/{id}',[UserController::class,'tesimpanDelete'])->name('profile.tersimpanDelete');
Route::get('/profile/edit',[UserController::class,'profileEdit'])->name('profile.edit');
Route::post('/profile/edit/insert',[UserController::class,'profileInsert'])->name('profile.insert');


// POLLING CONTROLLER
Route::get('/polling/create',[PollingController::class,'create'])->name('polling.create');
Route::post('/polling/create/insert',[PollingController::class,'insert'])->name('polling.insert');
Route::post('/vote/{answerId}',[PollingController::class,'vote'])->name('vote');
Route::get('/vote/view/{poll_id}',[PollingController::class,'viewVotes'])->name('vote.view');


// ANALISIS CONTROLLER
Route::get('/analysis',[AnalisisController::class,'chart'])->name('analysis');

// ACTIVITY CONTROLLER
Route::get('/activity',[ActivityController::class,'index'])->name('activity');
Route::get('/activity/likes',[ActivityController::class,'likes'])->name('activity.likes');
Route::get('/activity/comments',[ActivityController::class,'comments'])->name('activity.comments');
Route::get('/activity/posts',[ActivityController::class,'posts'])->name('activity.posts');
Route::get('/activity/voting',[ActivityController::class,'voting'])->name('activity.voting');

