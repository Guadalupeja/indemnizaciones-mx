@extends('layouts.app')
@section('title','Mapa del sitio')

@section('content')
<div class="max-w-4xl mx-auto space-y-4">
  <h1 class="text-2xl font-semibold">Mapa del sitio</h1>
  <ul class="list-disc pl-6">
    <li><a class="underline" href="{{ route('inicio') }}">Inicio (Calculadora)</a></li>
    <li><a class="underline" href="{{ route('test-caso-laboral') }}">Test: ¿Indemnización o finiquito?</a></li>
    <li><a class="underline" href="{{ route('que-es-indemnizacion') }}">¿Qué es indemnización?</a></li>
    <li><a class="underline" href="{{ route('que-es-liquidacion') }}">¿Qué es liquidación?</a></li>
    <li><a class="underline" href="{{ route('faq') }}">Preguntas frecuentes</a></li>
    <li><a class="underline" href="{{ route('guias') }}">Guías</a></li>
    <li><a class="underline" href="{{ route('blog') }}">Blog</a></li>
    <li><a class="underline" href="{{ route('plantillas') }}">Plantillas</a></li>
    <li><a class="underline" href="{{ route('sobre') }}">Sobre</a></li>
    <li><a class="underline" href="{{ route('contacto') }}">Contacto</a></li>
    <li><a class="underline" href="{{ route('aviso-privacidad') }}">Aviso de privacidad</a></li>
    <li><a class="underline" href="{{ route('politica-cookies') }}">Política de cookies</a></li>
    <li><a class="underline" href="{{ route('terminos') }}">Términos y condiciones</a></li>
  </ul>
</div>
@endsection
