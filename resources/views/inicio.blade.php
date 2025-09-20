@extends('layouts.app')

@section('title', 'Calculadora de Indemnización y Liquidación LFT ' . now()->year . ' en México – Cálculo gratis')
@section('meta_description', 'Calculadora gratuita para estimar indemnización por despido injustificado o liquidación/finiquito conforme a la Ley Federal del Trabajo en México. Usa SD/SDI, antigüedad y fechas. Desglose detallado y base legal actualizada ' . now()->year . '.')

@section('content')
<div class="space-y-10">

  {{-- Breadcrumbs visibles (coherentes con JSON-LD) --}}
  <nav class="text-sm text-gray-500" aria-label="miga de pan">
    <ol class="flex flex-wrap items-center gap-2">
      <li><a class="underline hover:no-underline" href="{{ route('inicio') }}">Inicio</a></li>
      <li aria-hidden="true">/</li>
      <li class="text-gray-600">Calculadora laboral</li>
    </ol>
  </nav>

  {{-- Hero (H2 visible; H1 va en el layout) --}}
  <section class="rounded-3xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white shadow">
    <h2 class="text-3xl font-semibold">
      Calculadora de indemnización y liquidación (LFT México) {{ now()->year }}
    </h2>
    <p class="mt-2 text-blue-50">
      Estima en minutos tu <strong>indemnización por despido injustificado</strong> o tu
      <strong>liquidación/finiquito</strong> conforme a la LFT vigente. Gratis y sin registro.
    </p>

    {{-- Índice interno (Table of Contents) --}}
    <nav class="mt-3 text-sm text-blue-100 flex flex-wrap gap-4" role="navigation" aria-label="Contenido de la página">
      <a href="#como-usar" class="underline">Cómo usar la calculadora</a>
      <a href="#como-calculamos" class="underline">Cómo calculamos</a>
      <a href="#que-es-indemnizacion" class="underline">¿Cuándo aplica indemnización?</a>
      <a href="#que-es-liquidacion" class="underline">¿Qué incluye liquidación?</a>
      <a href="#faq" class="underline">Preguntas frecuentes</a>
    </nav>

    <p class="mt-3 text-xs text-blue-100">
      <span class="opacity-80">Última actualización:</span>
      <time datetime="{{ now()->toDateString() }}">{{ now()->translatedFormat('d \\de F, Y') }}</time>
    </p>
  </section>

  {{-- Errores --}}
  @if ($errors->any())
    <div class="rounded-2xl border border-red-200 bg-red-50 p-4" role="alert" aria-live="polite">
      <p class="font-semibold text-red-700 mb-2">Revisa los campos:</p>
      <ul class="list-disc pl-5 space-y-1 text-red-700">
        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
      </ul>
    </div>
  @endif

  {{-- Selector de tipo de cálculo --}}
  <fieldset class="grid grid-cols-1 md:grid-cols-2 gap-4" aria-describedby="calc-type-help">
    <legend class="sr-only">Elige el tipo de cálculo</legend>

    <label for="calc_type_indem" class="group cursor-pointer rounded-2xl border p-5 transition-all hover:shadow-sm {{ old('calc_type','indemnizacion')==='indemnizacion' ? 'border-blue-300 ring-2 ring-blue-100' : 'border-gray-200' }}">
      <div class="flex items-start gap-3">
        <input id="calc_type_indem" type="radio" name="calc_type" value="indemnizacion" form="calc-form" class="mt-1 h-4 w-4 text-blue-600"
               {{ old('calc_type','indemnizacion')==='indemnizacion' ? 'checked' : '' }}>
        <div class="space-y-1">
          <div class="font-semibold">Indemnización (despido injustificado)</div>
          <p class="text-sm text-gray-600">
            Aplica cuando <strong>te despiden sin causa</strong>, hay <strong>rescisión imputable al patrón</strong>
            o <strong>no te reinstalan</strong>. <em>No aplica si renunciaste.</em>
          </p>
          <p class="text-sm text-gray-600">
            Incluye: <strong>3 meses de SDI</strong> + <strong>20 días por año</strong> + proporcionales
            (vacaciones, prima 25%, aguinaldo).
          </p>
        </div>
      </div>
    </label>

    <label for="calc_type_liq" class="group cursor-pointer rounded-2xl border p-5 transition-all hover:shadow-sm {{ old('calc_type')==='liquidacion' ? 'border-blue-300 ring-2 ring-blue-100' : 'border-gray-200' }}">
      <div class="flex items-start gap-3">
        <input id="calc_type_liq" type="radio" name="calc_type" value="liquidacion" form="calc-form" class="mt-1 h-4 w-4 text-blue-600"
               {{ old('calc_type')==='liquidacion' ? 'checked' : '' }}>
        <div class="space-y-1">
          <div class="font-semibold">Liquidación / Finiquito (renuncia o término)</div>
          <p class="text-sm text-gray-600">
            Úsala si <strong>renunciaste</strong>, hubo <strong>mutuo acuerdo</strong>, terminó el contrato
            por tiempo determinado o existió <strong>cambio de condiciones</strong> sin despido.
          </p>
          <p class="text-sm text-gray-600">
            Incluye sueldos pendientes y proporcionales: vacaciones + prima 25%, aguinaldo y otras prestaciones.
          </p>
        </div>
      </div>
    </label>
  </fieldset>
  <p id="calc-type-help" class="sr-only">Selecciona si tu caso es despido injustificado (indemnización) o término/renuncia (liquidación/finiquito).</p>

  {{-- Cómo usar (apoya HowTo) --}}
  <section id="como-usar" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold mb-3">Cómo usar la calculadora</h3>
    <ol class="list-decimal pl-6 text-sm text-gray-700 space-y-2 leading-7">
      <li>Elige <strong>Indemnización</strong> o <strong>Liquidación/Finiquito</strong>.</li>
      <li>Captura <strong>SD</strong> o <strong>SDI</strong>, y tus <strong>fechas</strong> de inicio y último día laborado.</li>
      <li>Selecciona tu <strong>zona salarial</strong> (General o Frontera Norte).</li>
      <li>Pulsa <strong>Calcular</strong> para ver el <strong>desglose</strong> y la <strong>base legal</strong>.</li>
    </ol>
  </section>

  {{-- Formulario --}}
  <form id="calc-form" method="POST" action="{{ route('calculate') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6" aria-label="Formulario de cálculo de indemnización o liquidación">
    @csrf

    <section class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <h3 class="text-lg font-semibold mb-4">Datos del trabajador</h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label for="name" class="block text-sm font-medium">Nombre completo <span class="text-red-600">*</span></label>
          <input id="name" name="name" value="{{ old('name') }}" required
                 placeholder="Como aparece en tu nómina (ej. Ana Pérez)"
                 class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500"
                 aria-describedby="name_help">
          <p id="name_help" class="text-xs text-gray-500 mt-1">Solo para identificar tu cálculo. No almacenamos datos sensibles.</p>
        </div>

        <div>
          <label for="daily_salary" class="block text-sm font-medium">Salario Diario (SD) <span class="text-red-600">*</span></label>
          <input id="daily_salary" name="daily_salary" type="number" step="0.01" min="0" value="{{ old('daily_salary') }}" required
                 placeholder="Ej. 400.00"
                 class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500"
                 aria-describedby="sd_help">
          <p id="sd_help" class="text-xs text-gray-500 mt-1">Si solo tienes sueldo: mensual ÷ 30, quincenal ÷ 15, semanal ÷ 7.</p>
        </div>

        <div>
          <label for="sdi" class="block text-sm font-medium">Salario Diario Integrado (SDI) <span class="text-gray-400">(opcional)</span></label>
          <input id="sdi" name="sdi" type="number" step="0.01" min="0" value="{{ old('sdi') }}"
                 placeholder="Si no lo conoces, déjalo vacío"
                 class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500"
                 aria-describedby="sdi_help">
          <p id="sdi_help" class="text-xs text-gray-500 mt-1">Suele mostrarse en tu portal de nómina o visor del IMSS.</p>
        </div>

        <div>
          <label for="zone" class="block text-sm font-medium">Zona salarial <span class="text-red-600">*</span></label>
          <select id="zone" name="zone" class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500" aria-describedby="zone_help">
            <option value="general"  {{ old('zone','general')==='general' ? 'selected' : '' }}>General (mayoría del país)</option>
            <option value="frontera" {{ old('zone')==='frontera' ? 'selected' : '' }}>Zona Libre de la Frontera Norte</option>
          </select>
          <p id="zone_help" class="sr-only">Selecciona General o Frontera Norte según tu ubicación laboral.</p>
          <details class="mt-1 text-xs text-gray-500">
            <summary class="cursor-pointer underline">¿Estoy en Frontera Norte?</summary>
            Municipios de la franja fronteriza (BC, Sonora, Chihuahua, Coahuila, Nuevo León, Tamaulipas).
          </details>
        </div>

        <div>
          <label for="start_date" class="block text-sm font-medium">Fecha de inicio <span class="text-red-600">*</span></label>
          <input id="start_date" name="start_date" type="date" value="{{ old('start_date') }}" required
                 class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500"
                 aria-describedby="start_help">
          <p id="start_help" class="text-xs text-gray-500 mt-1">Primer día laborado.</p>
        </div>

        <div>
          <label for="end_date" class="block text-sm font-medium">Último día laborado <span class="text-red-600">*</span></label>
          <input id="end_date" name="end_date" type="date" value="{{ old('end_date') }}" required
                 class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500"
                 aria-describedby="end_help">
          <p id="end_help" class="text-xs text-gray-500 mt-1">Día efectivo de término de la relación laboral.</p>
        </div>
      </div>

      <div class="mt-6 flex items-center justify-between gap-3">
        <p class="text-xs text-gray-500">* Estimaciones con base en LFT. Verás desglose y fundamentos legales en el resultado.</p>
        <button aria-label="Calcular indemnización o liquidación"
                class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-medium shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
          Calcular
        </button>
      </div>
    </section>

    <aside class="space-y-6">
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-base font-semibold mb-3">Guía rápida</h3>
        <ul class="text-sm text-gray-700 space-y-2 leading-6">
          <li>• <strong>Indemnización</strong>: despido injustificado, negativa de reinstalación o rescisión por causa del patrón.</li>
          <li>• <strong>Liquidación/Finiquito</strong>: renuncia, mutuo acuerdo o término de contrato.</li>
          <li>• <strong>SD</strong> = salario por día. <strong>SDI</strong> = SD + prestaciones.</li>
        </ul>
        <details id="que-es-indemnizacion" class="mt-3 text-sm text-gray-600">
          <summary class="cursor-pointer font-medium underline">¿Qué es la indemnización?</summary>
          3 meses de SDI + 20 días por año cuando corresponde (arts. 48–50), más proporcionales.
        </details>
        <details id="que-es-liquidacion" class="mt-2 text-sm text-gray-600">
          <summary class="cursor-pointer font-medium underline">¿Qué incluye la liquidación/finiquito?</summary>
          Sueldos pendientes, vacaciones y prima 25% (arts. 76 y 80) y aguinaldo proporcional (art. 87).
        </details>
      </div>

      {{-- Anuncio (responsivo) --}}
      @includeIf('partials.ads.responsive', ['slot' => '1234567890'])
    </aside>
  </form>

  {{-- Cómo calculamos (intención informativa + palabras clave) --}}
  <section id="como-calculamos" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold mb-3">¿Cómo calculamos la indemnización o liquidación?</h3>
    <p class="text-sm text-gray-700 leading-7">
      Usamos tu <strong>SD/SDI</strong>, <strong>antigüedad</strong> y fechas para obtener: <em>3 meses de SDI</em>,
      <em>20 días por año</em> (cuando aplica), <em>vacaciones</em> + <em>prima vacacional 25%</em> y <em>aguinaldo proporcional</em>.
      Fundamento LFT: arts. 48–50, 76, 80 y 87.
    </p>
  </section>

  {{-- FAQ --}}
  <section id="faq" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold mb-4">Preguntas frecuentes</h3>
    <div class="space-y-4">
      <details class="group">
        <summary class="cursor-pointer font-medium">¿Con qué base legal se calcula?</summary>
        <div class="mt-2 text-sm text-gray-700">Indemnización: arts. 48–50 LFT. Vacaciones y prima: 76 y 80. Aguinaldo: 87.</div>
      </details>
      <details class="group">
        <summary class="cursor-pointer font-medium">¿Qué diferencia hay entre SD y SDI?</summary>
        <div class="mt-2 text-sm text-gray-700">El SDI integra prestaciones y suele usarse para bases indemnizatorias. Si no lo conoces, usamos SD.</div>
      </details>
      <details class="group">
        <summary class="cursor-pointer font-medium">¿El resultado es definitivo?</summary>
        <div class="mt-2 text-sm text-gray-700">No. Es una estimación orientativa que puede variar por contrato, convenios o juicio.</div>
      </details>
    </div>
  </section>
</div>

{{-- JSON-LD extra (WebPage + BreadcrumbList + HowTo + FAQPage) --}}
@push('head')
  @php
    $webPageLd = [
      '@context' => 'https://schema.org',
      '@type' => 'WebPage',
      'name' => 'Calculadora de indemnización y liquidación (LFT México) ' . now()->year,
      'url' => url()->current(),
      'dateModified' => now()->toIso8601String(),
      'inLanguage' => 'es-MX',
      'about' => [
        ['@type'=>'Thing','name'=>'indemnización por despido injustificado'],
        ['@type'=>'Thing','name'=>'liquidación finiquito'],
        ['@type'=>'Thing','name'=>'Ley Federal del Trabajo'],
      ],
    ];
    $breadcrumbsLd = [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        ['@type'=>'ListItem','position'=>1,'name'=>'Inicio','item'=>url('/')],
        ['@type'=>'ListItem','position'=>2,'name'=>'Calculadora laboral','item'=>url()->current()],
      ],
    ];
    $howToLd = [
      '@context' => 'https://schema.org',
      '@type' => 'HowTo',
      'name' => 'Cómo usar la calculadora de indemnización y liquidación',
      'description' => 'Pasos para obtener una estimación conforme a la LFT en México.',
      'step' => [
        ['@type'=>'HowToStep','name'=>'Seleccionar tipo','text'=>'Elige Indemnización o Liquidación/Finiquito.'],
        ['@type'=>'HowToStep','name'=>'Ingresar datos','text'=>'Captura SD o SDI y tus fechas de inicio/último día.'],
        ['@type'=>'HowToStep','name'=>'Elegir zona salarial','text'=>'Selecciona General o Frontera Norte.'],
        ['@type'=>'HowToStep','name'=>'Calcular','text'=>'Pulsa Calcular para ver el desglose y la base legal.'],
      ],
    ];
    $faqLd = [
      '@context' => 'https://schema.org',
      '@type' => 'FAQPage',
      'mainEntity' => [
        [
          '@type'=>'Question',
          'name'=>'¿Con qué base legal se calcula?',
          'acceptedAnswer'=>['@type'=>'Answer','text'=>'Indemnización: arts. 48–50 LFT. Vacaciones y prima: 76 y 80. Aguinaldo: 87.']
        ],
        [
          '@type'=>'Question',
          'name'=>'¿Qué diferencia hay entre SD y SDI?',
          'acceptedAnswer'=>['@type'=>'Answer','text'=>'El SDI integra prestaciones y suele usarse como base indemnizatoria. Si no lo conoces, usamos SD.']
        ],
        [
          '@type'=>'Question',
          'name'=>'¿El resultado es definitivo?',
          'acceptedAnswer'=>['@type'=>'Answer','text'=>'No. Es una estimación orientativa que puede variar por contrato, convenios o juicio.']
        ],
      ],
    ];
  @endphp
  <script type="application/ld+json">{!! json_encode($webPageLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
  <script type="application/ld+json">{!! json_encode($breadcrumbsLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
  <script type="application/ld+json">{!! json_encode($howToLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
  <script type="application/ld+json">{!! json_encode($faqLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@endsection
