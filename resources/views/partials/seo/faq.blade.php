{{-- resources/views/partials/seo/faq.blade.php --}}
@props(['faqs' => []])

@php
  // Espera un arreglo de Q&A: [['q' => 'Pregunta', 'a' => 'Respuesta'], ...]
  $mainEntity = [];
  foreach ($faqs as $row) {
    $q = (string)($row['q'] ?? '');
    $a = (string)($row['a'] ?? '');
    if ($q === '' || $a === '') continue;

    $mainEntity[] = [
      '@type' => 'Question',
      'name'  => $q,
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text'  => $a,
      ],
    ];
  }

  $schema = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => $mainEntity,
  ];
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush
