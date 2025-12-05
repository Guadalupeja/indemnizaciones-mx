<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StaticPageController extends Controller
{
    public function sobre()
    {
        return view('pages.sobre');
    }

    public function contacto(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('pages.contacto');
        }

        // Validar y (opcional) enviar correo / guardar en DB
        $data = $request->validate([
            'nombre'   => ['required','string','max:120'],
            'email'    => ['required','email','max:150'],
            'mensaje'  => ['required','string','max:4000'],
            'politica' => ['accepted'],
        ],[],[
            'nombre'  => 'nombre',
            'email'   => 'correo',
            'mensaje' => 'mensaje',
            'politica'=> 'política de privacidad',
        ]);

        // Si quieres email: configura .env y descomenta
        /*
        Mail::raw("Mensaje de {$data['nombre']} <{$data['email']}>:\n\n{$data['mensaje']}", function($m){
            $m->to('tu-correo@tu-dominio.com')->subject('Contacto desde calculadora laboral');
        });
        */

        return back()->with('ok','¡Gracias! Tu mensaje fue enviado. Te responderé pronto.');
    }
}

