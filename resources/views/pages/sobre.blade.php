@extends('layouts.app')
@section('title','Sobre este proyecto')
@section('meta_description','Quién está detrás de la calculadora de indemnización y finiquito, objetivos, metodología, límites y contacto.')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">

  {{-- Migas visibles --}}
  <nav aria-label="miga de pan" class="text-sm text-gray-500">
    <ol class="flex flex-wrap items-center gap-2">
      <li><a href="{{ route('inicio') }}" class="underline hover:no-underline">Inicio</a></li>
      <li aria-hidden="true">/</li>
      <li class="text-gray-600">Sobre</li>
    </ol>
  </nav>

  {{-- Encabezado --}}
  <header class="space-y-2">
    <h1 class="text-2xl md:text-3xl font-semibold">Sobre este proyecto</h1>
    <p class="text-gray-700">
      {{ config('app.name') }} es una herramienta gratuita para estimar, de forma orientativa,
      la <strong>indemnización por despido</strong> o el <strong>finiquito/liquidación</strong> conforme a la Ley Federal del Trabajo (LFT) en México.
    </p>
    <p class="text-xs text-gray-500">
      Última actualización:
      <time datetime="{{ now()->toDateString() }}">{{ now()->translatedFormat('d \\de F, Y') }}</time>
    </p>
  </header>

  {{-- Quién está detrás --}}
  <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
    <h2 class="font-semibold mb-2">Quién está detrás</h2>
    <p class="text-gray-700 leading-7">
      Este proyecto es desarrollado por <strong>Guadalupe Juárez Arias</strong>, egresada de la licenciatura en
      Contaduría (<em>título en trámite</em>) y <strong>ingeniera en informática</strong>, residente en Puebla, México.
      El objetivo es acercar cálculos claros y comprensibles para personas trabajadoras y empleadores.
    </p>
  </section>

  {{-- Objetivos --}}
  <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
    <h2 class="font-semibold mb-2">Objetivos</h2>
    <ul class="list-disc pl-5 text-gray-700 space-y-1 leading-7">
      <li>Ofrecer un estimador transparente con <strong>desglose de conceptos</strong> y <strong>fundamento legal</strong>.</li>
      <li>Permitir comparar escenarios cambiando <strong>SD/SDI, fechas, zona salarial y supuestos</strong>.</li>
      <li>Educar con guías sencillas (aguinaldo, vacaciones, prima de antigüedad, etc.).</li>
    </ul>
  </section>

  {{-- Metodología --}}
  <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
    <h2 class="font-semibold mb-2">Metodología</h2>
    <ul class="list-disc pl-5 text-gray-700 space-y-1 leading-7">
      <li>LFT: arts. <strong>48–50</strong> (3 meses y, cuando procede, 20 días/año), <strong>76–78 y 80</strong> (vacaciones y prima), <strong>87</strong> (aguinaldo), <strong>162</strong> (prima de antigüedad, tope 2× SM).</li>
      <li>Parámetros: <strong>Salario Diario (SD)</strong>, <strong>Salario Diario Integrado (SDI)</strong>, <strong>fechas</strong>, <strong>zona salarial</strong> y <strong>supuestos</strong>.</li>
      <li>El resultado es <strong>orientativo</strong> y puede diferir de un cálculo fiscal/contable o de un laudo.</li>
    </ul>
    <p class="text-xs text-gray-500 mt-2">Cuando el SDI no está disponible, el sistema permite trabajar con SD y mostrar advertencias.</p>
  </section>

  {{-- Alcances y límites --}}
  <section class="rounded-2xl border border-amber-200 bg-amber-50 p-5 text-amber-900 shadow-sm">
    <h2 class="font-semibold mb-2">Alcances y límites</h2>
    <ul class="list-disc pl-5 space-y-1 leading-7">
      <li>El resultado es una <strong>estimación</strong> con fines informativos; <strong>no constituye asesoría legal</strong>.</li>
      <li>Las reglas fiscales del ISR pueden variar; el “neto estimado” usa una aproximación.</li>
      <li>Para casos complejos, se recomienda consultar a una persona abogada laboral.</li>
    </ul>
  </section>

  {{-- Transparencia (monetización y datos) --}}
  <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
    <h2 class="font-semibold mb-2">Transparencia</h2>
    <ul class="list-disc pl-5 text-gray-700 space-y-1 leading-7">
      <li>Este sitio puede mostrar anuncios de <strong>Google AdSense</strong> <em>solo</em> después de tu consentimiento de cookies.</li>
      <li>Los datos que ingresas en la calculadora se usan para generar el resultado y <strong>no se venden</strong>.</li>
      <li>Consulta la <a class="underline" href="{{ route('aviso-privacidad') }}">Política de privacidad y cookies</a> para más detalles.</li>
    </ul>
  </section>

  {{-- Contacto --}}
  <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
    <h2 class="font-semibold mb-2">Contacto y soporte</h2>
    <p class="text-gray-700">
      Si detectas un error o tienes una sugerencia, escríbeme a
      <a class="underline" href="mailto:contacto@calculadoraindemnizacion.com">contacto@calculadoraindemnizacion.com</a>.
    </p>
  </section>

  {{-- CTA --}}
  <div class="flex flex-wrap gap-3">
    <a href="{{ route('inicio') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">
      Ir a la calculadora
    </a>
    <a href="{{ route('test-caso-laboral') }}" class="inline-flex items-center rounded-xl border px-4 py-2 hover:bg-gray-50">
      ¿No sabes cuál usar? Haz el test
    </a>
  </div>
</div>

{{-- Breadcrumbs JSON-LD (usa tu parcial si lo tienes) --}}
@include('partials.seo.breadcrumbs', [
  'items' => [
    ['name'=>'Inicio','url'=>route('inicio')],
    ['name'=>'Sobre','url'=>url()->current()]
  ]
])

@push('head')
@php
  $aboutLd = [
    '@context' => 'https://schema.org',
    '@type'    => 'AboutPage',
    'name'     => 'Sobre ' . config('app.name'),
    'url'      => url()->current(),
    'inLanguage' => 'es-MX',
    'description' => 'Información del proyecto, metodología, límites y contacto.'
  ];

  $orgLd = [
    '@context' => 'https://schema.org',
    '@type'    => 'Organization',
    'name'     => config('app.name'),
    'url'      => url('/'),
    'areaServed' => 'MX',
    'contactPoint' => [
      '@type' => 'ContactPoint',
      'contactType' => 'customer support',
      'email' => 'contacto@calculadoraindemnizacion.com',
      'availableLanguage' => ['es-MX'],
    ],
  ];

  $personLd = [
    '@context' => 'https://schema.org',
    '@type'    => 'Person',
    'name'     => 'Guadalupe Juárez Arias',
    'jobTitle' => 'Desarrolladora y responsable del contenido',
    'affiliation' => [
      '@type' => 'Organization',
      'name'  => config('app.name'),
    ],
  ];
@endphp
<script type="application/ld+json">{!! json_encode($aboutLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($orgLd,   JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($personLd,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@endsection
