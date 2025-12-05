<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CaseTestController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ContactController;

/* ===== Home / Calculadora principal ===== */
Route::get('/', [CalculatorController::class, 'form'])->name('inicio');
Route::post('/calcular', [CalculatorController::class, 'calculate'])->name('calculate');
Route::get('/calcular', fn () => redirect()->route('inicio'));

/* ===== Páginas informativas ===== */
Route::view('/que-es-indemnizacion', 'pages.que-es-indemnizacion')->name('que-es-indemnizacion');
Route::view('/que-es-liquidacion',   'pages.que-es-liquidacion')->name('que-es-liquidacion');
Route::view('/faq',                   'pages.faq')->name('faq');
Route::view('/aviso-privacidad',     'pages.aviso-privacidad')->name('aviso-privacidad');

/* ===== Test: ¿Indemnización o finiquito? ===== */
Route::get('/test-caso-laboral',  [CaseTestController::class, 'form'])->name('test-caso-laboral');
Route::post('/test-caso-laboral', [CaseTestController::class, 'decide'])->name('test-caso-laboral.decide');

/* ===== Estáticas SEO / Legales ===== */
Route::get('/sobre', [StaticPageController::class, 'sobre'])->name('sobre');
Route::view('/politica-de-cookies', 'pages.politica-cookies')->name('politica-cookies');
Route::view('/terminos-y-condiciones', 'pages.terminos')->name('terminos');

/* ===== Contacto (NOMBRES ÚNICOS) ===== */
// GET muestra el formulario
Route::get('/contacto', [ContactController::class, 'form'])->name('contacto');
// POST procesa el envío
Route::post('/contacto', [ContactController::class, 'send'])->name('contacto.send');

/* ===== Hubs ===== */
Route::view('/guias', 'pages.guias')->name('guias'); // (evita duplicado)
Route::view('/blog', 'pages.blog')->name('blog');
Route::view('/plantillas', 'pages.plantillas')->name('plantillas');

/* ===== Mini-calculadoras ===== */
Route::view('/calculadora-sdi',        'tools.sdi')->name('calc.sdi');
Route::view('/calculadora-aguinaldo',  'tools.aguinaldo')->name('calc.aguinaldo');
Route::view('/calculadora-vacaciones', 'tools.vacaciones')->name('calc.vacaciones');

/* ===== Sitemap XML y mapa HTML ===== */
Route::get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap.xml');
Route::view('/mapa-del-sitio', 'pages.mapa-sitio')->name('mapa-sitio');
