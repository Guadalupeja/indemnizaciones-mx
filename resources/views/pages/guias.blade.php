@extends('layouts.app')
@section('title', 'Guías y artículos prácticos (LFT México)')
@section('meta_description', 'Índice de guías prácticas: indemnización, vacaciones, aguinaldo y prima de antigüedad. Explicaciones claras y enlaces a la calculadora y al test.')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

  <nav aria-label="miga de pan" class="text-sm text-gray-500">
    <ol class="flex gap-2">
      <li><a href="{{ route('inicio') }}" class="underline">Inicio</a></li>
      <li>/</li>
      <li>Guías</li>
    </ol>
  </nav>

  <header class="space-y-2">
    <h1 class="text-3xl font-semibold">Guías y artículos prácticos</h1>
    <p class="text-gray-600">
      Revisa estas guías claras sobre temas clave (LFT México) y usa la calculadora para obtener un estimado con desglose.
    </p>
  </header>

  <div class="grid gap-4">
    <a class="block rounded-2xl border p-4 hover:bg-gray-50" href="{{ route('guia-indemnizacion') }}">
      <h2 class="font-semibold">Indemnización por despido injustificado</h2>
      <p class="text-sm text-gray-600">Cuándo procede, cómo se calcula (3 meses y, cuando aplica, 20 días por año) y ejemplos.</p>
    </a>

    <a class="block rounded-2xl border p-4 hover:bg-gray-50" href="{{ route('guia-vacaciones') }}">
      <h2 class="font-semibold">Vacaciones y prima vacacional 25%</h2>
      <p class="text-sm text-gray-600">Tabla por antigüedad, pago y proporcional en terminación.</p>
    </a>

    <a class="block rounded-2xl border p-4 hover:bg-gray-50" href="{{ route('guia-aguinaldo') }}">
      <h2 class="font-semibold">Aguinaldo y proporcional</h2>
      <p class="text-sm text-gray-600">Plazo de pago, fórmula base y cálculo proporcional.</p>
    </a>

    <a class="block rounded-2xl border p-4 hover:bg-gray-50" href="{{ route('guia-prima-antiguedad') }}">
      <h2 class="font-semibold">Prima de antigüedad</h2>
      <p class="text-sm text-gray-600">Cuándo aplica, tope 2× salario mínimo y ejemplos.</p>
    </a>
  </div>

  <div class="flex flex-wrap gap-2">
    <a href="{{ route('inicio') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white">Ir a la calculadora</a>
    <a href="{{ route('test-caso-laboral') }}" class="inline-flex items-center rounded-xl border px-4 py-2">¿No sabes cuál usar? Haz el test</a>
  </div>

  @includeIf('partials.ads.responsive', ['slot' => 'TU_SLOT_ID'])
</div>

@include('partials.seo.breadcrumbs', [
  'items'=>[
    ['name'=>'Inicio','url'=>route('inicio')],
    ['name'=>'Guías','url'=>url()->current()]
  ]
])

@include('partials.seo.article', [
  'headline'=>'Guías y artículos prácticos (LFT México)',
  'description'=>'Índice de guías: indemnización, vacaciones, aguinaldo y prima de antigüedad.',
  'author'=>'Equipo'
])

@endsection
