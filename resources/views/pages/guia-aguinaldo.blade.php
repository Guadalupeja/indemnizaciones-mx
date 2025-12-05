@extends('layouts.app')
@section('title', 'Guía: Aguinaldo y aguinaldo proporcional (LFT México)')
@section('meta_description', 'Qué es el aguinaldo, plazo de pago, cómo se calcula y cómo estimar el proporcional por días trabajados en el año.')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

  {{-- Migas visibles --}}
  <nav aria-label="miga de pan" class="text-sm text-gray-500">
    <ol class="flex gap-2">
      <li><a href="{{ route('inicio') }}" class="underline">Inicio</a></li>
      <li>/</li>
      <li>Guía: Aguinaldo</li>
    </ol>
  </nav>

  {{-- Cabecera --}}
  <header class="space-y-2">
    <h1 class="text-3xl font-semibold">Guía: Aguinaldo y proporcional</h1>
    <p class="text-gray-600">
      Conoce qué es el aguinaldo, su plazo de pago y la fórmula para calcularlo. Incluye cómo estimar el
      <strong>proporcional</strong> según los días trabajados en el año.
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
      <li><a class="underline" href="#que-es">¿Qué es el aguinaldo?</a></li>
      <li><a class="underline" href="#cuando-aplica">¿Cuándo aplica?</a></li>
      <li><a class="underline" href="#como-se-calcula">¿Cómo se calcula?</a></li>
      <li><a class="underline" href="#ejemplos">Ejemplos rápidos</a></li>
      <li><a class="underline" href="#faq">Preguntas frecuentes</a></li>
    </ol>
  </aside>

  {{-- Sección 1 --}}
  <section id="que-es" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Qué es el aguinaldo?</h2>
    <p class="text-gray-700 leading-7">
      Es una prestación anual obligatoria. Por regla general se paga antes del <strong>20 de diciembre</strong>.
      Si la relación laboral termina antes de esa fecha, corresponde el <strong>proporcional</strong> por los días trabajados en el año.
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
      <li>A todo trabajador con relación laboral vigente durante el año.</li>
      <li>En terminación, se paga el <strong>aguinaldo proporcional</strong>.</li>
    </ul>
  </section>

  {{-- Sección 3 --}}
  <section id="como-se-calcula" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Cómo se calcula?</h2>
    <p class="text-gray-700 leading-7">
      Fórmula base: <strong>SD × días de aguinaldo</strong> (mínimo de ley).<br>
      Proporcional: <strong>SD × días de aguinaldo × (días trabajados del año / 365)</strong>.
    </p>
  </section>

  {{-- Sección 4 --}}
  <section id="ejemplos" class="space-y-3">
    <h2 class="text-xl font-semibold">Ejemplos rápidos</h2>
    <ul class="list-disc pl-6 text-gray-700 leading-7">
      <li><strong>Caso A</strong>: SD $450; días de aguinaldo 15; días trabajados 200 → proporcional = 450×15×(200/365).</li>
      <li><strong>Caso B</strong>: SD $520; días de aguinaldo 15; días trabajados 365 → aguinaldo = 520×15.</li>
    </ul>
  </section>

  {{-- Sección 5: FAQ visual --}}
  <section id="faq" class="space-y-4">
    <h2 class="text-xl font-semibold">Preguntas frecuentes</h2>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Cuándo se paga el aguinaldo?</summary>
      <div class="mt-2 text-sm text-gray-700">Por regla general, antes del 20 de diciembre; en terminación, proporcional.</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Cómo calculo el proporcional?</summary>
      <div class="mt-2 text-sm text-gray-700">SD × días de aguinaldo × (días trabajados / 365).</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿La calculadora lo muestra?</summary>
      <div class="mt-2 text-sm text-gray-700">Sí, la calculadora despliega el aguinaldo proporcional en el desglose.</div>
    </details>
  </section>

  {{-- Adsense recomendado: debajo del primer párrafo --}}
  @includeIf('partials.ads.responsive', ['slot' => 'TU_SLOT_ID'])
</div>

{{-- JSON-LD --}}
@include('partials.seo.breadcrumbs', [
  'items'=>[
    ['name'=>'Inicio','url'=>route('inicio')],
    ['name'=>'Guía: Aguinaldo','url'=>url()->current()]
  ]
])

@include('partials.seo.article', [
  'headline'=>'Guía: Aguinaldo y proporcional',
  'description'=>'Plazo, fórmula y ejemplos prácticos de cálculo.',
  'author'=>'Equipo'
])

@include('partials.seo.faq', ['faqs'=>[
  ['q'=>'¿Cuándo se paga el aguinaldo?', 'a'=>'Normalmente antes del 20 de diciembre; en terminación, proporcional.'],
  ['q'=>'¿Cómo calculo el proporcional?', 'a'=>'SD × días de aguinaldo × (días trabajados / 365).'],
  ['q'=>'¿La calculadora lo muestra?', 'a'=>'Sí, muestra el aguinaldo proporcional en el desglose.']
]])

@endsection
