@extends('layouts.app')
@section('title','Blog laboral')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
  <h1 class="text-2xl font-semibold">Blog</h1>
  <p class="text-gray-700">Próximamente artículos prácticos: SD vs SDI, aguinaldo, vacaciones, 20 días/año…</p>
  <ul class="list-disc pl-6 text-gray-700">
    <li><a class="underline" href="{{ route('calc.aguinaldo') }}">Calculadora de aguinaldo proporcional</a></li>
    <li><a class="underline" href="{{ route('calc.vacaciones') }}">Calculadora de vacaciones + prima</a></li>
  </ul>
</div>
@endsection
