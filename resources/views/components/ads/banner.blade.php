{{-- resources/views/components/ads/banner.blade.php --}}
@php
  // $size = "300x250" → [300, 250]
  [$w, $h] = array_map('intval', explode('x', $size));
@endphp

<div class="ad-slot"
     style="display:block;min-width:{{ $w }}px;min-height:{{ $h }}px;">
  @if(env('ADSENSE_CLIENT') && $slotId)
    <ins class="adsbygoogle"
         style="display:block;min-width:{{ $w }}px;min-height:{{ $h }}px;"
         data-ad-client="{{ env('ADSENSE_CLIENT') }}"
         data-ad-slot="{{ $slotId }}"
         data-ad-format="{{ $responsive ? 'auto' : 'rectangle' }}"
         data-full-width-responsive="{{ $responsive ? 'true' : 'false' }}">
    </ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
  @elseif($img) {{-- respaldo si vendes directo --}}
    <a href="{{ $href ?? '#' }}" style="display:block;width:{{ $w }}px;height:{{ $h }}px">
      <img src="{{ $img }}" width="{{ $w }}" height="{{ $h }}" loading="lazy" decoding="async" alt="Publicidad">
    </a>
  @endif
</div>

