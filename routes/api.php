<?php

use App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/usuarios', API\Users\ListController::class)->name('api.users.list');
Route::get('/espelho', API\Espelho\ListController::class)->name('api.espelho.list');
Route::get('/promotores', API\Promotores\ListController::class)->name('api.promotores.list');

Route::get('/urgencia-atendimentos', API\UrgenciaAtendimentos\ListController::class)->name('api.urgencia-atendimentos.list');
