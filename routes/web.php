<?php

use App\Http\Controllers\ChamadoController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    [ChamadoController::class, 'index']
);
Route::post('/novo_chamado', [ChamadoController::class, 'novo_chamado']);