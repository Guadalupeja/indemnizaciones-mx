@extends('layouts.app')
@section('title', 'TÍTULO GUÍA')
@section('meta_description', 'DESCRIPCIÓN breve y clara para buscadores (140–160 caracteres).')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

  {{-- Migas visibles --}}
  <nav aria-label="miga de pan" class="text-sm text-gray-500">
    <ol class="flex gap-2">
      <li><a href="{{ route('inicio') }}" class="underline">Inicio</a></li>
      <li>/</li>
      <li>Guía</li>
    </ol>
  </nav>

  {{-- Cabecera --}}
  <header class="space-y-2">
    <h1 class="text-3xl font-semibold">TÍTULO GUÍA</h1>
    <p class="text-gray-600">Resumen de 1–2 líneas explicando el tema y enlazando a herramientas.</p>
    <p class="text-xs text-gray-500">
      Actualizado:
      <time datetime="{{ now()->toDateString() }}">{{ now()->translatedFormat('d \\de F, Y') }}</time>
    </p>
  </header>

  {{-- Índice --}}
  <aside class="rounded-2xl border p-4 bg-white shadow-sm">
    <h2 class="font-semibold mb-2">Contenido</h2>
    <ol class="list-decimal pl-5 space-y-1 text-sm">
      <li><a class="underline" href="#que-es">¿Qué es?</a></li>
      <li><a class="underline" href="#cuando-aplica">¿Cuándo aplica?</a></li>
      <li><a class="underline" href="#como-se-calcula">¿Cómo se calcula?</a></li>
      <li><a class="underline" href="#ejemplos">Ejemplos rápidos</a></li>
      <li><a class="underline" href="#faq">Preguntas frecuentes</a></li>
    </ol>
  </aside>

  {{-- Sección 1 --}}
  <section id="que-es" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Qué es?</h2>
    <p class="text-gray-700 leading-7">Explicación clara y breve. Enlaza a la
      <a class="underline" href="{{ route('inicio') }}">calculadora</a> y al
      <a class="underline" href="{{ route('test-caso-laboral') }}">test</a> si aplica.</p>
  </section>

  {{-- Sección 2 --}}
  <section id="cuando-aplica" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Cuándo aplica?</h2>
    <ul class="list-disc pl-6 text-gray-700 leading-7">
      <li>Punto clave 1.</li>
      <li>Punto clave 2.</li>
      <li>Punto clave 3.</li>
    </ul>
  </section>

  {{-- Sección 3 --}}
  <section id="como-se-calcula" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Cómo se calcula?</h2>
    <p class="text-gray-700 leading-7">Describe fórmula(s) y remite a la herramienta:</p>
    <div class="flex flex-wrap gap-2">
      <a href="{{ route('inicio') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white">Calcular ahora</a>
      <a href="{{ route('test-caso-laboral') }}" class="inline-flex items-center rounded-xl border px-4 py-2">¿No sabes cuál usar? Haz el test</a>
    </div>
  </section>

  {{-- Sección 4 --}}
  <section id="ejemplos" class="space-y-3">
    <h2 class="text-xl font-semibold">Ejemplos rápidos</h2>
    <ul class="list-disc pl-6 text-gray-700 leading-7">
      <li>Ejemplo A: ...</li>
      <li>Ejemplo B: ...</li>
    </ul>
  </section>

  {{-- Sección 5: FAQ visual --}}
  <section id="faq" class="space-y-4">
    <h2 class="text-xl font-semibold">Preguntas frecuentes</h2>
    <details class="group">
      <summary class="cursor-pointer font-medium">Pregunta 1</summary>
      <div class="mt-2 text-sm text-gray-700">Respuesta breve.</div>
    </details>
    <details class="group">
      <summary class="cursor-pointer font-medium">Pregunta 2</summary>
      <div class="mt-2 text-sm text-gray-700">Respuesta breve.</div>
    </details>
  </section>

  {{-- Adsense recomendado: debajo de primer párrafo --}}
  @includeIf('partials.ads.responsive', ['slot' => 'TU_SLOT_ID'])
</div>

{{-- JSON-LD --}}
@include('partials.seo.breadcrumbs', [
  'items'=>[
    ['name'=>'Inicio','url'=>route('inicio')],
    ['name'=>'Guía','url'=>url()->current()]
  ]
])

{{-- Sustituye headline/description/author por los de cada guía --}}
@include('partials.seo.article', [
  'headline'=>'TÍTULO GUÍA',
  'description'=>'DESCRIPCIÓN de la guía en una frase clara.',
  'author'=>'Equipo'
])

{{-- Sustituye con preguntas reales (4–6) --}}
@include('partials.seo.faq', ['faqs'=>[
  ['q'=>'Pregunta estructurada 1', 'a'=>'Respuesta breve y clara.'],
  ['q'=>'Pregunta estructurada 2', 'a'=>'Respuesta breve y clara.']
]])

@endsection
