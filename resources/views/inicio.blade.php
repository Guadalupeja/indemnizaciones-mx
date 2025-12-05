@extends('layouts.app')

@section('title', 'Calculadora de Indemnización y Liquidación LFT ' . now()->year . ' en México – Cálculo gratis')
@section('meta_description', 'Calculadora gratuita para estimar indemnización por despido injustificado o liquidación/finiquito conforme a la Ley Federal del Trabajo en México. Usa SD/SDI, antigüedad y fechas. Desglose detallado y base legal actualizada ' . now()->year . '.')

@section('content')
<div class="space-y-10">

  {{-- Breadcrumbs visibles --}}
  <nav class="text-sm text-gray-500" aria-label="miga de pan">
    <ol class="flex flex-wrap items-center gap-2">
      <li><a class="underline hover:no-underline" href="{{ route('inicio') }}">Inicio</a></li>
      <li aria-hidden="true">/</li>
      <li class="text-gray-600">Calculadora laboral</li>
    </ol>
  </nav>
{{-- JSON-LD: Breadcrumbs para Inicio --}}
@include('partials.seo.breadcrumbs', [
  'items' => [
    ['name'=>'Inicio','url'=>route('inicio')],
    ['name'=>'Calculadora laboral','url'=>url()->current()]
  ]
])

  {{-- Hero con CTA del test --}}
  <section class="rounded-3xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white shadow">
    <h2 class="text-3xl font-semibold">
      Calculadora de indemnización y liquidación (LFT México) {{ now()->year }}
    </h2>
    <p class="mt-2 text-blue-50">
      Estima en minutos tu <strong>indemnización por despido injustificado</strong> o tu
      <strong>liquidación/finiquito</strong> conforme a la LFT vigente. Gratis y sin registro.
    </p>

    <div class="mt-4 flex flex-wrap gap-3">
      <a href="{{ route('test-caso-laboral') }}"
         class="inline-flex items-center rounded-xl bg-violet-600 px-4 py-2 text-white shadow hover:bg-violet-700">
        ¿No sabes cuál usar? Haz el test
      </a>
      <a href="#como-usar"
         class="inline-flex items-center rounded-xl border border-white/40 px-4 py-2 text-white/90 hover:bg-white/10">
        Cómo funciona
      </a>
    </div>

    <nav class="mt-4 text-sm text-blue-100 flex flex-wrap gap-4" role="navigation" aria-label="Contenido de la página">
      <a href="#como-usar" class="underline">Cómo usar</a>
      <a href="#supuestos" class="underline">Supuestos</a>
      <a href="#como-calculamos" class="underline">Cómo calculamos</a>
      <a href="#fuentes" class="underline">Fuentes</a>
      <a href="#faq" class="underline">FAQ</a>
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

  {{-- Cómo usar --}}
  <section id="como-usar" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold mb-3">Cómo usar</h3>
    <ol class="list-decimal pl-6 text-sm text-gray-700 space-y-2 leading-7">
      <li>Elige <strong>Indemnización</strong> o <strong>Liquidación/Finiquito</strong>. Si tienes duda,
        <a class="text-indigo-600 underline hover:no-underline" href="{{ route('test-caso-laboral') }}">haz el test de 6 preguntas</a>.
      </li>
      <li>Captura <strong>SD/SDI</strong> y <strong>fechas</strong> de ingreso y baja.</li>
      <li>Selecciona tu <strong>zona salarial</strong> (General o Frontera Norte).</li>
      <li>Ajusta los <strong>Supuestos</strong> (si aplica) y pulsa <strong>Calcular</strong>.</li>
    </ol>
  </section>

  {{-- Formulario --}}
  <form id="calc-form" method="POST" action="{{ route('calculate') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6" aria-label="Formulario de cálculo">
    @csrf

    <section class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <h3 class="text-lg font-semibold mb-4">Datos del trabajador</h3>

      {{-- Micro-banner sobre el test --}}
      <div class="mb-4 rounded-xl border border-violet-200 bg-violet-50 p-3 text-sm text-violet-900">
        ¿Dudas si te toca <strong>indemnización</strong> o <strong>finiquito</strong>?
        <a class="font-medium underline hover:no-underline" href="{{ route('test-caso-laboral') }}">Haz el test rápido</a>
        y precargamos la opción correcta.
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label for="name" class="block text-sm font-medium">Nombre completo <span class="text-red-600">*</span></label>
          <input id="name" name="name" value="{{ old('name') }}" required
                 placeholder="Como aparece en tu nómina"
                 class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label for="daily_salary" class="block text-sm font-medium">Salario Diario (SD) <span class="text-red-600">*</span></label>
          <input id="daily_salary" name="daily_salary" type="number" step="0.01" min="0" value="{{ old('daily_salary') }}" required
                 placeholder="Ej. 400.00"
                 class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
          <p class="text-xs text-gray-500 mt-1">Si solo tienes sueldo: mensual ÷ 30, quincenal ÷ 15, semanal ÷ 7.</p>
        </div>

        <div>
          <label for="sdi" class="block text-sm font-medium">Salario Diario Integrado (SDI) <span class="text-gray-400">(opcional)</span></label>
          <input id="sdi" name="sdi" type="number" step="0.01" min="0" value="{{ old('sdi') }}"
                 placeholder="Si no lo conoces, déjalo vacío"
                 class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
          <p class="text-xs text-gray-500 mt-1">Se usa para 3 meses y 20 días/año en indemnización.</p>
        </div>

        <div>
          <label for="zone" class="block text-sm font-medium">Zona salarial <span class="text-red-600">*</span></label>
          <select id="zone" name="zone" class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
            <option value="general"  {{ old('zone','general')==='general' ? 'selected' : '' }}>General</option>
            <option value="frontera" {{ old('zone')==='frontera' ? 'selected' : '' }}>Frontera Norte</option>
          </select>
          <p class="sr-only" id="zone_help">Selecciona General o Frontera Norte.</p>
        </div>

        <div>
          <label for="start_date" class="block text-sm font-medium">Fecha de inicio <span class="text-red-600">*</span></label>
          <input id="start_date" name="start_date" type="date" value="{{ old('start_date') }}" required
                 class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label for="end_date" class="block text-sm font-medium">Último día laborado <span class="text-red-600">*</span></label>
          <input id="end_date" name="end_date" type="date" value="{{ old('end_date') }}" required
                 class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
        </div>
      </div>

      {{-- Selector de tipo de cálculo --}}
      <hr class="my-6">
      <fieldset class="grid grid-cols-1 md:grid-cols-2 gap-4" aria-describedby="calc-type-help">
        <legend class="sr-only">Elige el tipo de cálculo</legend>

        @php $defType = request('calc_type', old('calc_type','indemnizacion')); @endphp

        <label for="calc_type_indem" class="group cursor-pointer rounded-2xl border p-5 transition-all hover:shadow-sm {{ $defType==='indemnizacion' ? 'border-blue-300 ring-2 ring-blue-100' : 'border-gray-200' }}">
          <div class="flex items-start gap-3">
            <input id="calc_type_indem" type="radio" name="calc_type" value="indemnizacion" form="calc-form"
                   class="mt-1 h-4 w-4 text-blue-600" {{ $defType==='indemnizacion' ? 'checked' : '' }}>
            <div class="space-y-1">
              <div class="font-semibold">Indemnización (despido injustificado)</div>
              <p class="text-sm text-gray-600">
                Aplica si <strong>te despiden sin causa</strong>, hay <strong>rescisión imputable al patrón</strong> o
                <strong>no te reinstalan</strong>. <em>No aplica si renunciaste.</em>
              </p>
              <p class="text-sm text-gray-600">
                Incluye <strong>3 meses de SDI</strong> + <strong>20 días por año</strong> (cuando procede) + proporcionales.
              </p>
            </div>
          </div>
        </label>

        <label for="calc_type_liq" class="group cursor-pointer rounded-2xl border p-5 transition-all hover:shadow-sm {{ $defType==='liquidacion' ? 'border-blue-300 ring-2 ring-blue-100' : 'border-gray-200' }}">
          <div class="flex items-start gap-3">
            <input id="calc_type_liq" type="radio" name="calc_type" value="liquidacion" form="calc-form"
                   class="mt-1 h-4 w-4 text-blue-600" {{ $defType==='liquidacion' ? 'checked' : '' }}>
            <div class="space-y-1">
              <div class="font-semibold">Liquidación / Finiquito (renuncia o término)</div>
              <p class="text-sm text-gray-600">
                Úsala si <strong>renunciaste</strong>, hubo <strong>mutuo acuerdo</strong> o terminó el contrato sin despido.
              </p>
              <p class="text-sm text-gray-600">
                Incluye sueldos pendientes y proporcionales: vacaciones + prima 25% y aguinaldo. <em>No incluye</em> 3 meses ni 20 días/año.
              </p>
            </div>
          </div>
        </label>
      </fieldset>
      <p id="calc-type-help" class="sr-only">Selecciona Indemnización o Liquidación/Finiquito.</p>

      {{-- Avisos dinámicos --}}
      <div class="mt-3 space-y-3" id="supuestos">
        <div data-show-for="indemnizacion" class="rounded-xl border border-blue-200 bg-blue-50 text-blue-900 p-4">
          <p class="text-sm">
            <strong>Indemnización:</strong> Incluye 3 meses de SDI y puede incluir 20 días/año si procede; la prima de antigüedad se paga aun con &lt; 15 años (tope 2× SM, art. 162).
          </p>
        </div>
        <div data-show-for="liquidacion" class="hidden rounded-xl border border-amber-200 bg-amber-50 text-amber-900 p-4">
          <p class="text-sm">
            <strong>Finiquito:</strong> No incluye 3 meses ni 20 días/año; la prima de antigüedad solo aplica si ≥ 15 años.
          </p>
        </div>
      </div>

      {{-- SUPUESTOS (bloques/inputs) --}}
      <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- (SOLO INDEMNIZACIÓN) Tipo de contrato --}}
        <div data-show-for="indemnizacion">
          <label class="block text-sm font-medium">
            Tipo de contrato <span class="text-gray-400 text-xs">(solo indemnización)</span>
          </label>
          <select name="contract_type" class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
            <option value="indefinido" {{ old('contract_type','indefinido')==='indefinido'?'selected':'' }}>
              Indeterminado (regla general)
            </option>
            <option value="determinado_mas_un_ano" {{ old('contract_type')==='determinado_mas_un_ano'?'selected':'' }}>
              Determinado (≥ 1 año)
            </option>
            <option value="determinado_menos_un_ano" {{ old('contract_type')==='determinado_menos_un_ano'?'selected':'' }}>
              Determinado (&lt; 1 año)
            </option>
          </select>
          <p class="text-xs text-gray-500 mt-1">
            Se usa en modo “Automático” para decidir si proceden <strong>20 días por año</strong>.
          </p>
        </div>

        {{-- (SOLO INDEMNIZACIÓN) Reinstalación válida --}}
        <div data-show-for="indemnizacion">
          <label class="block text-sm font-medium">
            Reinstalación <span class="text-gray-400 text-xs">(solo indemnización)</span>
          </label>
          <label class="mt-2 flex items-center gap-2 text-sm">
            <input type="checkbox" name="reinstalacion_valida" value="1" {{ old('reinstalacion_valida') ? 'checked' : '' }}>
            Hubo <strong>oferta y reinstalación válida</strong> (normalmente no proceden 20 días/año).
          </label>
          <p class="text-xs text-gray-500 mt-1">
            Si hubo reinstalación válida, usualmente se excluyen los 20 días/año.
          </p>
        </div>

        {{-- (SOLO INDEMNIZACIÓN) 20 días por año --}}
        <div data-show-for="indemnizacion">
          <label class="block text-sm font-medium">
            ¿Proceden 20 días por año? <span class="text-gray-400 text-xs">(solo indemnización)</span>
          </label>
          <select name="twenty_mode" class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
            <option value="auto" {{ old('twenty_mode','auto')==='auto'?'selected':'' }}>Automático (según contrato/reinstalación)</option>
            <option value="si"   {{ old('twenty_mode')==='si'?'selected':'' }}>Sí (forzar inclusión)</option>
            <option value="no"   {{ old('twenty_mode')==='no'?'selected':'' }}>No (forzar exclusión)</option>
          </select>
          <p class="text-xs text-gray-500 mt-1">
            Base legal: arts. 48–50 LFT. <em>No aplica</em> en Finiquito.
          </p>
        </div>

        {{-- Prima de antigüedad (ambos; regla especial en finiquito) --}}
        <div>
          <label class="block text-sm font-medium">Prima de antigüedad</label>
          <div class="mt-2 space-y-2">
            <label class="flex items-center gap-2 text-sm">
              <input type="checkbox" name="seniority_proportional" value="1" {{ old('seniority_proportional',1)?'checked':'' }}>
              Calcular proporcional por fracción de año
            </label>
            <label class="flex items-center gap-2 text-sm" data-show-for="indemnizacion">
              <input type="checkbox" name="seniority_in_despido" value="1" {{ old('seniority_in_despido',1)?'checked':'' }}>
              Pagar aun con &lt; 15 años (solo en despido)
            </label>
          </div>
          <p class="text-xs text-gray-500 mt-1">
            Art. 162 LFT: 12 días/año con tope a 2× salario mínimo. En <strong>Finiquito</strong> solo si la antigüedad es <strong>≥ 15 años</strong>.
          </p>
        </div>

        {{-- Ajustes (ambos) --}}
        <div>
          <label class="block text-sm font-medium">Ajustes por pagos previos</label>
          <div class="mt-2 grid grid-cols-2 gap-3">
            <div>
              <label class="text-xs text-gray-600">Vacaciones ya gozadas (días)</label>
              <input type="number" min="0" step="0.01" name="vac_days_taken"
                     value="{{ old('vac_days_taken',0) }}"
                     class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
              <p class="text-[11px] text-gray-500">Se descuenta SD×días y su prima (25%).</p>
            </div>
            <div>
              <label class="text-xs text-gray-600">Aguinaldo ya pagado (días)</label>
              <input type="number" min="0" step="0.01" name="aguinaldo_days_paid"
                     value="{{ old('aguinaldo_days_paid',0) }}"
                     class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
              <p class="text-[11px] text-gray-500">Se descuenta SD×días (asumiendo “días de aguinaldo”).</p>
            </div>
          </div>
        </div>

        {{-- Otros conceptos (ambos) --}}
        <div>
          <label class="block text-sm font-medium">Otros conceptos a sumar</label>
          <div class="mt-2 grid grid-cols-2 gap-3">
            <div>
              <label class="text-xs text-gray-600">Sueldos pendientes ($)</label>
              <input type="number" min="0" step="0.01" name="pending_wages" value="{{ old('pending_wages',0) }}"
                     class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
              <label class="text-xs text-gray-600">Otras prestaciones ($)</label>
              <input type="number" min="0" step="0.01" name="other_benefits" value="{{ old('other_benefits',0) }}"
                     class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
            </div>
          </div>
        </div>

        {{-- Neto (opcional, ambos) --}}
        <div>
          <label class="block text-sm font-medium">Estimación neta (ISR)</label>
          <div class="mt-2 space-y-2">
            <label class="flex items-center gap-2 text-sm">
              <input type="checkbox" name="estimate_isr" value="1" {{ old('estimate_isr')?'checked':'' }}>
              Calcular neto estimado (tasa promedio)
            </label>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="text-xs text-gray-600">Tasa ISR aprox. (%)</label>
                <input type="number" min="0" max="35" step="0.01" name="isr_rate" value="{{ old('isr_rate',0) }}"
                       class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
              </div>
              <div>
                <label class="text-xs text-gray-600">Exento aguinaldo (días)</label>
                <input type="number" min="0" step="0.01" name="aguinaldo_exempt_days" value="{{ old('aguinaldo_exempt_days',30) }}"
                       class="mt-1 w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500">
              </div>
            </div>
            <p class="text-[11px] text-gray-500">
              Simplificado: aplica tasa sobre monto gravable aproximado; puede diferir del CFDI real.
            </p>
          </div>
        </div>

      </div>

      <div class="mt-6 flex items-center justify-between gap-3">
        <p class="text-xs text-gray-500">
          * Verás el <strong>desglose</strong>, <strong>supuestos aplicados</strong> y <strong>fundamento legal</strong> en el resultado.
        </p>
        <button aria-label="Calcular" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-medium shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
          Calcular
        </button>
      </div>
    </section>

    {{-- Sidebar --}}
    <aside class="space-y-6">
      <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-base font-semibold mb-3">Guía rápida</h3>
        <ul class="text-sm text-gray-700 space-y-2 leading-6">
          <li>• <strong>Indemnización</strong>: despido injustificado o negativa de reinstalación.</li>
          <li>• <strong>Finiquito</strong>: renuncia, mutuo acuerdo o término de contrato.</li>
          <li>• <strong>SD</strong> = salario por día. <strong>SDI</strong> = SD + prestaciones.</li>
        </ul>
      </div>

      {{-- Card del test en sidebar --}}
      <div class="rounded-2xl border border-violet-200 bg-violet-50 p-6 shadow-sm">
        <h3 class="text-base font-semibold mb-1">¿Indemnización o finiquito?</h3>
        <p class="text-sm text-violet-900">
          Responde 6 preguntas y te guiamos. Resultado orientativo y sin registro.
        </p>
        <a href="{{ route('test-caso-laboral') }}"
           class="mt-3 inline-flex items-center rounded-xl bg-violet-600 px-4 py-2 text-white shadow hover:bg-violet-700">
          Hacer el test rápido
        </a>
      </div>

      @includeIf('partials.ads.responsive', ['slot' => '1234567890'])
    </aside>
  </form>

  {{-- Cómo calculamos --}}
  <section id="como-calculamos" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold mb-3">¿Cómo calculamos?</h3>
    <p class="text-sm text-gray-700 leading-7">
      Indemnización: 3 meses de SDI + 20 días/año (si procede) + vacaciones y prima 25% + aguinaldo + prima de antigüedad (tope 2× SM).<br>
      Finiquito: proporcionales (vacaciones y prima 25%, aguinaldo) y, si ≥ 15 años, prima de antigüedad.
    </p>
  </section>

  {{-- Fuentes --}}
  <section id="fuentes" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold mb-3">Fuentes y fundamento legal</h3>
    <ul class="list-disc pl-6 text-sm text-gray-700 space-y-2 leading-7">
      <li>LFT: arts. 48–50 (indemnización/20 días), 76–78 y 80 (vacaciones y prima), 87 (aguinaldo), 162 (prima de antigüedad).</li>
      <li>CONASAMI: salarios mínimos vigentes (tope 2× SM para prima de antigüedad).</li>
    </ul>
  </section>

  {{-- FAQ --}}
  <section id="faq" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold mb-4">Preguntas frecuentes</h3>
    <div class="space-y-4">
      <details class="group">
        <summary class="cursor-pointer font-medium">¿Con qué base legal se calcula?</summary>
        <div class="mt-2 text-sm text-gray-700">Indemnización: arts. 48–50 LFT. Vacaciones y prima: 76 y 80. Aguinaldo: 87. Prima de antigüedad: 162.</div>
      </details>
      <details class="group">
        <summary class="cursor-pointer font-medium">¿Qué diferencia hay entre SD y SDI?</summary>
        <div class="mt-2 text-sm text-gray-700">El SDI integra prestaciones y suele usarse para 3 meses y 20 días/año.</div>
      </details>
    </div>
  </section>
</div>

@push('head')
  {{-- (Mantén tus JSON-LD previos si los usas) --}}
@endpush

@push('scripts')
<script>
(function() {
  const radioIndem = document.getElementById('calc_type_indem');
  const radioLiq   = document.getElementById('calc_type_liq');

  const blocksByType = {
    indemnizacion: Array.from(document.querySelectorAll('[data-show-for="indemnizacion"]')),
    liquidacion:   Array.from(document.querySelectorAll('[data-show-for="liquidacion"]')),
  };

  function setDisabled(block, disabled) {
    const fields = block.querySelectorAll('input, select, textarea, button');
    fields.forEach(el => {
      if (disabled) {
        el.setAttribute('data-prev-disabled', el.disabled ? '1' : '0');
        el.disabled = true;
      } else {
        const prev = el.getAttribute('data-prev_disabled');
        if (prev === '0' || prev === null) el.disabled = false;
        el.removeAttribute('data-prev-disabled');
      }
    });
  }

  function toggleByType(type) {
    Object.keys(blocksByType).forEach(key => {
      const show = (key === type);
      blocksByType[key].forEach(block => {
        if (show) {
          block.classList.remove('hidden');
          setDisabled(block, false);
        } else {
          block.classList.add('hidden');
          setDisabled(block, true);
        }
      });
    });

    // En FINIQUITO, limpiar campos exclusivos de indemnización
    if (type === 'liquidacion') {
      document.querySelectorAll('[data-show-for="indemnizacion"] input, [data-show-for="indemnizacion"] select').forEach(el => {
        if (el.type === 'checkbox') el.checked = false;
        else el.value = '';
      });
    }
  }

  function currentType() {
    if (radioIndem && radioIndem.checked) return 'indemnizacion';
    if (radioLiq && radioLiq.checked) return 'liquidacion';
    return '{{ old('calc_type','indemnizacion') }}';
  }

  document.addEventListener('DOMContentLoaded', () => toggleByType(currentType()));
  [radioIndem, radioLiq].forEach(r => r && r.addEventListener('change', () => toggleByType(r.value)));
})();
</script>
@endpush
{{-- JSON-LD: FAQ cortas para Inicio --}}
@include('partials.seo.faq', ['faqs' => [
  ['q'=>'¿Con qué base legal se calcula?',
   'a'=>'Indemnización: arts. 48–50 LFT (3 meses y, cuando procede, 20 días/año). Vacaciones y prima: 76 y 80. Aguinaldo: 87. Prima de antigüedad: 162.'],
  ['q'=>'¿Cuándo usar Indemnización y cuándo Finiquito?',
   'a'=>'Indemnización: despido injustificado o negativa de reinstalación. Finiquito/Liquidación: renuncia, mutuo acuerdo o término de contrato sin despido.'],
  ['q'=>'¿El resultado es definitivo?',
   'a'=>'No. Es orientativo y puede diferir de un cálculo fiscal/contable o de un laudo.'],
  ['q'=>'¿Puedo estimar el neto?',
   'a'=>'Sí, la calculadora permite estimar ISR de forma simplificada para aproximar un neto.']
]])


@endsection
