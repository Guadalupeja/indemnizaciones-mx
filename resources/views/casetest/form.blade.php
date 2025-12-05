@extends('layouts.app')

@section('title', 'Test: ¿Me corresponde indemnización o finiquito?')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">

  {{-- MIGAS DE PAN VISIBLES --}}
<nav aria-label="miga de pan" class="text-sm text-gray-500">
  <ol class="flex flex-wrap items-center gap-2">
    <li>
      <a href="{{ route('inicio') }}" class="underline hover:no-underline">Inicio</a>
    </li>
    <li aria-hidden="true">/</li>
    <li class="text-gray-600">Test: ¿Indemnización o finiquito?</li>
  </ol>
</nav>


  {{-- HERO --}}
  <section class="rounded-3xl bg-gradient-to-r from-indigo-600 to-violet-600 p-6 text-white shadow">
    <h1 class="text-2xl md:text-3xl font-semibold">
      Test: ¿Me corresponde indemnización o finiquito?
    </h1>
    <p class="mt-2 text-indigo-50">
      Responde 6 preguntas rápidas y te diremos, de forma orientativa, qué te corresponde según la LFT.<br class="hidden sm:block">
      Al final podrás usar nuestra herramienta para <strong>calcular el monto</strong>.
    </p>

    {{-- Barra de progreso --}}
    <div class="mt-4">
      <div class="flex items-center justify-between text-xs text-indigo-100 mb-1">
        <span>Progreso</span>
        <span id="progress-label" aria-live="polite">0% completado</span>
      </div>
      <div class="h-2 w-full rounded-full bg-white/20">
        <div id="progress-bar" class="h-2 w-0 rounded-full bg-white transition-all duration-300"></div>
      </div>
    </div>
  </section>

  {{-- ERRORES --}}
  @if ($errors->any())
    <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert" aria-live="polite">
      <p class="font-semibold mb-2">Revisa los campos:</p>
      <ul class="list-disc pl-5 space-y-1">
        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form id="quiz-form" method="POST" action="{{ route('test-caso-laboral.decide') }}" class="space-y-6" autocomplete="off">
    @csrf

    {{-- PASO 1: Forma de terminación --}}
    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <header class="mb-4">
        <p class="text-xs font-medium text-gray-500">Paso 1 de 6</p>
        <h2 class="text-lg font-semibold">¿Cómo terminó la relación laboral?</h2>
      </header>

      @php
        $opts = [
          'despido'  => 'Me despidieron',
          'renuncia' => 'Renuncié',
          'mutuo'    => 'Mutuo acuerdo',
          'termino'  => 'Terminó el contrato (tenía fecha fin)',
          'abandono' => 'Abandono del trabajo',
        ];
      @endphp

      <div class="grid sm:grid-cols-2 gap-3">
        @foreach($opts as $val => $label)
          <label class="group relative cursor-pointer rounded-xl border border-gray-200 p-4 hover:border-indigo-300 hover:shadow transition">
            <input class="sr-only peer" type="radio" name="end_type" value="{{ $val }}" required
                   {{ old('end_type')===$val ? 'checked' : '' }}>
            <span class="absolute right-3 top-3 h-5 w-5 rounded-full border peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200"></span>
            <div class="flex items-start gap-3">
              <div class="mt-0.5 h-5 w-5 rounded-full border border-gray-300 bg-white peer-checked:border-indigo-600 peer-checked:bg-indigo-600 transition"></div>
              <div class="space-y-1">
                <div class="font-medium text-gray-900 group-hover:text-indigo-700">{{ $label }}</div>
                @if($val==='despido')
                  <p class="text-xs text-gray-500">Si hubo despido, responde también los pasos 2 y 3.</p>
                @endif
              </div>
            </div>
          </label>
        @endforeach
      </div>
    </section>

    {{-- PASO 2: Causa del despido --}}
    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <header class="mb-4">
        <p class="text-xs font-medium text-gray-500">Paso 2 de 6</p>
        <h2 class="text-lg font-semibold">Si hubo despido, ¿cuál fue la causa?</h2>
      </header>

      @php
        $causas = [
          'injustificada' => 'Injustificada / no hubo causa',
          'justificada'   => 'El patrón alega causa justificada',
          'no_sabe'       => 'No lo sé',
          'no_aplica'     => 'No aplica',
        ];
      @endphp

      <div class="grid sm:grid-cols-2 gap-3">
        @foreach($causas as $val => $label)
          <label class="group relative cursor-pointer rounded-xl border border-gray-200 p-4 hover:border-indigo-300 hover:shadow transition">
            <input class="sr-only peer" type="radio" name="dismissal_cause" value="{{ $val }}" required
                   {{ old('dismissal_cause') === $val ? 'checked' : '' }}>
            <span class="absolute right-3 top-3 h-5 w-5 rounded-full border peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200"></span>
            <div class="flex items-start gap-3">
              <div class="mt-0.5 h-5 w-5 rounded-full border border-gray-300 bg-white peer-checked:border-indigo-600 peer-checked:bg-indigo-600 transition"></div>
              <div class="space-y-1">
                <div class="font-medium text-gray-900 group-hover:text-indigo-700">{{ $label }}</div>
              </div>
            </div>
          </label>
        @endforeach
      </div>
    </section>

    {{-- PASO 3: Reinstalación --}}
    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <header class="mb-4">
        <p class="text-xs font-medium text-gray-500">Paso 3 de 6</p>
        <h2 class="text-lg font-semibold">¿Hubo ofrecimiento/negativa de reinstalación?</h2>
      </header>

      @php
        $rein = [
          'nego_reinstalacion'     => 'Sí: el patrón NEGÓ la reinstalación',
          'ofrecio_reinstalacion'  => 'Sí: el patrón ofreció reinstalación',
          'no_aplica'              => 'No aplica',
        ];
      @endphp

      <div class="grid sm:grid-cols-2 gap-3">
        @foreach($rein as $val => $label)
          <label class="group relative cursor-pointer rounded-xl border border-gray-200 p-4 hover:border-indigo-300 hover:shadow transition">
            <input class="sr-only peer" type="radio" name="reinstatement" value="{{ $val }}" required
                   {{ old('reinstatement') === $val ? 'checked' : '' }}>
            <span class="absolute right-3 top-3 h-5 w-5 rounded-full border peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200"></span>
            <div class="flex items-start gap-3">
              <div class="mt-0.5 h-5 w-5 rounded-full border border-gray-300 bg-white peer-checked:border-indigo-600 peer-checked:bg-indigo-600 transition"></div>
              <div class="space-y-1">
                <div class="font-medium text-gray-900 group-hover:text-indigo-700">{{ $label }}</div>
                @if($val==='no_aplica')
                  <p class="text-xs text-gray-500">La negativa de reinstalación suele inclinar a indemnización.</p>
                @endif
              </div>
            </div>
          </label>
        @endforeach
      </div>
    </section>

    {{-- PASO 4: Renuncia forzada --}}
    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <header class="mb-3">
        <p class="text-xs font-medium text-gray-500">Paso 4 de 6</p>
        <h2 class="text-lg font-semibold">¿Firmaste renuncia bajo presión?</h2>
      </header>

      <label class="inline-flex items-center gap-3 rounded-xl border border-gray-200 px-4 py-3 hover:border-indigo-300 hover:shadow transition">
        <input type="checkbox" name="forced_resignation" value="1"
               class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
               {{ old('forced_resignation') ? 'checked' : '' }}>
        <span class="text-gray-800">Sí, me forzaron a firmar</span>
      </label>
      <p class="text-xs text-gray-500 mt-2">Una renuncia forzada suele tratarse como despido.</p>
    </section>

    {{-- PASO 5: Banderas de protección (chips) --}}
    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <header class="mb-3">
        <p class="text-xs font-medium text-gray-500">Paso 5 de 6</p>
        <h2 class="text-lg font-semibold">¿Señales de protección aplicables?</h2>
      </header>

      <div class="flex flex-wrap gap-3">
        <label class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-4 py-2 hover:border-indigo-300 hover:shadow-sm transition">
          <input type="checkbox" name="discrimination" value="1"
                 class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                 {{ old('discrimination') ? 'checked' : '' }}>
          <span class="text-sm">Discriminación</span>
        </label>

        <label class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-4 py-2 hover:border-indigo-300 hover:shadow-sm transition">
          <input type="checkbox" name="pregnancy" value="1"
                 class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                 {{ old('pregnancy') ? 'checked' : '' }}>
          <span class="text-sm">Embarazo / maternidad</span>
        </label>

        <label class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-4 py-2 hover:border-indigo-300 hover:shadow-sm transition">
          <input type="checkbox" name="harassment" value="1"
                 class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                 {{ old('harassment') ? 'checked' : '' }}>
          <span class="text-sm">Acoso / hostigamiento</span>
        </label>
      </div>

      <p class="text-xs text-gray-500 mt-2">Estas banderas refuerzan escenarios de indemnización.</p>
    </section>

    {{-- PASO 6: Tipo de contrato --}}
    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <header class="mb-4">
        <p class="text-xs font-medium text-gray-500">Paso 6 de 6</p>
        <h2 class="text-lg font-semibold">¿Qué tipo de contrato tenías?</h2>
      </header>

      @php
        $contratos = [
          'indefinido'  => 'Indefinido',
          'determinado' => 'Determinado (con fecha fin)',
          'obra'        => 'Por obra o proyecto',
        ];
      @endphp

      <div class="grid sm:grid-cols-3 gap-3">
        @foreach($contratos as $val => $label)
          <label class="group relative cursor-pointer rounded-xl border border-gray-200 p-4 hover:border-indigo-300 hover:shadow transition">
            <input class="sr-only peer" type="radio" name="contract_type" value="{{ $val }}" required
                   {{ old('contract_type') === $val ? 'checked' : '' }}>
            <span class="absolute right-3 top-3 h-5 w-5 rounded-full border peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200"></span>
            <div class="flex items-start gap-3">
              <div class="mt-0.5 h-5 w-5 rounded-full border border-gray-300 bg-white peer-checked:border-indigo-600 peer-checked:bg-indigo-600 transition"></div>
              <div class="font-medium text-gray-900 group-hover:text-indigo-700">{{ $label }}</div>
            </div>
          </label>
        @endforeach
      </div>
    </section>

    {{-- CTA --}}
    <div class="sticky bottom-4 z-10">
      <div class="rounded-2xl border border-gray-200 bg-white/90 backdrop-blur p-4 shadow-lg flex items-center justify-between gap-4">
        <p class="text-xs text-gray-600">
          Resultado orientativo conforme a LFT. No sustituye asesoría jurídica.
        </p>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
          Ver mi resultado
        </button>
      </div>
    </div>
  </form>

  {{-- Enlaces secundarios --}}
  <footer class="text-sm text-gray-500">
    <nav class="flex flex-wrap gap-4">
      <a class="hover:underline" href="{{ route('que-es-indemnizacion') }}">¿Qué es indemnización?</a>
      <a class="hover:underline" href="{{ route('que-es-liquidacion') }}">¿Qué es liquidación?</a>
      <a class="hover:underline" href="{{ route('faq') }}">Preguntas frecuentes</a>
      <a class="hover:underline" href="{{ route('aviso-privacidad') }}">Aviso de privacidad</a>
    </nav>
  </footer>
</div>

{{-- Script mínimo para progreso --}}
@push('scripts')
<script>
  (function () {
    const form = document.getElementById('quiz-form');
    const progressBar = document.getElementById('progress-bar');
    const progressLabel = document.getElementById('progress-label');

    // Requeridos del quiz
    const requiredNames = ['end_type','dismissal_cause','reinstatement','contract_type'];

    function percent() {
      let filled = 0;
      // radios requeridos
      requiredNames.forEach(n => {
        const checked = form.querySelector(`input[name="${n}"]:checked`);
        if (checked) filled++;
      });
      // check de renuncia forzada / banderas no suman para no sesgar el % final
      return Math.round((filled / requiredNames.length) * 100);
    }

    function update() {
      const p = percent();
      progressBar.style.width = p + '%';
      progressLabel.textContent = p + '% completado';
    }

    form.addEventListener('change', update);
    update(); // init
  })();
</script>
@endpush
{{-- Breadcrumbs JSON-LD para Test --}}
@include('partials.seo.breadcrumbs', [
  'items' => [
    ['name'=>'Inicio','url'=>route('inicio')],
    ['name'=>'Test: ¿Indemnización o finiquito?','url'=>url()->current()]
  ]
])

{{-- HowTo JSON-LD para Test --}}
@include('partials.seo.howto')

@endsection
