@extends('layouts.app')

@section('title', 'Preguntas frecuentes – Indemnización y liquidación (LFT México)')
@section('meta_description', 'FAQ con dudas comunes sobre indemnización por despido, liquidación/finiquito y bases legales conforme a la LFT en México.')

@section('content')
<section class="prose prose-blue max-w-none">
  <h2>Preguntas frecuentes</h2>

  <details open class="mt-4">
    <summary><strong>¿Con qué base legal se calcula?</strong></summary>
    <p>Indemnización: arts. 48–50 LFT. Vacaciones y prima: 76 y 80. Aguinaldo: 87.</p>
  </details>

  <details class="mt-3">
    <summary><strong>¿Qué diferencia hay entre SD y SDI?</strong></summary>
    <p>El SDI integra prestaciones y suele usarse como base indemnizatoria. Si no lo conoces, usamos SD.</p>
  </details>

  <details class="mt-3">
    <summary><strong>¿El resultado es definitivo?</strong></summary>
    <p>No. Es una estimación orientativa que puede variar por contrato, convenios o juicio.</p>
  </details>

  <p class="mt-6"><a href="{{ route('inicio') }}" class="text-blue-600 underline">Volver a la calculadora</a></p>
</section>
@endsection
