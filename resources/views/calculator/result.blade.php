@extends('layouts.app')
@section('title', 'Resultado del cálculo')

@section('content')
@php
    use Carbon\Carbon;

    // 1) Lectura segura de resultados (snake_case) y totales
    $threeMonths     = $result['three_months']     ?? 0;
    $twentyPerYear   = $result['twenty_per_year']  ?? 0;
    $vacPay          = $result['vacation_pay']     ?? 0;
    $vacPremium      = $result['vacation_premium'] ?? 0;
    $aguinaldo       = $result['aguinaldo']        ?? 0;
    $vacationsTotal  = $vacPay + $vacPremium;
    $total           = $result['total']            ?? ($threeMonths + $twentyPerYear + $vacationsTotal + $aguinaldo);

    // 2) Contexto para explicar "por qué"
    $start = Carbon::parse($employee->start_date);
    $end   = Carbon::parse($employee->end_date);
    $years = max(1, $start->diffInYears($end));
    $daysThisYear = $end->copy()->startOfYear()->diffInDays($end) + 1;
    $sdiUsed = $employee->daily_integrated_salary ?? $employee->daily_salary;

    $isIndem = ($type ?? 'indemnizacion') === 'indemnizacion';
    $typeLabel = $isIndem
        ? 'Indemnización (despido injustificado)'
        : 'Liquidación / Finiquito';
    $typeHelp  = $isIndem
        ? 'Aplica si te despidieron sin causa, se negó la reinstalación o la rescisión es imputable al patrón.'
        : 'Aplica si renunciaste, hubo mutuo acuerdo o terminó el contrato sin despido injustificado.';
@endphp

{{-- Hero / encabezado --}}
<section class="rounded-3xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white shadow mb-6">
  <div class="flex items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl font-semibold">Resultado del cálculo</h1>
      <p class="text-blue-50 mt-1">Trabajador: <span class="font-medium">{{ $employee->name }}</span></p>
    </div>
    <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-sm">
      {{ $typeLabel }}
    </span>
  </div>
  <p class="mt-3 text-blue-100">{{ $typeHelp }}</p>
</section>

{{-- Resumen principal --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  {{-- Tarjeta total --}}
  <div class="lg:col-span-1 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <p class="text-sm text-gray-500">Total estimado</p>
    <p class="mt-1 text-3xl font-semibold tracking-tight">$
      {{ number_format($total, 2) }}</p>
    <p class="mt-2 text-xs text-gray-500">Cálculo orientativo conforme a LFT. Puede variar por contrato/convenciones.</p>

    <div class="mt-4 rounded-xl bg-gray-50 p-4 text-sm text-gray-700">
      <p><span class="font-medium">SDI usado:</span> ${{ number_format($sdiUsed, 2) }} por día</p>
      <p><span class="font-medium">Antigüedad:</span> {{ $years }} año(s)</p>
      <p><span class="font-medium">Días del año transcurridos:</span> {{ $daysThisYear }}</p>
      <p><span class="font-medium">Zona:</span> {{ $employee->zone === 'frontera' ? 'Frontera Norte' : 'General' }}</p>
    </div>
  </div>

  {{-- Detalle por conceptos (cards) --}}
  <div class="lg:col-span-2 space-y-4">
    {{-- 3 meses --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold">3 meses de salario</h3>
        <div class="text-xl font-semibold">${{ number_format($threeMonths, 2) }}</div>
      </div>
      <p class="mt-2 text-sm text-gray-600">
        Fórmula: <span class="font-medium">SDI × 90 días</span>.
        Con SDI = ${{ number_format($sdiUsed,2) }} ⇒ {{ number_format($sdiUsed,2) }} × 90.
      </p>
      <p class="mt-1 text-xs text-gray-500">Fundamento: arts. 48–50 LFT (indemnización constitucional).</p>
    </div>

    {{-- 20 días por año --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold">20 días por año</h3>
        <div class="text-xl font-semibold">${{ number_format($twentyPerYear, 2) }}</div>
      </div>
      <p class="mt-2 text-sm text-gray-600">
        Fórmula: <span class="font-medium">SDI × 20 × años de servicio</span>.
        Con {{ $years }} año(s): {{ number_format($sdiUsed,2) }} × 20 × {{ $years }}.
      </p>
      <p class="mt-1 text-xs text-gray-500">Fundamento: arts. 48–50 LFT (cuando aplica indemnización).</p>
    </div>

    {{-- Vacaciones + prima --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold">Vacaciones + prima</h3>
        <div class="text-right">
          <div class="text-xl font-semibold">${{ number_format($vacationsTotal, 2) }}</div>
          <div class="text-xs text-gray-500">(${{ number_format($vacPay,2) }} vacaciones + ${{ number_format($vacPremium,2) }} prima)</div>
        </div>
      </div>
      <p class="mt-2 text-sm text-gray-600">
        Vacaciones proporcionales según antigüedad (reforma 2023) y
        <span class="font-medium">prima 25%</span>.
      </p>
      <p class="mt-1 text-xs text-gray-500">Fundamento: arts. 76 y 80 LFT.</p>
    </div>

    {{-- Aguinaldo --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold">Aguinaldo proporcional</h3>
        <div class="text-xl font-semibold">${{ number_format($aguinaldo, 2) }}</div>
      </div>
      <p class="mt-2 text-sm text-gray-600">
        Fórmula: <span class="font-medium">SDI × 15 días / 365 × días trabajados del año</span>.
        Aquí: {{ number_format($sdiUsed,2) }} × 15/365 × {{ $daysThisYear }}.
      </p>
      <p class="mt-1 text-xs text-gray-500">Fundamento: art. 87 LFT.</p>
    </div>
  </div>
</div>

{{-- Publicidad --}}
<x-ads.banner size="300x250" slot-id="1234567890" class="mt-8" />

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
