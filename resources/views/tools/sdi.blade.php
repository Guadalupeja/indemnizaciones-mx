@extends('layouts.app')
@section('title','Calculadora de SDI (estimado)')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
  <h1 class="text-2xl font-semibold">Calculadora de SDI (estimado)</h1>
  <p class="text-gray-700">Ingresa tu salario y prestaciones aproximadas para estimar el SDI.</p>

  <form class="space-y-4" oninput="
    const sd = parseFloat(sdInput.value||0);
    const bono = parseFloat(bonoAnual.value||0);
    const v = parseFloat(valorPrestac.value||0);
    const sdi = sd + (bono/365) + (v/365);
    sdiOut.textContent = sdi.toFixed(2);
  ">
    <div>
      <label class="block text-sm font-medium">Salario diario (SD)</label>
      <input id="sdInput" type="number" step="0.01" class="mt-1 w-full rounded-xl border-gray-300">
    </div>
    <div>
      <label class="block text-sm font-medium">Bono anual (aprox.)</label>
      <input id="bonoAnual" type="number" step="0.01" class="mt-1 w-full rounded-xl border-gray-300">
    </div>
    <div>
      <label class="block text-sm font-medium">Valor anual de prestaciones (vales, comisiones, etc.)</label>
      <input id="valorPrestac" type="number" step="0.01" class="mt-1 w-full rounded-xl border-gray-300">
    </div>
    <div class="rounded-xl bg-gray-50 p-4">
      <p>SDI estimado: <strong>$<span id="sdiOut">0.00</span></strong> / día</p>
    </div>

    <a href="{{ route('inicio') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white">Calcular indemnización o finiquito</a>
  </form>
</div>
@endsection
