@extends('layouts.app')

@section('title', '¿Qué es la indemnización por despido injustificado? (LFT México)')
@section('meta_description', 'Explicación clara de la indemnización por despido injustificado según la LFT en México: 3 meses de SDI, 20 días por año, proporcionales y fundamentos legales.')

@push('head')
  @php
    $ld = [
      '@context' => 'https://schema.org',
      '@type' => 'Article',
      'headline' => '¿Qué es la indemnización por despido injustificado? (LFT México)',
      'about' => ['indemnización', 'LFT', 'despido injustificado'],
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
        <li class="opacity-90">¿Qué es indemnización?</li>
      </ol>
    </nav>
    <h2 class="text-3xl font-semibold">¿Qué es la indemnización por despido injustificado?</h2>
    <p class="mt-2 text-blue-50">
      Cuándo aplica, qué incluye (3 meses, 20 días por año y proporcionales) y cuáles son sus fundamentos en la LFT.
    </p>
  </section>

  {{-- Contenido + Aside --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
    <article class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm prose prose-blue max-w-none">
      <h3>¿Cuándo aplica?</h3>
      <p>
        La indemnización aplica cuando existe <strong>despido injustificado</strong>, <strong>negativa de reinstalación</strong>
        o <strong>rescisión imputable al patrón</strong>. No aplica si renunciaste voluntariamente.
      </p>

      <h3>¿Qué incluye?</h3>
      <ul>
        <li><strong>3 meses</strong> de Salario Diario Integrado (SDI).</li>
        <li><strong>20 días por año</strong> de servicios (en los supuestos previstos por la LFT).</li>
        <li>Proporcionales: <strong>vacaciones</strong> + <strong>prima vacacional (25%)</strong> y <strong>aguinaldo</strong>.</li>
      </ul>

      <h3>Base legal</h3>
      <p>Fundamento principal en la LFT: <strong>artículos 48–50</strong>, además de correlativos para prestaciones (76, 80, 87).</p>

      <h3>Calcula tu caso</h3>
      <p>Usa la calculadora para estimar cifras orientativas; el resultado puede variar por contrato, convenios o juicio.</p>
      <p class="mt-4">
        <a href="{{ route('inicio') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
          Ir a la calculadora
        </a>
      </p>
    </article>

    <aside class="space-y-6">
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h4 class="text-base font-semibold mb-3">Resumen</h4>
        <ul class="text-sm text-gray-700 space-y-2 leading-6">
          <li>• Aplica ante despido injustificado o negativa de reinstalación.</li>
          <li>• 3 meses de SDI + 20 días por año (según proceda).</li>
          <li>• Incluye vacaciones, prima 25% y aguinaldo proporcional.</li>
        </ul>
      </div>

      @includeIf('partials.ads.responsive', ['slot' => '1234567890'])
    </aside>
  </div>
@endsection
