<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'home'])->name('principal');
Route::post('/gerador', [MainController::class, 'geradorExercicios'])->name('gerador');
Route::get('/lista', [MainController::class, 'listarExercicios'])->name('listar');
Route::get('/exportar', [MainController::class, 'exportarExercicios'])->name('exportar');
