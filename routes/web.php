<?php

use App\Http\Controllers\ManageBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Livewire\UpdateProfile;
use Illuminate\Support\Facades\Session;

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




// Route::get('/', function () {
//     return view('components.layout');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::post('/changeLanguage', [HomeController::class, 'changeLanguage'])->name('home');
Route::get('locale/{locale}', function ($locale) {

    Session::put('locale', $locale);

    return redirect()->back();
})->name('switchLan');  //add name to router

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->middleware('guest')->name("login");
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');





Route::prefix('users')->middleware(['auth', 'role'])->group(function () {
    Route::get('',  [UserController::class, 'index'])->name("users.index");
    Route::get('/show',  [UserController::class, 'show'])->name("users.show");

    Route::post('',  [UserController::class, 'store'])->name("users.store");
    Route::post('/edit/{id}',  [UserController::class, 'edit'])->name("users.edit");

    Route::post('/{id}',  [UserController::class, 'update'])->name("users.update");
    Route::delete('/{id}',  [UserController::class, 'destroy'])->name("users.destroy");
});

Route::prefix('manageBlogs')->middleware(['auth'])->group(function () {
    Route::get('', [ManageBlogController::class, 'index'])->name("manageBlogs.index");
});
Route::prefix('blogs')->group(function () {
    Route::get('', [BlogController::class, 'index']);
    Route::get('load-more-data', [BlogController::class, 'loadMoreData']);

    Route::get('/{id}', [BlogController::class, 'show']);
    Route::post('/{id}', [BlogController::class, 'addRating']);

});

Route::get('profile', [ProfileController::class, 'index'])->middleware('auth');
