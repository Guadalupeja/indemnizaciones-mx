<?php
use App\Http\Controllers\CalculatorController;

use Illuminate\Support\Facades\Route;

Route::get('/', [CalculatorController::class, 'form'])
        ->name('inicio');          // Página principal con el formulario

Route::post('/calcular', [CalculatorController::class, 'calculate'])
        ->name('calculate');     // Procesa la petición POST