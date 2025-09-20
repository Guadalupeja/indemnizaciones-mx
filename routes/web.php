<?php
use App\Http\Controllers\CalculatorController;

use Illuminate\Support\Facades\Route;

Route::get('/', [CalculatorController::class, 'form'])
        ->name('inicio');          // Página principal con el formulario

Route::post('/calcular', [CalculatorController::class, 'calculate'])
        ->name('calculate');     // Procesa la petición POST

        /* Evitar 404 si alguien abre /calcular en GET (recarga, marcador, etc.) */
Route::get('/calcular', fn () => redirect()->route('inicio'));

/* Páginas informativas (vistas planas) */
Route::view('/que-es-indemnizacion', 'pages.que-es-indemnizacion')->name('que-es-indemnizacion');
Route::view('/que-es-liquidacion',   'pages.que-es-liquidacion')->name('que-es-liquidacion');
Route::view('/faq',                   'pages.faq')->name('faq');
Route::view('/aviso-privacidad',      'pages.aviso-privacidad')->name('aviso-privacidad');