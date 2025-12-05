@extends('layouts.app')
@section('title','Calculadora de aguinaldo proporcional')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
  <h1 class="text-2xl font-semibold">Calculadora de aguinaldo proporcional</h1>
  <form class="space-y-4" oninput="
    const sd = parseFloat(sdAg.value||0);
    const dias = parseFloat(diasTrab.value||0);
    const agu = sd * (15/365) * dias;
    outAgu.textContent = agu.toFixed(2);
  ">
    <div>
      <label class="block text-sm font-medium">Salario diario (SD)</label>
      <input id="sdAg" type="number" step="0.01" class="mt-1 w-full rounded-xl border-gray-300">
    </div>
    <div>
      <label class="block text-sm font-medium">Días trabajados del año</label>
      <input id="diasTrab" type="number" step="1" class="mt-1 w-full rounded-xl border-gray-300">
    </div>
    <div class="rounded-xl bg-gray-50 p-4">
      Aguinaldo proporcional: <strong>$<span id="outAgu">0.00</span></strong>
    </div>

    <a href="{{ route('inicio') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white">Ir a la calculadora principal</a>
  </form>
</div>
@endsection
