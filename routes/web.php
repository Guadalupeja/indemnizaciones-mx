<?php
use App\Http\Controllers\CalculatorController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaseTestController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ContactController;



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

/* Test: ¿Me corresponde indemnización o finiquito? */
Route::get('/test-caso-laboral',  [CaseTestController::class, 'form'])->name('test-caso-laboral');
Route::post('/test-caso-laboral', [CaseTestController::class, 'decide'])->name('test-caso-laboral.decide');


/* ========= Páginas estáticas SEO / Legales ========= */
Route::get('/sobre',               [StaticPageController::class, 'sobre'])->name('sobre');
Route::match(['get','post'],'/contacto', [StaticPageController::class, 'contacto'])->name('contacto'); // GET muestra, POST procesa
Route::view('/politica-de-cookies','pages.politica-cookies')->name('politica-cookies');
Route::view('/terminos-y-condiciones','pages.terminos')->name('terminos');

/* ========= Hubs de contenido ========= */
Route::view('/guias',          'pages.guias')->name('guias');
Route::view('/blog',           'pages.blog')->name('blog'); // índice del blog
Route::view('/plantillas',     'pages.plantillas')->name('plantillas');

/* ========= Mini-calculadoras (simples) ========= */
Route::view('/calculadora-sdi',        'tools.sdi')->name('calc.sdi');
Route::view('/calculadora-aguinaldo',  'tools.aguinaldo')->name('calc.aguinaldo');
Route::view('/calculadora-vacaciones', 'tools.vacaciones')->name('calc.vacaciones');

/* ========= Sitemap XML y Mapa del sitio (HTML) ========= */
Route::get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap.xml');
Route::view('/mapa-del-sitio', 'pages.mapa-sitio')->name('mapa-sitio');

Route::view('/guias', 'pages.guias')->name('guias');

Route::view('/guia-indemnizacion', 'pages.guia-indemnizacion')->name('guia-indemnizacion');
Route::view('/guia-vacaciones', 'pages.guia-vacaciones')->name('guia-vacaciones');
Route::view('/guia-aguinaldo', 'pages.guia-aguinaldo')->name('guia-aguinaldo');
Route::view('/guia-prima-antiguedad', 'pages.guia-prima-antiguedad')->name('guia-prima-antiguedad');

Route::view('/contacto', 'pages.contacto')->name('contacto.form'); // tu vista
Route::post('/contacto', [ContactController::class, 'send'])->name('contacto');