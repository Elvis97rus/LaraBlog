<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Services\Constants;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// Routes for switching language to 'ru'
Route::get('/locale-ru', function () {
    session(['locale' => 'ru']);
    return redirect()->route('home');
})->name('locale.ru');

// Routes for switching language to 'en'
Route::get('/locale-en', function () {
    session(['locale' => 'en']);
    return redirect()->route('home.en');
})->name('locale.en');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('en')->group(function () {
    Route::get('/', [PostController::class, 'home'])->name('home.en');
    Route::get('/search', [PostController::class, 'search'])->name('post.search.en');
    Route::get('/category/{category:slug}', [PostController::class, 'byCategory'])->name('post.by-category.en');
    Route::get('/about-us', [SiteController::class, 'about'])->name('page.about-us.en');
    Route::get('/{post:slug}', [PostController::class, 'show'])->name('post.show.en');
});

Route::get('/', [PostController::class, 'home'])->name('home');
Route::get('/search', [PostController::class, 'search'])->name('post.search');
Route::get('/category/{category:slug}', [PostController::class, 'byCategory'])->name('post.by-category');
Route::get('/about-us', [SiteController::class, 'about'])->name('page.about-us');
Route::get('/{post:slug}', [PostController::class, 'show'])->name('post.show');
