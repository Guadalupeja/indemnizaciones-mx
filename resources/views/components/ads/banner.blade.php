@php
    // Medidas cuando NO es responsivo
    [$w, $h] = array_pad(explode('x', $size ?? '300x250'), 2, null);
@endphp

<div {{ $attributes->merge(['class' => 'inline-block']) }}>
  @if($href && $img)
    {{-- Venta directa (imagen + link) --}}
    <a href="{{ $href }}" target="_blank" rel="nofollow sponsored noopener"
       class="block overflow-hidden rounded-xl shadow hover:shadow-md transition">
      <img src="{{ $img }}" alt="Publicidad" width="{{ $w }}" height="{{ $h }}" loading="lazy">
    </a>

  @elseif(app()->environment('production') && env('ADSENSE_CLIENT') && $slotId)
    {{-- AdSense --}}
    @if($responsive)
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="{{ env('ADSENSE_CLIENT') }}"
           data-ad-slot="{{ $slotId }}"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
    @else
      <ins class="adsbygoogle"
           style="display:inline-block;width:{{ $w }}px;height:{{ $h }}px"
           data-ad-client="{{ env('ADSENSE_CLIENT') }}"
           data-ad-slot="{{ $slotId }}"></ins>
    @endif

    @push('scripts')
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    @endpush

  @else
    {{-- Placeholder en desarrollo o si falta configuración --}}
    <div class="flex items-center justify-center text-xs text-gray-500 border border-dashed rounded-xl"
         style="width:{{ $w }}px;height:{{ $h }}px">
      [Anuncio {{ $size }} — dev]
    </div>
  @endif
</div>
