<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [MemoController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/memos', [MemoController::class, 'store'])->middleware(['auth', 'verified'])->name('memos.store');
Route::get('/memos/edit/{memo}', [MemoController::class, 'edit'])->middleware(['auth', 'verified'])->name('memos.edit');
Route::put('/memos/{memo}', [MemoController::class, 'update'])->middleware(['auth', 'verified'])->name('memos.update');
Route::delete('/memos/{memo}', [MemoController::class, 'destroy'])->middleware(['auth', 'verified'])->name('memos.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
