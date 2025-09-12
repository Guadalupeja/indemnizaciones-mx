@extends('layouts.app')

@section('title', 'Resultado')

@section('content')
  <h1 class="text-2xl font-semibold mb-4">Resultado</h1>

  <pre class="bg-gray-100 p-4 rounded">{{ print_r($result, true) }}</pre>

  <a href="{{ route('inicio') }}" class="inline-block mt-4 text-blue-600 underline">Volver</a>
@endsection
