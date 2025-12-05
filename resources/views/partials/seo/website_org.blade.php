{{-- resources/views/partials/seo/website_org.blade.php --}}
@props([
  // Datos principales (puedes sobreescribir al incluir el parcial)
  'org_name'    => config('app.name', 'Calculadora Laboral MX'),
  'org_url'     => config('app.url', url('/')),
  'logo_url'    => asset('img/logo-512.png'), // pon aquí tu ruta real al logo
  'same_as'     => [],                         // e.g. ['https://www.facebook.com/…', 'https://x.com/…']
  'contact'     => [                           // se transforma a contactPoint
      // ['type' => 'customer support', 'telephone' => '+52 55 1234 5678', 'areaServed' => 'MX', 'availableLanguage' => ['es']]
  ],
  'site_search_action' => route('inicio'),     // URL base donde haces la búsqueda (o ruta a /buscar si la tienes)
  'site_search_param'  => 'q',                 // nombre del parámetro de consulta (p. ej., ?q=termino)
])

@php
  // Organization
  $org = [
    '@type' => 'Organization',
    '@id'   => rtrim($org_url, '/').'#organization',
    'name'  => (string) $org_name,
    'url'   => (string) $org_url,
  ];

  if ($logo_url) {
    $org['logo'] = [
      '@type' => 'ImageObject',
      'url'   => (string) $logo_url,
    ];
  }

  if (!empty($same_as) && is_array($same_as)) {
    $org['sameAs'] = array_values(array_filter($same_as, fn($u) => is_string($u) && $u !== ''));
  }

  if (!empty($contact) && is_array($contact)) {
    $points = [];
    foreach ($contact as $c) {
      $points[] = array_filter([
        '@type'            => 'ContactPoint',
        'contactType'      => $c['type']           ?? 'customer support',
        'telephone'        => $c['telephone']      ?? null,
        'email'            => $c['email']          ?? null,
        'areaServed'       => $c['areaServed']     ?? 'MX',
        'availableLanguage'=> $c['availableLanguage'] ?? ['es'],
      ], fn($v) => $v !== null && $v !== '');
    }
    if ($points) {
      $org['contactPoint'] = $points;
    }
  }

  // WebSite con búsqueda interna (si la usas)
  $website = [
    '@type' => 'WebSite',
    '@id'   => rtrim($org_url, '/').'#website',
    'url'   => (string) $org_url,
    'name'  => (string) $org_name,
    'publisher' => ['@id' => $org['@id']],
  ];

  // HowTo para el buscador interno (SearchAction)
  if ($site_search_action) {
    $website['potentialAction'] = [
      '@type'       => 'SearchAction',
      'target'      => (string) (rtrim($site_search_action, '/').'?'.$site_search_param.'={search_term_string}'),
      'query-input' => 'required name=search_term_string',
    ];
  }

  $graph = [$org, $website];

  $schema = [
    '@context' => 'https://schema.org',
    '@graph'   => $graph,
  ];
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush
