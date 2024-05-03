<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\EspelhoController;
use App\Http\Controllers\Promotoria;
use App\Http\Controllers\PromotoriaController;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [EspelhoController::class, 'editor'])->name('espelho.editor');
    Route::get('/espelho/historico/{id}', [EspelhoController::class, 'show'])->name('espelho.show');
    Route::put('/espelho/{id}', [EspelhoController::class, 'update'])->name('espelho.update');
    Route::post('/espelho/publicar/{id}', [EspelhoController::class, 'publish'])->name('espelho.publish');
    Route::get('/espelho/historico', [EspelhoController::class, 'history'])->name('espelho.history');

    Route::get('/area-do-administrador', Admin\DashboardController::class)->name('admin.dashboard');
    Route::get('/area-do-administrador/promotorias', Admin\PromotoriasController::class)->name('admin.promotorias');

    Route::post('/promotoria/store', [PromotoriaController::class, 'store'])->name('promotoria.store');
    Route::put('/promotoria/update/{promotoria}', Promotoria\UpdateController::class)->name('promotoria.update');
    Route::delete('/promotoria/destroy/{promotoria}', [PromotoriaController::class, 'destroy'])->name('promotoria.destroy');
});

Route::get('/espelho', [EspelhoController::class, 'index'])->name('espelho.index');

Route::get('/test', function () {
    return Inertia::render('VerifyEmail');
})->name('test');

require __DIR__ . '/auth.php';
