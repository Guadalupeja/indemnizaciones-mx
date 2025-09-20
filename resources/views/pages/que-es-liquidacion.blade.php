@extends('layouts.app')

@section('title', '¿Qué es la liquidación / finiquito? (LFT México)')
@section('meta_description', 'Diferencia entre liquidación y finiquito: sueldos pendientes, vacaciones, prima vacacional 25% y aguinaldo proporcional, con base legal de la LFT.')

@push('head')
  @php
    $ld = [
      '@context' => 'https://schema.org',
      '@type' => 'Article',
      'headline' => '¿Qué es la liquidación / finiquito? (LFT México)',
      'about' => ['liquidación', 'finiquito', 'LFT'],
      'author' => ['@type' => 'Person', 'name' => env('APP_OWNER_NAME', 'Profesional independiente')],
      'dateModified' => now()->toIso8601String(),
      'mainEntityOfPage' => url()->current(),
    ];
  @endphp
  <script type="application/ld+json">{!! json_encode($ld, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
  {{-- Hero --}}
  <section class="rounded-3xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white shadow">
    <nav class="text-sm text-blue-100/90 mb-2" aria-label="breadcrumbs">
      <ol class="flex flex-wrap gap-2">
        <li><a class="underline hover:no-underline" href="{{ route('inicio') }}">Inicio</a></li>
        <li>/</li>
        <li class="opacity-90">¿Qué es liquidación?</li>
      </ol>
    </nav>
    <h2 class="text-3xl font-semibold">¿Qué es la liquidación / finiquito?</h2>
    <p class="mt-2 text-blue-50">
      En qué casos se usa, qué conceptos incluye y diferencias respecto a la indemnización.
    </p>
  </section>

  {{-- Contenido + Aside --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
    <article class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm prose prose-blue max-w-none">
      <h3>¿Cuándo se usa?</h3>
      <p>Cuando hay <strong>renuncia</strong>, <strong>mutuo acuerdo</strong>, término de contrato u otros supuestos sin despido injustificado.</p>

      <h3>¿Qué incluye?</h3>
      <ul>
        <li>Sueldos pendientes.</li>
        <li><strong>Vacaciones</strong> y <strong>prima vacacional (25%)</strong>.</li>
        <li><strong>Aguinaldo proporcional</strong> y otras prestaciones conforme a la LFT.</li>
      </ul>

      <h3>Base legal</h3>
      <p>LFT <strong>arts. 76, 80 y 87</strong>, entre otros.</p>

      <h3>Calcula tu finiquito</h3>
      <p>Obtén una estimación orientativa con nuestra herramienta.</p>
      <p class="mt-4">
        <a href="{{ route('inicio') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
          Ir a la calculadora
        </a>
      </p>
    </article>

    <aside class="space-y-6">
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h4 class="text-base font-semibold mb-3">Puntos clave</h4>
        <ul class="text-sm text-gray-700 space-y-2 leading-6">
          <li>• Renuncia, mutuo acuerdo o término de contrato.</li>
          <li>• Incluye proporcionales (vacaciones, prima 25%, aguinaldo).</li>
          <li>• No es lo mismo que la indemnización por despido.</li>
        </ul>
      </div>

      @includeIf('partials.ads.responsive', ['slot' => '1234567890'])
    </aside>
  </div>
@endsection
