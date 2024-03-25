<?php

use App\Http\Controllers\EspelhoController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [EspelhoController::class, 'editor'])
    ->middleware('auth', 'verified')
    ->name('espelho.editor');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('/espelho{id}', [EspelhoController::class, 'update'])->name('espelho.update');
    Route::post('/espelho/publicar/{id}', [EspelhoController::class, 'publish'])->name('espelho.publish');
});

Route::get('/espelho', [EspelhoController::class, 'index'])->name('espelho.index');

Route::get('/test', function () {
    return Inertia::render('VerifyEmail');
})->name('test');

require __DIR__ . '/auth.php';
