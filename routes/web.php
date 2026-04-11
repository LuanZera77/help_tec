<?php

use App\Http\Controllers\ChamadoController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    [ChamadoController::class, 'index']
);
