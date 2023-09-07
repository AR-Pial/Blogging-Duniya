<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('login','login');
Route::get('login-req',[UserController::class,'login']);
Route::view('register','signup');
Route::post('register',[UserController::class,'register_user']);
Route::get('/', function () {
    if (session()->has('user_id')) {
        return redirect('home');
    } else {
        return view('login');
    }
});
Route::get('home',[PostController::class,'home_blogs']);
Route::get('profile',[UserController::class,'profile']);
Route::get('logout',[UserController::class,'logout']);

Route::get('create_blog',[PostController::class,'get_categories']);
Route::post('create_blog',[PostController::class,'create_post']);

Route::get('user_timeline',[UserController::class,'user_timeline']);
Route::view('community','community');
Route::get('user_posts',[UserController::class,'user_posts']);
Route::get('blog-page/{id}',[PostController::class,'blog_page'])->name('blog_page');
Route::get('get-blog',[PostController::class,'get_blog'])->name('get_blog');
Route::post('edit-blog',[PostController::class,'edit_blog'])->name('edit_blog');
Route::post('delete-blog',[PostController::class,'delete_blog'])->name('delete_blog');



