<!doctype html>
<html lang="es-MX" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @php
    $defaultTitle = 'Calculadora de Indemnización y Liquidación LFT México';
    $metaTitle = trim($__env->yieldContent('title')) ?: $defaultTitle;
    $metaDesc  = trim($__env->yieldContent('meta_description')) ?: 'Calculadora gratuita para estimar indemnización o liquidación conforme a la LFT en México. Usa SD/SDI, antigüedad y fechas para un desglose claro.';
    $owner = env('APP_OWNER_NAME', 'Profesional independiente');
    $brand = config('app.name', 'Calculadora LFT');
  @endphp

  <title>{{ $metaTitle }}</title>
  <meta name="description" content="{{ $metaDesc }}">
  <meta name="robots" content="{{ app()->environment('production') ? 'index,follow' : 'noindex,nofollow' }}">
  <link rel="canonical" href="{{ url()->current() }}">

  {{-- Open Graph / Twitter --}}
  <meta property="og:locale" content="es_MX">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="{{ $brand }}">
  <meta property="og:title" content="{{ $metaTitle }}">
  <meta property="og:description" content="{{ $metaDesc }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $metaTitle }}">
  <meta name="twitter:description" content="{{ $metaDesc }}">

  {{-- CSS (Tailwind / Vite) --}}
  @vite('resources/css/app.css')

  {{-- AdSense (solo producción) --}}
  @if(app()->environment('production') && env('ADSENSE_CLIENT'))
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8539568158101746"
     crossorigin="anonymous"></script>
  @endif

  {{-- JSON-LD: WebApplication + Person (generado con json_encode para no romper Blade) --}}
  @php
    $webappLd = [
      '@context' => 'https://schema.org',
      '@type' => 'WebApplication',
      'name' => $brand,
      'applicationCategory' => 'BusinessApplication',
      'operatingSystem' => 'Web',
      'url' => url('/'),
      'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'MXN'],
      'author' => ['@type' => 'Person', 'name' => $owner],
    ];
  @endphp
  <script type="application/ld+json">
  {!! json_encode($webappLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
  </script>

  {{-- Stack para inyecciones desde vistas hijas (ej. FAQPage) --}}
  @stack('head')
</head>
<body class="min-h-screen bg-gray-50 text-gray-800 antialiased">
  {{-- H1 accesible (el hero de cada vista usa H2) --}}
  <header class="sr-only">
    <h1>{{ $metaTitle }}</h1>
  </header>

  <main id="contenido" class="max-w-4xl mx-auto p-4">
    @yield('content')
  </main>

  <footer class="max-w-4xl mx-auto px-4 pb-8 text-sm text-gray-500">
    <nav class="flex flex-wrap gap-4">
      <a class="hover:underline" href="#que-es-indemnizacion">¿Qué es indemnización?</a>
      <a class="hover:underline" href="#que-es-liquidacion">¿Qué es liquidación?</a>
      <a class="hover:underline" href="#faq">Preguntas frecuentes</a>
      <a class="hover:underline" href="{{ url('/aviso-privacidad') }}">Aviso de privacidad</a>
    </nav>
    <p class="mt-2">© {{ date('Y') }} {{ $owner }}. Herramienta informativa; no constituye asesoría legal.</p>
  </footer>

  @vite('resources/js/app.js')
  @stack('scripts')
</body>
</html>
