<?php

namespace App\View\Components\Ads;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Banner extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $slotId = null,    // ID del bloque AdSense
        public string  $size   = '300x250',
        public ?string $href   = null,    // link si vendes directo
        public ?string $img    = null,    // imagen si vendes directo
        public bool    $responsive = false // modo responsivo AdSense
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ads.banner');
    }
}
