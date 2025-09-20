@extends('layouts.app')

@section('title', '¿Qué es la indemnización por despido injustificado? (LFT México)')
@section('meta_description', 'Explicación clara de la indemnización por despido injustificado según la LFT en México: 3 meses de SDI, 20 días por año, proporcionales y fundamentos legales.')

@section('content')
<section class="prose prose-blue max-w-none">
  <h2>¿Qué es la indemnización por despido injustificado?</h2>
  <p>La indemnización aplica cuando existe <strong>despido injustificado</strong>, negativa de reinstalación o <strong>rescisión imputable al patrón</strong>.</p>
  <ul>
    <li><strong>3 meses</strong> de Salario Diario Integrado (SDI)</li>
    <li><strong>20 días por año</strong> de servicios, cuando corresponde</li>
    <li>Proporcionales: vacaciones, <strong>prima vacacional 25%</strong> y <strong>aguinaldo proporcional</strong></li>
  </ul>
  <p>Fundamento legal: artículos 48 a 50 de la LFT.</p>
  <p class="mt-6"><a href="{{ route('inicio') }}" class="text-blue-600 underline">Volver a la calculadora</a></p>
</section>
@endsection
