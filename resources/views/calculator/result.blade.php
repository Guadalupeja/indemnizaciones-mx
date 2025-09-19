@extends('layouts.app')
@section('title', 'Resultado del cálculo')

@section('content')
@php
    use Carbon\Carbon;

    // --- Lecturas seguras del resultado ---
    $threeMonths     = (float)($result['three_months']      ?? 0);
    $twentyPerYear   = (float)($result['twenty_per_year']   ?? 0);
    $vacPay          = (float)($result['vacation_pay']      ?? 0);
    $vacPremium      = (float)($result['vacation_premium']  ?? 0);
    $aguinaldo       = (float)($result['aguinaldo']         ?? 0);
    $seniority       = (float)($result['seniority_premium'] ?? 0);
    $total           = (float)($result['total']             ?? ($threeMonths + $twentyPerYear + $vacPay + $vacPremium + $aguinaldo + $seniority));

    // --- Contexto para etiquetas y explicaciones ---
    $start       = Carbon::parse($employee->start_date ?? now());
    $end         = Carbon::parse($employee->end_date   ?? now());
    $years       = max(1, $start->diffInYears($end));
    $daysThisYr  = $end->copy()->startOfYear()->diffInDays($end) + 1;
    $sdiUsed     = (float)($employee->daily_integrated_salary ?: $employee->daily_salary);
    $zoneLabel   = ($employee->zone ?? 'general') === 'frontera' ? 'Frontera Norte' : 'General';

    // Tipo (por si no llega)
    $calcType  = $type ?? ($result['type'] ?? 'indemnizacion');
    $isIndem   = $calcType === 'indemnizacion';
    $typeLabel = $isIndem ? 'Indemnización (despido injustificado)' : 'Liquidación / Finiquito';
@endphp

{{-- Hero --}}
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
       ? 'Aplica si te despidieron sin causa, se negó la reinstalación o la rescisión es imputable al patrón.'
       : 'Aplica si renunciaste, hubo mutuo acuerdo o terminó el contrato sin despido injustificado.' }}
  </p>
</section>

{{-- Resumen --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  {{-- Total --}}
  <div class="lg:col-span-1 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <p class="text-sm text-gray-500">Total estimado</p>
    <p class="mt-1 text-3xl font-semibold tracking-tight">${{ number_format($total, 2) }}</p>
    <p class="mt-2 text-xs text-gray-500">Estimación conforme a LFT (arts. 48–50, 76, 80, 87 y 162).</p>

    <div class="mt-4 rounded-xl bg-gray-50 p-4 text-sm text-gray-700">
      <p><span class="font-medium">SDI usado:</span> ${{ number_format($sdiUsed, 2) }} por día</p>
      <p><span class="font-medium">Antigüedad:</span> {{ $years }} año(s)</p>
      <p><span class="font-medium">Días del año transcurridos:</span> {{ $daysThisYr }}</p>
      <p><span class="font-medium">Zona:</span> {{ $zoneLabel }}</p>
    </div>
  </div>

  {{-- Detalle --}}
  <div class="lg:col-span-2 space-y-4">
    @if($isIndem)
      {{-- 3 meses --}}
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold">3 meses de salario (SDI × 90)</h3>
          <div class="text-xl font-semibold">${{ number_format($threeMonths, 2) }}</div>
        </div>
        <p class="mt-2 text-sm text-gray-600">Con SDI = ${{ number_format($sdiUsed,2) }} ⇒ {{ number_format($sdiUsed,2) }} × 90.</p>
        <p class="mt-1 text-xs text-gray-500">Fundamento: arts. 48–50 LFT.</p>
      </div>

      {{-- 20 días por año --}}
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold">20 días por año (SDI × 20 × años)</h3>
          <div class="text-xl font-semibold">${{ number_format($twentyPerYear, 2) }}</div>
        </div>
        <p class="mt-2 text-sm text-gray-600">Con {{ $years }} año(s): {{ number_format($sdiUsed,2) }} × 20 × {{ $years }}.</p>
        <p class="mt-1 text-xs text-gray-500">Fundamento: arts. 48–50 LFT.</p>
      </div>
    @endif

    {{-- Vacaciones + prima --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold">Vacaciones + prima 25%</h3>
        <div class="text-right">
          <div class="text-xl font-semibold">${{ number_format($vacPay + $vacPremium, 2) }}</div>
          <div class="text-xs text-gray-500">(${{ number_format($vacPay,2) }} + ${{ number_format($vacPremium,2) }})</div>
        </div>
      </div>
      <p class="mt-2 text-sm text-gray-600">Proporcional del año en curso, base SD. Fundamento: arts. 76 y 80 LFT.</p>
    </div>

    {{-- Aguinaldo --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold">Aguinaldo proporcional</h3>
        <div class="text-xl font-semibold">${{ number_format($aguinaldo, 2) }}</div>
      </div>
      <p class="mt-2 text-sm text-gray-600">Fórmula: SD × 15/365 × días trabajados del año ({{ $daysThisYr }}).</p>
      <p class="mt-1 text-xs text-gray-500">Fundamento: art. 87 LFT.</p>
    </div>

    {{-- Prima de antigüedad, si aplica --}}
    @if($seniority > 0)
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <h3 class="font-semibold">Prima de antigüedad</h3>
          <div class="text-xl font-semibold">${{ number_format($seniority, 2) }}</div>
        </div>
        <p class="mt-2 text-sm text-gray-600">
          12 días por año con tope del salario a 2× salario mínimo de la zona. Fundamento: art. 162 LFT.
        </p>
      </div>
    @endif
  </div>
</div>

{{-- Publicidad (usa includeIf para no romper si el partial no existe) --}}
@includeIf('partials.ads.responsive', ['slot' => '1234567890'])

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
