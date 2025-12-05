{{-- resources/views/partials/seo/breadcrumbs.blade.php --}}
@props(['items' => []])

@php
  // Normaliza y construye lista de migas:
  $elements = [];
  $pos = 1;
  foreach ($items as $it) {
      $elements[] = [
          '@type'    => 'ListItem',
          'position' => $pos++,
          'name'     => (string)($it['name'] ?? ''),
          'item'     => (string)($it['url']  ?? url()->current()),
      ];
  }

  $schema = [
      '@context'        => 'https://schema.org',
      '@type'           => 'BreadcrumbList',
      'itemListElement' => $elements,
  ];
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush
