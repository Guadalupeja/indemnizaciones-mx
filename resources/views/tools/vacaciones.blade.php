@extends('layouts.app')
@section('title','Calculadora de vacaciones y prima 25%')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
  <h1 class="text-2xl font-semibold">Calculadora de vacaciones y prima 25%</h1>
  <p class="text-sm text-gray-700">Introduce SD y tus días de vacaciones del año.</p>

  <form class="space-y-4" oninput="
    const sd = parseFloat(sdV.value||0);
    const dias = parseFloat(diasVac.value||0);
    const paga = sd * dias;
    const prima = paga * 0.25;
    outVac.textContent = paga.toFixed(2);
    outPri.textContent = prima.toFixed(2);
    outTot.textContent = (paga+prima).toFixed(2);
  ">
    <div>
      <label class="block text-sm font-medium">Salario diario (SD)</label>
      <input id="sdV" type="number" step="0.01" class="mt-1 w-full rounded-xl border-gray-300">
    </div>
    <div>
      <label class="block text-sm font-medium">Días de vacaciones</label>
      <input id="diasVac" type="number" step="0.5" class="mt-1 w-full rounded-xl border-gray-300">
    </div>

    <div class="rounded-xl bg-gray-50 p-4 space-y-1">
      <p>Pago vacaciones: <strong>$<span id="outVac">0.00</span></strong></p>
      <p>Prima 25%: <strong>$<span id="outPri">0.00</span></strong></p>
      <p>Total: <strong>$<span id="outTot">0.00</span></strong></p>
    </div>

    <a href="{{ route('inicio') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white">Ir a la calculadora principal</a>
  </form>
</div>
@endsection
