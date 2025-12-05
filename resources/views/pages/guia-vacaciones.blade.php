@extends('layouts.app')
@section('title', 'Guía: Vacaciones y prima vacacional 25% (LFT México)')
@section('meta_description', 'Cómo funcionan las vacaciones, la tabla de días según antigüedad y la prima vacacional del 25%. Cálculo proporcional y ejemplos.')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

  {{-- Migas visibles --}}
  <nav aria-label="miga de pan" class="text-sm text-gray-500">
    <ol class="flex gap-2">
      <li><a href="{{ route('inicio') }}" class="underline">Inicio</a></li>
      <li>/</li>
      <li>Guía: Vacaciones</li>
    </ol>
  </nav>

  {{-- Cabecera --}}
  <header class="space-y-2">
    <h1 class="text-3xl font-semibold">Guía: Vacaciones y prima vacacional del 25%</h1>
    <p class="text-gray-600">
      Entiende cuántos días te corresponden por antigüedad, cómo se calcula el pago de vacaciones y
      la <strong>prima vacacional del 25%</strong>. Incluye proporcional en caso de terminación.
    </p>
    <p class="text-xs text-gray-500">
      Actualizado:
      <time datetime="{{ now()->toDateString() }}">{{ now()->translatedFormat('d \\de F, Y') }}</time>
    </p>
  </header>

  {{-- Índice --}}
  <aside class="rounded-2xl border p-4 bg-white shadow-sm">
    <h2 class="font-semibold mb-2">Contenido</h2>
    <ol class="list-decimal pl-5 space-y-1 text-sm">
      <li><a class="underline" href="#que-es">¿Qué son las vacaciones y la prima?</a></li>
      <li><a class="underline" href="#cuando-aplica">¿Cuándo aplica?</a></li>
      <li><a class="underline" href="#como-se-calcula">¿Cómo se calcula?</a></li>
      <li><a class="underline" href="#ejemplos">Ejemplos rápidos</a></li>
      <li><a class="underline" href="#faq">Preguntas frecuentes</a></li>
    </ol>
  </aside>

  {{-- Sección 1 --}}
  <section id="que-es" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Qué son las vacaciones y la prima?</h2>
    <p class="text-gray-700 leading-7">
      Las <strong>vacaciones</strong> son días de descanso pagados que aumentan con tu antigüedad.
      La <strong>prima vacacional</strong> es un <strong>25%</strong> adicional sobre el pago de vacaciones.
    </p>
    <div class="flex flex-wrap gap-2">
      <a href="{{ route('inicio') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white">Calcular ahora</a>
      <a href="{{ route('test-caso-laboral') }}" class="inline-flex items-center rounded-xl border px-4 py-2">¿No sabes cuál usar? Haz el test</a>
    </div>
  </section>

  {{-- Sección 2 --}}
  <section id="cuando-aplica" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Cuándo aplica?</h2>
    <ul class="list-disc pl-6 text-gray-700 leading-7">
      <li>Durante la relación laboral, según la <strong>tabla de días por antigüedad</strong> de la LFT.</li>
      <li>En la terminación, se paga el <strong>proporcional</strong> al tiempo trabajado del año.</li>
      <li>La prima vacacional del 25% se aplica sobre el pago de vacaciones.</li>
    </ul>
  </section>

  {{-- Sección 3 --}}
  <section id="como-se-calcula" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Cómo se calcula?</h2>
    <p class="text-gray-700 leading-7">
      1) Determina los <strong>días de vacaciones</strong> por antigüedad.<br>
      2) Calcula <strong>vacaciones = SD × días de vacaciones</strong>.<br>
      3) Calcula <strong>prima vacacional = vacaciones × 25%</strong>.<br>
      En terminación, ambos se calculan de forma <strong>proporcional</strong> a los días laborados del año.
    </p>
  </section>

  {{-- Sección 4 --}}
  <section id="ejemplos" class="space-y-3">
    <h2 class="text-xl font-semibold">Ejemplos rápidos</h2>
    <ul class="list-disc pl-6 text-gray-700 leading-7">
      <li>
        <strong>Caso A</strong>: SD $400; vacaciones 6 días → pago vacaciones = 400×6; prima = (400×6)×0.25.
      </li>
      <li>
        <strong>Caso B</strong>: SD $500; proporcional 4 días → vacaciones = 500×4; prima = (500×4)×0.25.
      </li>
    </ul>
  </section>

  {{-- Sección 5: FAQ visual --}}
  <section id="faq" class="space-y-4">
    <h2 class="text-xl font-semibold">Preguntas frecuentes</h2>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Cuál es la prima vacacional?</summary>
      <div class="mt-2 text-sm text-gray-700">Es el 25% sobre el pago de vacaciones.</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿En terminación se pagan vacaciones?</summary>
      <div class="mt-2 text-sm text-gray-700">Sí, se paga el proporcional del año en curso.</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Cómo sé cuántos días me corresponden?</summary>
      <div class="mt-2 text-sm text-gray-700">Depende de tu antigüedad según la tabla de la LFT.</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿La calculadora suma la prima?</summary>
      <div class="mt-2 text-sm text-gray-700">Sí, calcula vacaciones y su prima del 25% automáticamente.</div>
    </details>
  </section>

  {{-- Adsense recomendado: debajo del primer párrafo --}}
  @includeIf('partials.ads.responsive', ['slot' => 'TU_SLOT_ID'])
</div>

{{-- JSON-LD --}}
@include('partials.seo.breadcrumbs', [
  'items'=>[
    ['name'=>'Inicio','url'=>route('inicio')],
    ['name'=>'Guía: Vacaciones','url'=>url()->current()]
  ]
])

@include('partials.seo.article', [
  'headline'=>'Guía: Vacaciones y prima vacacional 25%',
  'description'=>'Tabla por antigüedad, cálculo proporcional y ejemplos.',
  'author'=>'Equipo'
])

@include('partials.seo.faq', ['faqs'=>[
  ['q'=>'¿Cuál es la prima vacacional?', 'a'=>'Es el 25% sobre el pago de vacaciones.'],
  ['q'=>'¿En terminación se pagan vacaciones?', 'a'=>'Sí, se paga el proporcional del año en curso.'],
  ['q'=>'¿Cómo sé cuántos días me corresponden?', 'a'=>'Depende de tu antigüedad según la tabla de la LFT.'],
  ['q'=>'¿La calculadora suma la prima?', 'a'=>'Sí, la calculadora contempla vacaciones y prima del 25%.']
]])

@endsection
