{{-- resources/views/partials/seo/howto.blade.php --}}
@push('head')
@php
  $howto = [
    '@context'   => 'https://schema.org',
    '@type'      => 'HowTo',
    'name'       => 'Cómo usar el test: ¿Indemnización o finiquito?',
    'description'=> 'Guía paso a paso para identificar si te conviene calcular indemnización por despido injustificado o liquidación/finiquito.',
    'totalTime'  => 'PT2M',
    'step'       => [
      [
        '@type' => 'HowToStep',
        'name'  => 'Abre el test',
        'text'  => 'Ve a la página del test para comenzar.',
        'url'   => route('test-caso-laboral'),
      ],
      [
        '@type' => 'HowToStep',
        'name'  => 'Responde las preguntas',
        'text'  => 'Indica cómo terminó la relación laboral, si hubo causa, reinstalación y otros supuestos.',
      ],
      [
        '@type' => 'HowToStep',
        'name'  => 'Envía y revisa la sugerencia',
        'text'  => 'El sistema te mostrará si corresponde orientar el cálculo a indemnización o finiquito.',
      ],
      [
        '@type' => 'HowToStep',
        'name'  => 'Calcula tu monto',
        'text'  => 'Usa la calculadora con tus datos (SD/SDI, fechas, zona) para ver el desglose.',
        'url'   => route('inicio'),
      ],
      [
        '@type' => 'HowToStep',
        'name'  => 'Consulta el desglose',
        'text'  => 'Revisa 3 meses, 20 días/año (si procede), vacaciones y prima, aguinaldo y prima de antigüedad con su base legal.',
      ],
    ],
    'inLanguage' => 'es-MX',
  ];
@endphp
<script type="application/ld+json">
{!! json_encode($howto, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush
