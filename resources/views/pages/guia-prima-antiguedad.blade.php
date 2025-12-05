@extends('layouts.app')
@section('title', 'Guía: Prima de antigüedad (tope 2× salario mínimo)')
@section('meta_description', 'Cuándo aplica la prima de antigüedad, fórmula de 12 días por año y tope a 2× salario mínimo según la zona, con ejemplos prácticos.')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

  {{-- Migas visibles --}}
  <nav aria-label="miga de pan" class="text-sm text-gray-500">
    <ol class="flex gap-2">
      <li><a href="{{ route('inicio') }}" class="underline">Inicio</a></li>
      <li>/</li>
      <li>Guía: Prima de antigüedad</li>
    </ol>
  </nav>

  {{-- Cabecera --}}
  <header class="space-y-2">
    <h1 class="text-3xl font-semibold">Guía: Prima de antigüedad (tope 2× salario mínimo)</h1>
    <p class="text-gray-600">
      Entiende cuándo aplica la prima de antigüedad, cómo se calcula con el tope al salario (2× salario mínimo de la zona),
      y revisa ejemplos para despido y finiquito.
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
      <li><a class="underline" href="#que-es">¿Qué es la prima de antigüedad?</a></li>
      <li><a class="underline" href="#cuando-aplica">¿Cuándo aplica?</a></li>
      <li><a class="underline" href="#como-se-calcula">¿Cómo se calcula?</a></li>
      <li><a class="underline" href="#ejemplos">Ejemplos rápidos</a></li>
      <li><a class="underline" href="#faq">Preguntas frecuentes</a></li>
    </ol>
  </aside>

  {{-- Sección 1 --}}
  <section id="que-es" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Qué es la prima de antigüedad?</h2>
    <p class="text-gray-700 leading-7">
      Es una prestación que reconoce los años de servicio del trabajador: <strong>12 días por año</strong>,
      con tope del salario a <strong>2× salario mínimo</strong> de la zona para efectos del cálculo.
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
      <li>En <strong>despido</strong>: puede pagarse aun con menos de 15 años de servicio.</li>
      <li>En <strong>finiquito/liquidación</strong>: usualmente cuando la antigüedad es <strong>≥ 15 años</strong>.</li>
    </ul>
  </section>

  {{-- Sección 3 --}}
  <section id="como-se-calcula" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Cómo se calcula?</h2>
    <p class="text-gray-700 leading-7">
      Base: <strong>min(SD, 2× salario mínimo de la zona)</strong> × 12 × años (puede ser proporcional por fracción de año).
    </p>
  </section>

  {{-- Sección 4 --}}
  <section id="ejemplos" class="space-y-3">
    <h2 class="text-xl font-semibold">Ejemplos rápidos</h2>
    <ul class="list-disc pl-6 text-gray-700 leading-7">
      <li><strong>Caso A</strong>: SD $600; 2× SM zona = $500 → base = 500; años 10 → prima = 500×12×10.</li>
      <li><strong>Caso B</strong>: SD $380; 2× SM zona = $500 → base = 380; años 7.5 → prima = 380×12×7.5.</li>
    </ul>
  </section>

  {{-- Sección 5: FAQ visual --}}
  <section id="faq" class="space-y-4">
    <h2 class="text-xl font-semibold">Preguntas frecuentes</h2>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Siempre se paga?</summary>
      <div class="mt-2 text-sm text-gray-700">
        En despido puede pagarse aun con menos de 15 años; en finiquito suele requerir ≥ 15 años.
      </div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Qué tope aplica?</summary>
      <div class="mt-2 text-sm text-gray-700">El salario para el cálculo se topa a 2× el salario mínimo de la zona.</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Se calcula proporcional?</summary>
      <div class="mt-2 text-sm text-gray-700">Sí, puede calcularse proporcional por fracción de año.</div>
    </details>
  </section>

  {{-- Adsense recomendado: debajo del primer párrafo --}}
  @includeIf('partials.ads.responsive', ['slot' => 'TU_SLOT_ID'])
</div>

{{-- JSON-LD --}}
@include('partials.seo.breadcrumbs', [
  'items'=>[
    ['name'=>'Inicio','url'=>route('inicio')],
    ['name'=>'Guía: Prima de antigüedad','url'=>url()->current()]
  ]
])

@include('partials.seo.article', [
  'headline'=>'Guía: Prima de antigüedad (tope 2× SM)',
  'description'=>'Cuándo aplica y cómo se calcula con ejemplos.',
  'author'=>'Equipo'
])

@include('partials.seo.faq', ['faqs'=>[
  ['q'=>'¿Siempre se paga?', 'a'=>'En despido puede pagarse aun con menos de 15 años; en finiquito suele requerir ≥ 15 años.'],
  ['q'=>'¿Qué tope aplica?', 'a'=>'El salario para el cálculo se topa a 2× el salario mínimo de la zona.'],
  ['q'=>'¿Se calcula proporcional?', 'a'=>'Sí, puede calcularse proporcional por fracción de año.']
]])

@endsection
