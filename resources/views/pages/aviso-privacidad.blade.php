@extends('layouts.app')

@section('title', 'Aviso de privacidad')
@section('meta_description', 'Aviso de privacidad: responsable, finalidades, base jurídica, derechos ARCO y medios de contacto para la calculadora de indemnización y liquidación (LFT México).')

@section('content')
<section class="prose prose-blue max-w-none">
  <h2>Aviso de privacidad</h2>

  <p>
    Este Aviso de Privacidad aplica al sitio y herramienta
    <strong>{{ config('app.name', 'Calculadora LFT') }}</strong> (la “Herramienta”).
    El responsable del tratamiento es
    <strong>{{ env('APP_OWNER_NAME', 'Profesional independiente') }}</strong>
    @if(env('APP_OWNER_ORG'))
      ({{ env('APP_OWNER_ORG') }})
    @endif
    @php
      // Si quieres mostrar tu nombre personal, agrega aquí en texto plano o vía env
      $responsablePersonal = ''; // "Responsable: Guadalupe Juárez Arias"
    @endphp
    @if(!empty($responsablePersonal))
      — {!! $responsablePersonal !!}
    @endif
    , con domicilio en
    <strong>{{ env('APP_OWNER_ADDRESS_CITY', 'México') }}</strong>.
  </p>

  <h3>Datos que tratamos</h3>
  <p>
    La Herramienta está diseñada con enfoque de <em>minimización de datos</em>.
    No solicita datos sensibles. Los valores que ingresas (p. ej. nombre, SD/SDI, fechas)
    se usan únicamente para realizar el cálculo en tu navegador o en el servidor y mostrarte
    un resultado. No realizamos perfiles ni transferimos datos a terceros.
  </p>

  <h3>Finalidades del tratamiento</h3>
  <ul>
    <li>Generar el cálculo de indemnización o liquidación con base en los datos que proporcionas.</li>
    @if(env('APP_PRIVACY_PURPOSES'))
      <li>{{ env('APP_PRIVACY_PURPOSES') }}.</li>
    @endif
    <li>Mejorar la calidad y disponibilidad de la Herramienta.</li>
  </ul>

  <h3>Base jurídica</h3>
  <p>
    El tratamiento se realiza con tu consentimiento al usar la Herramienta y, en su caso,
    para la ejecución de la propia funcionalidad solicitada por ti (proveer el cálculo).
  </p>

  <h3>Conservación</h3>
  @if(env('APP_PRIVACY_RETENTION_DAYS') !== null && env('APP_PRIVACY_RETENTION_DAYS') !== false && env('APP_PRIVACY_RETENTION_DAYS') !== '')
    <p>Conservamos la información por el tiempo estrictamente necesario para las finalidades indicadas ({{ env('APP_PRIVACY_RETENTION_DAYS') }} días), salvo obligaciones legales aplicables.</p>
  @else
    <p>
      No almacenamos de manera permanente la información de tus cálculos. Si en el futuro
      se habilitan funciones que impliquen retención, lo informaremos y solicitaremos tu consentimiento.
    </p>
  @endif

  <h3>Transferencias</h3>
  <p>No realizamos transferencias de tus datos a terceros, salvo las que sean exigidas por autoridad competente.</p>

  <h3>Derechos ARCO y contacto</h3>
  <p>
    Puedes ejercer tus derechos de acceso, rectificación, cancelación u oposición (ARCO),
    así como revocar tu consentimiento, escribiendo a:
    <a class="underline" href="mailto:{{ env('APP_CONTACT_EMAIL','contacto@example.com') }}">
      {{ env('APP_CONTACT_EMAIL','contacto@example.com') }}
    </a>.
    @if(env('APP_CONTACT_PHONE'))
      También vía telefónica al {{ env('APP_CONTACT_PHONE') }}.
    @endif
    @if(env('APP_PRIVACY_CONTACT_URL'))
      O mediante el formulario: <a class="underline" href="{{ env('APP_PRIVACY_CONTACT_URL') }}">{{ env('APP_PRIVACY_CONTACT_URL') }}</a>.
    @endif
  </p>

  <h3>Uso de cookies y tecnologías similares</h3>
  <p>
    Podemos usar cookies esenciales para el funcionamiento del sitio y, en su caso,
    servicios de medición (p. ej., Google Tag Manager/Analytics) únicamente para fines estadísticos y de mejora.
    Puedes gestionar las cookies desde la configuración de tu navegador.
  </p>

  <h3>Seguridad</h3>
  <p>
    Implementamos medidas administrativas y técnicas razonables para proteger la información
    durante su tránsito y uso en la Herramienta.
  </p>

  <h3>Actualizaciones del aviso</h3>
  <p>
    Este aviso puede actualizarse. Publicaremos los cambios en esta página.
    Fecha de última actualización:
    <strong>{{ env('APP_PRIVACY_EFFECTIVE', now()->toDateString()) }}</strong>.
  </p>

  <p class="mt-6">
    <a href="{{ route('inicio') }}" class="text-blue-600 underline">Volver a la calculadora</a>
  </p>

  <hr>
  <p class="text-xs text-gray-500">
    Nota: Esta información es de carácter informativo y no constituye asesoría legal.
  </p>
</section>
@endsection
