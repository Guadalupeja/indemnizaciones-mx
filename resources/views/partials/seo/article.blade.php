@push('head')
@php
  // Valores seguros por defecto
  $headline     = isset($headline)     ? strip_tags($headline)     : (config('app.name').' - Artículo');
  $description  = isset($description)  ? strip_tags($description)  : 'Artículo informativo de '.config('app.name');
  $author       = isset($author)       ? strip_tags($author)       : 'Equipo';
  $published    = isset($published)    ? (string)$published        : now()->toDateString();
  $modified     = isset($modified)     ? (string)$modified         : now()->toDateString();
  $image        = isset($image)        ? (string)$image            : asset('img/og-default.jpg');
  $type         = isset($type)         ? (string)$type             : 'Article'; // o "BlogPosting"
  $url          = url()->current();

  $articleLd = [
    '@context'      => 'https://schema.org',
    '@type'         => $type,
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id'   => $url,
    ],
    'headline'      => $headline,
    'description'   => $description,
    'author'        => [
      '@type' => 'Person',
      'name'  => $author,
    ],
    'datePublished' => $published,
    'dateModified'  => $modified,
    'image'         => [$image],
    'inLanguage'    => 'es-MX',
    'url'           => $url,
    'publisher'     => [
      '@type' => 'Organization',
      'name'  => config('app.name'),
      'logo'  => [
        '@type' => 'ImageObject',
        'url'   => asset('img/logo-192.png'),
      ]
    ],
  ];
@endphp
<script type="application/ld+json">{!! json_encode($articleLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
