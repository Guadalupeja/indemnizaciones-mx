<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Anti-spam: “honeypot”
        if ($request->filled('website')) {
            return back()->with('ok', 'Gracias.')->withInput(); // ignora bots
        }

        $data = $request->validate([
            'nombre'   => ['required','string','max:120'],
            'email'    => ['required','email','max:160'],
            'mensaje'  => ['required','string','min:10','max:5000'],
            'politica' => ['accepted'],
        ], [
            'nombre.required'   => 'Ingresa tu nombre.',
            'email.required'    => 'Ingresa tu correo.',
            'email.email'       => 'Formato de correo no válido.',
            'mensaje.required'  => 'Escribe tu mensaje.',
            'politica.accepted' => 'Debes aceptar la política de privacidad.',
        ]);

        // Enviar correo al buzón de contacto
        $destinatario = 'contacto@calculadoraindemnizacion.com';
        Mail::to($destinatario)->send(new ContactMessage($data));

        return redirect()->route('contacto.form')->with('ok', '¡Gracias! Tu mensaje fue enviado correctamente.');
    }
}
