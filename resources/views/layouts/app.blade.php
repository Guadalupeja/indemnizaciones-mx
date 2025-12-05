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

  {{-- Google Tag Manager (head) - solo producción --}}
  @if(app()->environment('production') && env('GTM_ID'))
    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='{{ env('GTM_LAYER','dataLayer') }}'?'&l={{ env('GTM_LAYER','dataLayer') }}':'';
      j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
      f.parentNode.insertBefore(j,f);
    })(window,document,'script','{{ env('GTM_LAYER','dataLayer') }}','{{ env('GTM_ID') }}');
    </script>
  @endif

  {{-- CSS (Tailwind / Vite) --}}
  @vite('resources/css/app.css')

  {{-- AdSense (solo producción) --}}
  @if(app()->environment('production') && env('ADSENSE_CLIENT'))
    <script async
      src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ env('ADSENSE_CLIENT') }}"
      crossorigin="anonymous"></script>
  @endif

  {{-- JSON-LD: WebApplication + Person --}}
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

  {{-- JSON-LD global: Website/Organization --}}
@includeIf('partials.seo.website_org')


  {{-- Stack para inyecciones desde vistas hijas (ej. FAQPage) --}}
  @stack('head')

  @if(request()->cookie('cookies_ok'))
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ env('ADSENSE_CLIENT','') }}" crossorigin="anonymous"></script>
@endif

</head>
<body class="min-h-screen bg-gray-50 text-gray-800 antialiased">
  {{-- Google Tag Manager (noscript) - apenas abre <body> --}}
  @if(app()->environment('production') && env('GTM_ID'))
    <noscript>
      <iframe src="https://www.googletagmanager.com/ns.html?id={{ env('GTM_ID') }}"
              height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
  @endif

  {{-- H1 accesible (el hero de cada vista usa H2) --}}
  <header class="sr-only">
    <h1>{{ $metaTitle }}</h1>
  </header>

  <main id="contenido" class="max-w-4xl mx-auto p-4">
    @yield('content')
  </main>

  <footer class="mt-12 border-t">
  <div class="max-w-5xl mx-auto px-4 py-8 grid sm:grid-cols-2 lg:grid-cols-4 gap-6 text-sm">
    <div>
      <h3 class="font-semibold mb-2">Herramientas</h3>
      <ul class="space-y-1">
        <li><a class="underline" href="{{ route('inicio') }}">Calculadora</a></li>
        <li><a class="underline" href="{{ route('test-caso-laboral') }}">Test: ¿qué me corresponde?</a></li>
        <li><a class="underline" href="{{ route('calc.sdi') }}">Calculadora SDI</a></li>
        <li><a class="underline" href="{{ route('calc.aguinaldo') }}">Aguinaldo proporcional</a></li>
        <li><a class="underline" href="{{ route('calc.vacaciones') }}">Vacaciones + prima</a></li>
      </ul>
    </div>

    <div>
      <h3 class="font-semibold mb-2">Contenido</h3>
      <ul class="space-y-1">
        <li><a class="underline" href="{{ route('guias') }}">Guías</a></li>
        <li><a class="underline" href="{{ route('blog') }}">Blog</a></li>
        <li><a class="underline" href="{{ route('plantillas') }}">Plantillas</a></li>
        <li><a class="underline" href="{{ route('mapa-sitio') }}">Mapa del sitio</a></li>
      </ul>
    </div>

    <div>
      <h3 class="font-semibold mb-2">Acerca de</h3>
      <ul class="space-y-1">
        <li><a class="underline" href="{{ route('sobre') }}">Sobre</a></li>
        <li><a class="underline" href="{{ route('contacto') }}">Contacto</a></li>
      </ul>
    </div>

    <div>
      <h3 class="font-semibold mb-2">Legal</h3>
      <ul class="space-y-1">
        <li><a class="underline" href="{{ route('aviso-privacidad') }}">Aviso de privacidad</a></li>
        <li><a class="underline" href="{{ route('politica-cookies') }}">Política de cookies</a></li>
        <li><a class="underline" href="{{ route('terminos') }}">Términos y condiciones</a></li>
        <li><a class="underline" href="{{ route('sitemap.xml') }}">Sitemap XML</a></li>
      </ul>
    </div>
  </div>
  <div class="text-center text-xs text-gray-500 py-4">
    © {{ now()->year }}. Herramienta informativa; no sustituye asesoría legal.
  </div>
</footer>


  @vite('resources/js/app.js')
  @stack('scripts')

  @if(!request()->cookie('cookies_ok'))
<div id="cookie-banner" class="fixed bottom-4 inset-x-4 z-50 rounded-xl bg-white shadow-lg border p-4 flex flex-col sm:flex-row items-start sm:items-center gap-3">
  <p class="text-sm text-gray-700">
    Usamos cookies para mejorar la experiencia y mostrar publicidad (AdSense) tras tu consentimiento.
    Lee la <a class="underline" href="{{ route('politica-cookies') }}">política de cookies</a>.
  </p>
  <div class="flex gap-2 ml-auto">
    <button id="cookie-accept" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white">Aceptar</button>
    <a href="{{ route('politica-cookies') }}" class="px-3 py-1.5 rounded-lg border">Configurar</a>
  </div>
</div>
<script>
document.getElementById('cookie-accept')?.addEventListener('click', async () => {
  await fetch("{{ url('/set-cookies-ok') }}", {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
  document.getElementById('cookie-banner')?.remove();
});
</script>
@endif

</body>
</html>
