@extends('layouts.app')
@section('title', 'Guía completa: Indemnización por despido injustificado (LFT México)')
@section('meta_description', 'Qué es la indemnización, cuándo procede, cómo se calcula (3 meses de SDI y, cuando aplica, 20 días por año) y ejemplos prácticos.')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

  {{-- Migas visibles --}}
  <nav aria-label="miga de pan" class="text-sm text-gray-500">
    <ol class="flex gap-2">
      <li><a href="{{ route('inicio') }}" class="underline">Inicio</a></li>
      <li>/</li>
      <li>Guía: Indemnización</li>
    </ol>
  </nav>

  {{-- Cabecera --}}
  <header class="space-y-2">
    <h1 class="text-3xl font-semibold">Guía completa: Indemnización por despido injustificado</h1>
    <p class="text-gray-600">
      Explicación clara de cuándo procede la indemnización, cómo se calcula (3 meses de SDI y, cuando corresponde, 20 días por año),
      qué prestaciones se agregan y ejemplos rápidos. Enlaza con la calculadora y el test para resolver dudas.
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
      <li><a class="underline" href="#que-es">¿Qué es la indemnización?</a></li>
      <li><a class="underline" href="#cuando-aplica">¿Cuándo procede?</a></li>
      <li><a class="underline" href="#como-se-calcula">¿Cómo se calcula?</a></li>
      <li><a class="underline" href="#ejemplos">Ejemplos rápidos</a></li>
      <li><a class="underline" href="#faq">Preguntas frecuentes</a></li>
    </ol>
  </aside>

  {{-- Sección 1 --}}
  <section id="que-es" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Qué es la indemnización?</h2>
    <p class="text-gray-700 leading-7">
      Es la compensación económica que corresponde al trabajador ante un <strong>despido injustificado</strong> o
      <strong>negativa de reinstalación</strong>. Normalmente incluye <strong>3 meses de salario diario integrado (SDI)</strong>,
      puede incluir <strong>20 días por año</strong> dependiendo de los supuestos, además de <strong>prestaciones proporcionales</strong>
      (vacaciones + prima 25% y aguinaldo) y <strong>prima de antigüedad</strong> según reglas aplicables.
    </p>
    <div class="flex flex-wrap gap-2">
      <a href="{{ route('inicio') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white">Calcular ahora</a>
      <a href="{{ route('test-caso-laboral') }}" class="inline-flex items-center rounded-xl border px-4 py-2">¿No sabes cuál usar? Haz el test</a>
    </div>
  </section>

  {{-- Sección 2 --}}
  <section id="cuando-aplica" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Cuándo procede?</h2>
    <ul class="list-disc pl-6 text-gray-700 leading-7">
      <li><strong>Despido sin causa justificada</strong> o no acreditada por el patrón.</li>
      <li><strong>Negativa de reinstalación</strong> o falta de oferta válida de reinstalar.</li>
      <li>Existen indicios de <strong>discriminación</strong>, <strong>embarazo/maternidad</strong> o <strong>acoso/hostigamiento</strong>.</li>
    </ul>
  </section>

  {{-- Sección 3 --}}
  <section id="como-se-calcula" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Cómo se calcula?</h2>
    <p class="text-gray-700 leading-7">
      La base típica es: <strong>3 meses de SDI</strong> + (cuando procede) <strong>20 días por año</strong> + <strong>proporcionales</strong>
      (vacaciones + prima del 25% y aguinaldo) + <strong>prima de antigüedad</strong> (tope al salario en 2× SM de la zona).
      Para tener un estimado con desglose, usa la calculadora.
    </p>
    <div class="flex flex-wrap gap-2">
      <a href="{{ route('inicio') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white">Calcular ahora</a>
      <a href="{{ route('test-caso-laboral') }}" class="inline-flex items-center rounded-xl border px-4 py-2">Realizar test de orientación</a>
    </div>
  </section>

  {{-- Sección 4 --}}
  <section id="ejemplos" class="space-y-3">
    <h2 class="text-xl font-semibold">Ejemplos rápidos</h2>
    <ul class="list-disc pl-6 text-gray-700 leading-7">
      <li>
        <strong>Caso A</strong>: SDI $500; antigüedad 2.5 años →
        3 meses = 500×90; 20 días/año = 500×20×2.5; + proporcionales; + prima de antigüedad si corresponde.
      </li>
      <li>
        <strong>Caso B</strong>: SDI $420; antigüedad 1 año →
        3 meses = 420×90; (20 días/año solo si procede); + proporcionales.
      </li>
    </ul>
  </section>

  {{-- Sección 5: FAQ visual --}}
  <section id="faq" class="space-y-4">
    <h2 class="text-xl font-semibold">Preguntas frecuentes</h2>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Siempre proceden 20 días por año?</summary>
      <div class="mt-2 text-sm text-gray-700">No. Depende del tipo de contrato y de si existió oferta y reinstalación válida.</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Qué salario se usa para los 3 meses?</summary>
      <div class="mt-2 text-sm text-gray-700">Se usa el Salario Diario Integrado (SDI), que integra prestaciones.</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿La prima de antigüedad siempre se paga?</summary>
      <div class="mt-2 text-sm text-gray-700">En despido puede pagarse aun con menos de 15 años; está topada a 2× salario mínimo.</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Puedo estimar el neto?</summary>
      <div class="mt-2 text-sm text-gray-700">Sí, la calculadora ofrece un estimado simplificado de ISR para aproximar un neto.</div>
    </details>

    <details class="group">
      <summary class="cursor-pointer font-medium">¿Esto sustituye asesoría legal?</summary>
      <div class="mt-2 text-sm text-gray-700">No. Es material informativo y orientativo.</div>
    </details>
  </section>

  {{-- Adsense recomendado: debajo del primer párrafo --}}
  @includeIf('partials.ads.responsive', ['slot' => 'TU_SLOT_ID'])
</div>

{{-- JSON-LD --}}
@include('partials.seo.breadcrumbs', [
  'items'=>[
    ['name'=>'Inicio','url'=>route('inicio')],
    ['name'=>'Guía: Indemnización','url'=>url()->current()]
  ]
])

@include('partials.seo.article', [
  'headline'=>'Guía completa: Indemnización por despido injustificado',
  'description'=>'Cuándo procede, cómo se calcula (3 meses y, cuando aplica, 20 días por año) y ejemplos.',
  'author'=>'Equipo'
])

@include('partials.seo.faq', ['faqs'=>[
  ['q'=>'¿Siempre proceden 20 días por año?', 'a'=>'No. Depende del tipo de contrato y de si existió oferta y reinstalación válida.'],
  ['q'=>'¿Qué salario se usa para los 3 meses?', 'a'=>'Se usa el Salario Diario Integrado (SDI).'],
  ['q'=>'¿La prima de antigüedad siempre se paga?', 'a'=>'En despido puede pagarse aun con menos de 15 años; está topada a 2× salario mínimo.'],
  ['q'=>'¿Puedo estimar el neto?', 'a'=>'Sí, la calculadora ofrece un estimado simplificado de ISR.'],
  ['q'=>'¿Esto sustituye asesoría legal?', 'a'=>'No, es material informativo y orientativo.']
]])

@endsection
