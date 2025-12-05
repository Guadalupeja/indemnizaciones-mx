@extends('layouts.app')
@section('title','Contacto')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
  <h1 class="text-2xl font-semibold">Contacto</h1>

  @if(session('ok'))
    <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
      {{ session('ok') }}
    </div>
  @endif

  <form method="POST" action="{{ route('contacto') }}" class="space-y-4" autocomplete="off" novalidate>
    @csrf

    {{-- Honeypot (oculto para humanos) --}}
    <div style="display:none;">
      <label>Tu sitio web</label>
      <input type="text" name="website" tabindex="-1" autocomplete="off">
    </div>

    <div>
      <label class="block text-sm font-medium">Nombre</label>
      <input name="nombre" value="{{ old('nombre') }}" required class="mt-1 w-full rounded-xl border-gray-300">
      @error('nombre')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
      <label class="block text-sm font-medium">Correo</label>
      <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-xl border-gray-300">
      @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
      <label class="block text-sm font-medium">Mensaje</label>
      <textarea name="mensaje" rows="6" required class="mt-1 w-full rounded-xl border-gray-300">{{ old('mensaje') }}</textarea>
      @error('mensaje')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
    <label class="inline-flex items-center gap-2 text-sm">
      <input type="checkbox" name="politica" value="1" {{ old('politica')?'checked':'' }}>
      Acepto la <a class="underline" href="{{ route('aviso-privacidad') }}">política de privacidad</a>.
    </label>
    @error('politica')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror

    <button class="px-5 py-2.5 rounded-xl bg-blue-600 text-white">Enviar</button>
  </form>

  <div class="text-sm text-gray-600">
    También puedes escribir a: 
    <a class="underline" href="mailto:contacto@calculadoraindemnizacion.com">contacto@calculadoraindemnizacion.com</a>
  </div>
</div>
@endsection
