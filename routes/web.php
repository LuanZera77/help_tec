<?php

use App\Http\Controllers\ChamadoController;
use App\Models\Chamado;
use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    [ChamadoController::class, 'index']
)->name('home');
Route::post('/novo_chamado', [ChamadoController::class, 'create_chamado'])->name('create_chamado');
Route::delete('chamado/{id}', [ChamadoController::class, 'delete_chamado'])->name('delete_chamado');
Route::patch('chamado/{id}', [ChamadoController::class, 'update_status'])->name('update_status');