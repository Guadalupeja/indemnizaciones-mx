@extends('layouts.app')
@section('title', 'Resultado del cálculo')

@section('content')
@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;

    // Totales/partidas
    $threeMonths     = (float)($result['three_months']      ?? 0);
    $twentyPerYear   = (float)($result['twenty_per_year']   ?? 0);
    $vacPay          = (float)($result['vacation_pay']      ?? 0);
    $vacPremium      = (float)($result['vacation_premium']  ?? 0);
    $aguinaldo       = (float)($result['aguinaldo']         ?? 0);
    $seniority       = (float)($result['seniority_premium'] ?? 0);
    $pendingWages    = (float)($result['pending_wages']     ?? 0);
    $otherBenefits   = (float)($result['other_benefits']    ?? 0);
    $total           = (float)($result['total']             ?? 0);
    $net             = $result['net']        ?? null;
    $netNotes        = $result['net_notes']  ?? null;

    // Datos contexto
    $start       = Carbon::parse($employee->start_date ?? now());
    $end         = Carbon::parse($employee->end_date   ?? now());
    $years       = max(1, $start->diffInYears($end));
    $daysThisYr  = $end->copy()->startOfYear()->diffInDays($end) + 1;
    $sdiUsed     = (float)($employee->daily_integrated_salary ?: $employee->daily_salary);
    $zoneLabel   = ($employee->zone ?? 'general') === 'frontera' ? 'Frontera Norte' : 'General';

    $calcType  = $type ?? ($result['type'] ?? 'indemnizacion');
    $isIndem   = $calcType === 'indemnizacion';
    $typeLabel = $isIndem ? 'Indemnización (despido injustificado)' : 'Liquidación / Finiquito';

    // Etiquetas en español para "supuestos aplicados"
    $assumptionLabels = [
        'twenty_mode'            => '20 días por año (modo)',
        'contract_type'          => 'Tipo de contrato',
        'reinstalacion_valida'   => 'Hubo reinstalación válida',
        'seniority_in_despido'   => 'Prima de antigüedad aun con < 15 años (despido)',
        'seniority_proportional' => 'Prima de antigüedad proporcional por fracción',
        'vac_days_taken'         => 'Vacaciones ya gozadas (días)',
        'aguinaldo_days_paid'    => 'Aguinaldo ya pagado (días)',
        'pending_wages'          => 'Sueldos pendientes ($)',
        'other_benefits'         => 'Otras prestaciones ($)',
        'estimate_isr'           => 'Calcular neto estimado (ISR)',
        'isr_rate'               => 'Tasa ISR aproximada (%)',
        'aguinaldo_exempt_days'  => 'Aguinaldo exento (días)',
        'years_fractional'       => 'Años (fracción considerada)',
        'zone'                   => 'Zona salarial',
        'sdi_used'               => 'SDI utilizado',
    ];

    // Función auxiliar para mostrar etiquetas en español
    $labelOf = function(string $key) use ($assumptionLabels) {
        return $assumptionLabels[$key] ?? ('Parámetro: '.$key);
    };

    $pluralAnios = $years === 1 ? '1 año' : $years.' años';
@endphp

<section class="rounded-3xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white shadow mb-6">
  <div class="flex items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl font-semibold">Resultado del cálculo</h1>
      <p class="text-blue-50 mt-1">
        Trabajador: <span class="font-medium">{{ $employee->name }}</span>
      </p>
    </div>
    <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-sm">
      {{ $typeLabel }}
    </span>
  </div>
  <p class="mt-3 text-blue-100">
    {{ $isIndem
       ? 'Incluye 3 meses de SDI y, según supuestos, 20 días por año; la prima de antigüedad puede pagarse aun con menos de 15 años si así se configuró.'
       : 'Incluye proporcionales (vacaciones + prima 25%, aguinaldo) y prima de antigüedad solo si la antigüedad es de 15 años o más.' }}
  </p>
</section>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  {{-- Resumen --}}
  <div class="lg:col-span-1 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <p class="text-sm text-gray-500">Total estimado</p>
    <p class="mt-1 text-3xl font-semibold tracking-tight">${{ number_format($total, 2) }}</p>

    @if(!is_null($net))
      <p class="mt-3 text-sm text-gray-700"><span class="font-medium">Neto estimado:</span> ${{ number_format($net, 2) }}</p>
      @if($netNotes)
        <p class="mt-1 text-xs text-gray-500">{{ $netNotes }}</p>
      @endif
    @endif

    <div class="mt-4 rounded-xl bg-gray-50 p-4 text-sm text-gray-700">
      <p><span class="font-medium">SDI utilizado:</span> ${{ number_format($sdiUsed, 2) }} por día</p>
      <p><span class="font-medium">Antigüedad:</span> {{ $pluralAnios }}</p>
      <p><span class="font-medium">Días transcurridos del año:</span> {{ $daysThisYr }}</p>
      <p><span class="font-medium">Zona salarial:</span> {{ $zoneLabel }}</p>
    </div>
  </div>

  {{-- Detalle --}}
  <div class="lg:col-span-2 space-y-4">
    @if($isIndem)
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold">3 meses de salario (SDI × 90)</h3>
          <div class="text-xl font-semibold">${{ number_format($threeMonths, 2) }}</div>
        </div>
        <p class="mt-2 text-sm text-gray-600">Con SDI = ${{ number_format($sdiUsed,2) }} ⇒ {{ number_format($sdiUsed,2) }} × 90.</p>
        <p class="mt-1 text-xs text-gray-500">Fundamento: artículos 48 a 50 de la LFT.</p>
      </div>

      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold">20 días por año (SDI × 20 × años)</h3>
          <div class="text-xl font-semibold">${{ number_format($twentyPerYear, 2) }}</div>
        </div>
        <p class="mt-2 text-sm text-gray-600">
          Con {{ $result['years_fractional'] ?? $years }} año(s): {{ number_format($sdiUsed,2) }} × 20 × {{ $result['years_fractional'] ?? $years }}.
        </p>
        <p class="mt-1 text-xs text-gray-500">Fundamento: artículos 48 a 50 de la LFT.</p>
      </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold">Vacaciones + prima del 25%</h3>
        <div class="text-right">
          <div class="text-xl font-semibold">${{ number_format($vacPay + $vacPremium, 2) }}</div>
          <div class="text-xs text-gray-500">(${{ number_format($vacPay,2) }} + ${{ number_format($vacPremium,2) }})</div>
        </div>
      </div>
      <p class="mt-2 text-sm text-gray-600">Proporcional del año en curso, base salario diario. Fundamento: artículos 76 y 80 de la LFT.</p>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold">Aguinaldo proporcional</h3>
        <div class="text-xl font-semibold">${{ number_format($aguinaldo, 2) }}</div>
      </div>
      <p class="mt-2 text-sm text-gray-600">Fórmula: SD × (15/365) × días trabajados del año.</p>
      <p class="mt-1 text-xs text-gray-500">Fundamento: artículo 87 de la LFT.</p>
    </div>

    @if($seniority > 0)
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold">Prima de antigüedad</h3>
          <div class="text-xl font-semibold">${{ number_format($seniority, 2) }}</div>
        </div>
        <p class="mt-2 text-sm text-gray-600">
          12 días por año con tope del salario a 2× salario mínimo de la zona.
        </p>
        <p class="mt-1 text-xs text-gray-500">Fundamento: artículo 162 de la LFT.</p>
      </div>
    @endif

    @if($pendingWages > 0 || $otherBenefits > 0)
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <h3 class="font-semibold mb-2">Otros conceptos</h3>
        @if($pendingWages>0)
          <p class="text-sm text-gray-700">Sueldos pendientes: ${{ number_format($pendingWages,2) }}</p>
        @endif
        @if($otherBenefits>0)
          <p class="text-sm text-gray-700">Otras prestaciones: ${{ number_format($otherBenefits,2) }}</p>
        @endif
      </div>
    @endif

    {{-- Supuestos aplicados --}}
    @if(!empty($result['assumptions']))
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <h3 class="font-semibold mb-3">Supuestos aplicados</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
          @foreach($result['assumptions'] as $k => $v)
            <div>
              <span class="text-gray-500">{{ $labelOf($k) }}:</span>
              @if(is_bool($v))
                {{ $v ? 'Sí' : 'No' }}
              @elseif(is_numeric($v))
                {{ number_format((float)$v, 2) }}
              @else
                {{ (string)$v }}
              @endif
            </div>
          @endforeach
        </div>
        <p class="text-xs text-gray-500 mt-3">
          Nota: los supuestos impactan los 20 días por año, proporcionalidades y ajustes por pagos previos.
        </p>
      </div>
    @endif
  </div>
</div>

{{-- Acciones --}}
<div class="mt-8 flex flex-wrap items-center gap-3">
  <a href="{{ route('inicio') }}"
     class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">
    Nuevo cálculo
  </a>
  <a href="{{ url()->previous() }}"
     class="inline-flex items-center rounded-xl border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50">
    Regresar
  </a>
</div>
@endsection
