@extends('layouts.app')
@section('title', 'Resultado del test: indemnización o finiquito')
@section('content')
<section class="max-w-3xl mx-auto space-y-6">
  <div class="rounded-3xl bg-gradient-to-r from-indigo-600 to-violet-600 p-6 text-white shadow">
    <h1 class="text-2xl font-semibold">Resultado del test</h1>
    <p class="mt-1 text-indigo-50">
      Sugerencia orientativa:
      <strong>{{ $result_type === 'indemnizacion' ? 'Indemnización' : 'Finiquito / Liquidación' }}</strong>
    </p>
  </div>

  @if(!empty($why))
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
      <h2 class="text-lg font-semibold mb-3">¿Por qué este resultado?</h2>
      <ul class="list-disc pl-6 text-sm text-gray-700 space-y-1">
        @foreach($why as $w) <li>{{ $w }}</li> @endforeach
      </ul>
      @if(!empty($risk_flags))
        <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
          <div class="font-medium mb-1">Señales relevantes:</div>
          <ul class="list-disc pl-5">
            @foreach($risk_flags as $f) <li>{{ $f }}</li> @endforeach
          </ul>
        </div>
      @endif
    </div>
  @endif

  <div class="flex flex-wrap gap-3">
    <a href="{{ $cta['url'] }}"
       class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-white shadow hover:bg-indigo-700">
      {{ $cta['label'] }}
    </a>
    <a href="{{ route('test-caso-laboral') }}"
       class="inline-flex items-center rounded-xl border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50">
      Hacer el test de nuevo
    </a>
  </div>

  <details class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <summary class="cursor-pointer font-medium">Ver mis respuestas</summary>
    <pre class="mt-3 text-xs text-gray-700 bg-gray-50 p-3 rounded">{{ json_encode($answers, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
  </details>

  <nav class="text-sm text-gray-500 flex flex-wrap gap-4">
    <a class="hover:underline" href="{{ route('que-es-indemnizacion') }}">¿Qué es indemnización?</a>
    <a class="hover:underline" href="{{ route('que-es-liquidacion') }}">¿Qué es liquidación?</a>
    <a class="hover:underline" href="{{ route('faq') }}">Preguntas frecuentes</a>
    <a class="hover:underline" href="{{ route('aviso-privacidad') }}">Aviso de privacidad</a>
  </nav>
</section>

@push('scripts')
<script>
// Evento para GA4/GTM
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
  event: 'quiz_result',
  quiz_result_type: '{{ $result_type }}'
});
</script>
@endpush
{{-- Breadcrumbs JSON-LD para Test --}}
@include('partials.seo.breadcrumbs', [
  'items' => [
    ['name'=>'Inicio','url'=>route('inicio')],
    ['name'=>'Test: ¿Indemnización o finiquito?','url'=>url()->current()]
  ]
])

{{-- HowTo JSON-LD para Test --}}
@include('partials.seo.howto')

@endsection
