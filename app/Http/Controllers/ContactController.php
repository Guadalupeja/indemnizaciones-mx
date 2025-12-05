<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactController extends Controller
{
    /** Muestra el formulario (GET /contacto) */
    public function form()
    {
        return view('pages.contacto');
    }

    /** Procesa el envío (POST /contacto) */
    public function send(Request $request)
    {
        // Anti-spam (honeypot): el input "website" NO debe venir lleno
        if ($request->filled('website')) {
            // Ignora bots silenciosamente
            return back()->with('ok', 'Gracias.')->withInput();
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

        // A quién llega el correo de contacto
        $destinatario = 'contacto@calculadoraindemnizacion.com';

        // Envia Mailable con Reply-To del usuario
        $mailable = (new ContactMessage($data))
            ->replyTo($data['email'], $data['nombre']);

        // ¿Quieres colas? Si tienes QUEUE_CONNECTION=database y worker activo, usa queue():
        if (config('queue.default') !== 'sync') {
            Mail::to($destinatario)->queue($mailable);
        } else {
            Mail::to($destinatario)->send($mailable);
        }

        // Redirige a la ruta GET del formulario (nombre: contacto)
        return redirect()
            ->route('contacto')
            ->with('ok', '¡Gracias! Tu mensaje fue enviado correctamente.');
    }
}
