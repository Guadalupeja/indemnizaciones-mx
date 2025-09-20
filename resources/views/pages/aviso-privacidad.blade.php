@extends('layouts.app')

@section('title', 'Aviso de privacidad')
@section('meta_description', 'Aviso de privacidad: responsable, finalidades, base jurídica, derechos ARCO y medios de contacto para la calculadora de indemnización y liquidación (LFT México).')

@push('head')
  @php
    $ld = [
      '@context' => 'https://schema.org',
      '@type' => 'WebPage',
      'name' => 'Aviso de privacidad',
      'url' => url()->current(),
      'dateModified' => env('APP_PRIVACY_EFFECTIVE', now()->toDateString()),
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
        <li class="opacity-90">Aviso de privacidad</li>
      </ol>
    </nav>
    <h2 class="text-3xl font-semibold">Aviso de privacidad</h2>
    <p class="mt-2 text-blue-50">Cómo tratamos tus datos, finalidades y medios de contacto.</p>
  </section>

  {{-- Contenido --}}
  <article class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm prose prose-blue max-w-none">
    <p>
      Este Aviso de Privacidad aplica al sitio y herramienta
      <strong>{{ config('app.name', 'Calculadora LFT') }}</strong> (la “Herramienta”).
      El responsable del tratamiento es
      <strong>{{ env('APP_OWNER_NAME', 'Profesional independiente') }}</strong>
      @if(env('APP_OWNER_ORG')) ({{ env('APP_OWNER_ORG') }}) @endif,
      con domicilio en <strong>{{ env('APP_OWNER_ADDRESS_CITY', 'México') }}</strong>.
    </p>

    <h3>Datos que tratamos</h3>
    <p>
      La Herramienta está diseñada con enfoque de <em>minimización de datos</em>. No solicita datos sensibles.
      Los valores que ingresas (p. ej. nombre, SD/SDI, fechas) se usan únicamente para calcular y mostrar un resultado.
      No realizamos perfiles ni transferimos datos a terceros.
    </p>

    <h3>Finalidades</h3>
    <ul>
      <li>Generar el cálculo de indemnización o liquidación con base en los datos proporcionados.</li>
      @if(env('APP_PRIVACY_PURPOSES'))
        <li>{{ env('APP_PRIVACY_PURPOSES') }}.</li>
      @endif
      <li>Mejorar la calidad y disponibilidad de la Herramienta.</li>
    </ul>

    <h3>Base jurídica</h3>
    <p>Consentimiento y, en su caso, ejecución de la funcionalidad solicitada (el cálculo) por parte del usuario.</p>

    <h3>Conservación</h3>
    @if(env('APP_PRIVACY_RETENTION_DAYS') !== null && env('APP_PRIVACY_RETENTION_DAYS') !== false && env('APP_PRIVACY_RETENTION_DAYS') !== '')
      <p>Conservamos la información por {{ env('APP_PRIVACY_RETENTION_DAYS') }} días, salvo obligaciones legales aplicables.</p>
    @else
      <p>No almacenamos de manera permanente la información de tus cálculos.</p>
    @endif

    <h3>Transferencias</h3>
    <p>No transferimos tus datos a terceros, salvo requerimiento de autoridad competente.</p>

    <h3>Derechos ARCO y contacto</h3>
    <p>
      Para ejercer tus derechos de acceso, rectificación, cancelación u oposición, o revocar tu consentimiento,
      contáctanos en
      <a class="underline" href="mailto:{{ env('APP_CONTACT_EMAIL','contacto@example.com') }}">{{ env('APP_CONTACT_EMAIL','contacto@example.com') }}</a>.
      @if(env('APP_CONTACT_PHONE'))
        También al {{ env('APP_CONTACT_PHONE') }}.
      @endif
      @if(env('APP_PRIVACY_CONTACT_URL'))
        O vía formulario: <a class="underline" href="{{ env('APP_PRIVACY_CONTACT_URL') }}">{{ env('APP_PRIVACY_CONTACT_URL') }}</a>.
      @endif
    </p>

    <h3>Cookies</h3>
    <p>
      Podemos usar cookies esenciales y, en su caso, medición (p. ej., Google Tag Manager/Analytics) con fines estadísticos.
      Adminístralas desde la configuración de tu navegador.
    </p>

    <h3>Seguridad</h3>
    <p>Aplicamos medidas administrativas y técnicas razonables para proteger la información durante su uso.</p>

    <h3>Actualizaciones</h3>
    <p>
      Publicaremos cambios en esta página. Última actualización:
      <strong>{{ env('APP_PRIVACY_EFFECTIVE', now()->toDateString()) }}</strong>.
    </p>

    <p class="mt-6">
      <a href="{{ route('inicio') }}"
         class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
        Volver a la calculadora
      </a>
    </p>

    <hr>
    <p class="text-xs text-gray-500">Esta información es orientativa y no constituye asesoría legal.</p>
  </article>
@endsection
