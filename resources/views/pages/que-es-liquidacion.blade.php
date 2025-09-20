@extends('layouts.app')

@section('title', '¿Qué es la liquidación / finiquito? (LFT México)')
@section('meta_description', 'Diferencia entre liquidación y finiquito: sueldos pendientes, vacaciones, prima vacacional 25% y aguinaldo proporcional, con base legal de la LFT.')

@section('content')
<section class="prose prose-blue max-w-none">
  <h2>¿Qué es la liquidación / finiquito?</h2>
  <p>Se usa cuando hay <strong>renuncia</strong>, <strong>mutuo acuerdo</strong>, término de contrato u otros supuestos sin despido injustificado.</p>
  <ul>
    <li>Sueldos pendientes</li>
    <li>Vacaciones y <strong>prima vacacional 25%</strong></li>
    <li><strong>Aguinaldo proporcional</strong></li>
  </ul>
  <p>Fundamento legal: artículos 76, 80 y 87 de la LFT.</p>
  <p class="mt-6"><a href="{{ route('inicio') }}" class="text-blue-600 underline">Volver a la calculadora</a></p>
</section>
@endsection
