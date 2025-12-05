<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function xml()
    {
        // Lista básica de URLs. Agrega aquí todas las vistas públicas importantes.
        $urls = [
            route('inicio'),
            route('calculate'),  // aunque redirige, no es indispensable listarla
            route('que-es-indemnizacion'),
            route('que-es-liquidacion'),
            route('faq'),
            route('aviso-privacidad'),
            route('test-caso-laboral'),
            route('sobre'),
            route('contacto'),
            route('politica-cookies'),
            route('terminos'),
            route('guias'),
            route('blog'),
            route('plantillas'),
            route('mapa-sitio'),
            route('calc.sdi'),
            route('calc.aguinaldo'),
            route('calc.vacaciones'),
        ];

        $updated = now()->toAtomString();

        $xml = view('sitemap.xml', compact('urls','updated'))->render();

        return Response::make($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
