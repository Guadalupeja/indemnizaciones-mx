@extends('layouts.app')

@section('title', 'Preguntas frecuentes – Indemnización y liquidación (LFT México)')
@section('meta_description', 'FAQ con dudas comunes sobre indemnización por despido, liquidación/finiquito y bases legales conforme a la LFT en México.')

@push('head')
  @php
    $ld = [
      '@context' => 'https://schema.org',
      '@type' => 'FAQPage',
      'mainEntity' => [
        [
          '@type' => 'Question',
          'name' => '¿Con qué base legal se calcula?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Indemnización: arts. 48–50 LFT. Vacaciones y prima: 76 y 80. Aguinaldo: 87.',
          ]
        ],
        [
          '@type' => 'Question',
          'name' => '¿Qué diferencia hay entre SD y SDI?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'El SDI integra prestaciones y suele usarse como base indemnizatoria. Si no lo conoces, usamos SD.',
          ]
        ],
        [
          '@type' => 'Question',
          'name' => '¿El resultado es definitivo?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'No. Es una estimación orientativa que puede variar por contrato, convenios o juicio.',
          ]
        ],
      ],
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
        <li class="opacity-90">Preguntas frecuentes</li>
      </ol>
    </nav>
    <h2 class="text-3xl font-semibold">Preguntas frecuentes</h2>
    <p class="mt-2 text-blue-50">Respuestas rápidas sobre indemnización, liquidación y la herramienta.</p>
  </section>

  {{-- FAQ + Aside --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
    <section class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <div class="space-y-4">
        <details class="group open:shadow-sm rounded-xl border border-gray-200 p-4">
          <summary class="cursor-pointer font-medium">¿Con qué base legal se calcula?</summary>
          <div class="mt-2 text-sm text-gray-700">Indemnización: arts. 48–50 LFT. Vacaciones y prima: 76 y 80. Aguinaldo: 87.</div>
        </details>

        <details class="group rounded-xl border border-gray-200 p-4">
          <summary class="cursor-pointer font-medium">¿Qué diferencia hay entre SD y SDI?</summary>
          <div class="mt-2 text-sm text-gray-700">El SDI integra prestaciones y suele usarse como base indemnizatoria. Si no lo conoces, usamos SD.</div>
        </details>

        <details class="group rounded-xl border border-gray-200 p-4">
          <summary class="cursor-pointer font-medium">¿El resultado es definitivo?</summary>
          <div class="mt-2 text-sm text-gray-700">No. Es una estimación orientativa que puede variar por contrato, convenios o juicio.</div>
        </details>

        <details class="group rounded-xl border border-gray-200 p-4">
          <summary class="cursor-pointer font-medium">¿Guardan mis datos?</summary>
          <div class="mt-2 text-sm text-gray-700">No almacenamos de forma permanente tus cálculos. Consulta el Aviso de Privacidad para más detalles.</div>
        </details>
      </div>

      <div class="mt-6">
        <a href="{{ route('inicio') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
          Ir a la calculadora
        </a>
      </div>
    </section>

    <aside class="space-y-6">
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h4 class="text-base font-semibold mb-3">¿No ves tu duda?</h4>
        <p class="text-sm text-gray-700">Escríbenos a <a class="underline" href="mailto:{{ env('APP_CONTACT_EMAIL','contacto@example.com') }}">{{ env('APP_CONTACT_EMAIL','contacto@example.com') }}</a>.</p>
      </div>

      @includeIf('partials.ads.responsive', ['slot' => '1234567890'])
    </aside>
  </div>
@endsection
