@extends('layouts.app')
@section('title','Política de cookies')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">

  {{-- Encabezado --}}
  <header class="space-y-2">
    <h1 class="text-3xl font-semibold">Política de cookies</h1>
    <p class="text-gray-600">
      Esta Política de cookies explica qué son las cookies, qué tipos utilizamos en este sitio, con qué finalidad,
      por cuánto tiempo permanecen activas en tu dispositivo, y cómo puedes gestionarlas o revocar tu consentimiento.
    </p>
    <p class="text-xs text-gray-500">
      Última actualización:
      <time datetime="{{ now()->toDateString() }}">{{ now()->translatedFormat('d \\de F, Y') }}</time>
    </p>
  </header>

  {{-- ¿Qué son las cookies? --}}
  <section id="que-son" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Qué son las cookies?</h2>
    <p class="text-gray-700 leading-7">
      Las <strong>cookies</strong> son pequeños archivos de texto que un sitio web coloca en tu navegador o dispositivo
      cuando lo visitas. Sirven para que el sitio funcione correctamente, recordar tus preferencias, mejorar la
      experiencia de usuario, obtener estadísticas de uso y, en su caso, mostrar anuncios relevantes.
    </p>
  </section>

  {{-- Base legal y consentimiento --}}
  <section id="base-legal" class="space-y-3">
    <h2 class="text-xl font-semibold">Base legal y consentimiento</h2>
    <p class="text-gray-700 leading-7">
      La base legal para el uso de <strong>cookies necesarias</strong> es nuestro interés legítimo en ofrecer un sitio
      seguro y funcional. Para <strong>cookies de analítica y publicidad</strong>, solicitamos tu consentimiento
      explícito a través del banner de cookies. Puedes <strong>retirar o modificar</strong> tu consentimiento en cualquier
      momento mediante los controles que verás más abajo.
    </p>
  </section>

  {{-- Botones de gestión rápida --}}
  <section id="controles" class="space-y-3">
    <h2 class="text-xl font-semibold">Gestiona tus preferencias</h2>
    <div class="flex flex-wrap gap-2">
      <button type="button" onclick="window.__cookiesAcceptAll()" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
        Aceptar todas (analítica y publicidad)
      </button>
      <button type="button" onclick="window.__cookiesRejectAll()" class="inline-flex items-center rounded-xl border px-4 py-2 hover:bg-gray-50">
        Rechazar no esenciales
      </button>
      <button type="button" onclick="window.__cookiesRevoke()" class="inline-flex items-center rounded-xl border px-4 py-2 hover:bg-gray-50">
        Revocar consentimiento
      </button>
    </div>
    <p class="text-sm text-gray-600">
      Al aceptar todas, activas cookies de analítica (GA4) y publicidad (AdSense/Google Marketing Platform).
      Al rechazar, únicamente permanecerán las cookies estrictamente necesarias para el funcionamiento del sitio.
    </p>
  </section>

  {{-- Tipos de cookies --}}
  <section id="tipos" class="space-y-3">
    <h2 class="text-xl font-semibold">Tipos de cookies que utilizamos</h2>

    <h3 class="font-semibold">1) Cookies necesarias (técnicas)</h3>
    <p class="text-gray-700 leading-7">
      Imprescindibles para que el sitio funcione y para mantener la seguridad, la gestión de sesión y tus preferencias
      básicas (por ejemplo, recordar si aceptaste las cookies). No requieren consentimiento.
    </p>

    <h3 class="font-semibold mt-4">2) Cookies de analítica (Google Analytics 4)</h3>
    <p class="text-gray-700 leading-7">
      Nos ayudan a entender cómo se utiliza el sitio (páginas visitadas, tiempo de permanencia, eventos). La información
      es agregada y anónima. Estas cookies se <strong>cargan sólo si das tu consentimiento</strong>.
    </p>

    <h3 class="font-semibold mt-4">3) Cookies publicitarias (Google AdSense / Google Marketing Platform)</h3>
    <p class="text-gray-700 leading-7">
      Permiten mostrar anuncios y medir su rendimiento. Pueden usarse para personalizar la publicidad según tu actividad.
      Estas cookies se <strong>cargan sólo tras tu consentimiento</strong> y se integran con el <em>Consent Mode</em> de Google cuando aplica.
    </p>
  </section>

  {{-- Tabla de cookies (ejemplos habituales) --}}
  <section id="tabla" class="space-y-3">
    <h2 class="text-xl font-semibold">Detalle de cookies</h2>
    <div class="overflow-x-auto rounded-2xl border">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="bg-gray-50 text-left">
            <th class="px-4 py-2">Nombre</th>
            <th class="px-4 py-2">Finalidad</th>
            <th class="px-4 py-2">Proveedor</th>
            <th class="px-4 py-2">Duración</th>
            <th class="px-4 py-2">Tipo</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          {{-- Necesarias --}}
          <tr>
            <td class="px-4 py-2">XSRF-TOKEN</td>
            <td class="px-4 py-2">Seguridad. Prevención de CSRF en formularios.</td>
            <td class="px-4 py-2">Propia ({{ parse_url(config('app.url'), PHP_URL_HOST) ?? 'este sitio' }})</td>
            <td class="px-4 py-2">Sesión</td>
            <td class="px-4 py-2">HTTP, necesaria</td>
          </tr>
          <tr>
            <td class="px-4 py-2">laravel_session</td>
            <td class="px-4 py-2">Mantener la sesión del usuario y el estado de navegación.</td>
            <td class="px-4 py-2">Propia</td>
            <td class="px-4 py-2">Sesión</td>
            <td class="px-4 py-2">HTTP, necesaria</td>
          </tr>
          <tr>
            <td class="px-4 py-2">cookies_ok</td>
            <td class="px-4 py-2">Recordar el consentimiento de cookies para cargar servicios opcionales.</td>
            <td class="px-4 py-2">Propia</td>
            <td class="px-4 py-2">12 meses (configurable)</td>
            <td class="px-4 py-2">HTTP, preferencia</td>
          </tr>

          {{-- Analítica GA4 (se instalan sólo con consentimiento) --}}
          <tr>
            <td class="px-4 py-2">_ga</td>
            <td class="px-4 py-2">Distinguir usuarios de forma agregada (medición de audiencia).</td>
            <td class="px-4 py-2">Google Analytics</td>
            <td class="px-4 py-2">2 años</td>
            <td class="px-4 py-2">HTTP, analítica</td>
          </tr>
          <tr>
            <td class="px-4 py-2">_ga_&lt;ID&gt;</td>
            <td class="px-4 py-2">Mantener el estado de sesión en GA4.</td>
            <td class="px-4 py-2">Google Analytics</td>
            <td class="px-4 py-2">2 años</td>
            <td class="px-4 py-2">HTTP, analítica</td>
          </tr>

          {{-- Publicidad AdSense / GMP (sólo con consentimiento) --}}
          <tr>
            <td class="px-4 py-2">__gads</td>
            <td class="px-4 py-2">Mostrar y medir anuncios (no personalización si no consientes).</td>
            <td class="px-4 py-2">Google AdSense</td>
            <td class="px-4 py-2">Hasta 13 meses</td>
            <td class="px-4 py-2">HTTP, publicidad</td>
          </tr>
          <tr>
            <td class="px-4 py-2">__gpi</td>
            <td class="px-4 py-2">Frecuencia/alcance de anuncios y medición.</td>
            <td class="px-4 py-2">Google AdSense</td>
            <td class="px-4 py-2">Hasta 13 meses</td>
            <td class="px-4 py-2">HTTP, publicidad</td>
          </tr>
          <tr>
            <td class="px-4 py-2">IDE</td>
            <td class="px-4 py-2">Entrega de anuncios y medición en dominios de Google/DoubleClick.</td>
            <td class="px-4 py-2">Google / doubleclick.net</td>
            <td class="px-4 py-2">Hasta 13 meses</td>
            <td class="px-4 py-2">HTTP, publicidad</td>
          </tr>
        </tbody>
      </table>
    </div>
    <p class="text-xs text-gray-500">
      Nota: los nombres exactos y la vigencia pueden variar por actualizaciones de Google o configuración local.
    </p>
  </section>

  {{-- Consent Mode (opcional) --}}
  <section id="consent-mode" class="space-y-3">
    <h2 class="text-xl font-semibold">Consent Mode de Google (opcional)</h2>
    <p class="text-gray-700 leading-7">
      Cuando el consentimiento no se otorga, Google puede operar en un modo con señales limitadas que ayuda a realizar
      medición básica respetando tus preferencias. Si otorgas consentimiento, GA4 y AdSense podrán establecer cookies
      de medición y/o publicidad según corresponda.
    </p>
  </section>

  {{-- ¿Cómo desactivar las cookies en el navegador? --}}
  <section id="desactivar" class="space-y-3">
    <h2 class="text-xl font-semibold">¿Cómo desactivar o eliminar cookies desde tu navegador?</h2>
    <p class="text-gray-700 leading-7">
      Puedes configurar o eliminar cookies directamente desde tu navegador. Consulta la ayuda de tu navegador para
      ver los pasos actualizados:
    </p>
    <ul class="list-disc pl-5 text-gray-700 leading-7">
      <li>Chrome (Configuración &gt; Privacidad y seguridad &gt; Cookies y otros datos de sitios).</li>
      <li>Firefox (Opciones &gt; Privacidad &amp; Seguridad &gt; Cookies y datos del sitio).</li>
      <li>Safari (Preferencias &gt; Privacidad).</li>
      <li>Microsoft Edge (Configuración &gt; Cookies y permisos del sitio).</li>
    </ul>
    <p class="text-sm text-gray-600">
      Ten en cuenta que bloquear cookies necesarias puede afectar el funcionamiento del sitio.
    </p>
  </section>

  {{-- Contacto --}}
  <section id="contacto" class="space-y-3">
    <h2 class="text-xl font-semibold">Contacto</h2>
    <p class="text-gray-700 leading-7">
      Si tienes dudas sobre esta Política de cookies o sobre el tratamiento de tus datos, contáctanos en:
      <a class="underline" href="mailto:soporte@calculadoraindemnizacion.com">soporte@calculadoraindemnizacion.com</a>.
    </p>
  </section>

</div>
@endsection

@push('scripts')
<script>
  // --- Utilidades para cookies ---
  function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days*24*60*60*1000));
    document.cookie = name + "=" + (value || "") + "; expires=" + d.toUTCString() + "; path=/; SameSite=Lax";
  }
  function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; SameSite=Lax";
  }

  // --- Acciones rápidas coherentes con tu sitio ---
  // Aceptar todo: crea cookies_ok y (opcional) señales para Consent Mode si las usas con gtag
  window.__cookiesAcceptAll = function() {
    setCookie('cookies_ok', '1', 365); // tu sitio ya condiciona AdSense con esta cookie
    // Señales Consent Mode opcionales (si usas gtag):
    // if (window.gtag) {
    //   gtag('consent', 'update', {
    //     'ad_storage': 'granted',
    //     'analytics_storage': 'granted',
    //     'ad_user_data': 'granted',
    //     'ad_personalization': 'granted'
    //   });
    // }
    location.reload();
  };

  // Rechazar no esenciales: quita consentimiento y borra principales cookies de GA/Ads si existieran
  window.__cookiesRejectAll = function() {
    setCookie('cookies_ok', '', -1); // eliminar
    // Borrado básico (si el navegador lo permite desde JS en este dominio):
    deleteCookie('_ga');
    // Si tu dominio no puede borrar cookies de terceros, el bloqueo efectivo lo hace el banner y tu lógica de carga.
    // Consent Mode opcional:
    // if (window.gtag) {
    //   gtag('consent', 'update', {
    //     'ad_storage': 'denied',
    //     'analytics_storage': 'denied',
    //     'ad_user_data': 'denied',
    //     'ad_personalization': 'denied'
    //   });
    // }
    location.reload();
  };

  // Revocar: equivalente a rechazar y recargar
  window.__cookiesRevoke = function() {
    window.__cookiesRejectAll();
  };
</script>
@endpush
