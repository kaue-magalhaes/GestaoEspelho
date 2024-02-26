<?php

use App\Http\Controllers\ProfileController;
use App\Models\Promotor;
use App\Models\Promotoria;
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
    $promotores = Promotor::all();
    $promoorias = Promotoria::all();
    return Inertia::render('Espelho', [
        'promotores' => $promotores,
        'promotorias' => $promoorias
    ]);
})->middleware(['auth', 'verified'])->name('espelho');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test', function () {
    return Inertia::render('VerifyEmail');
})->name('test');

require __DIR__ . '/auth.php';
