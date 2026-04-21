@props([
    'leftImage' => '',
    'rightImage' => '',
    'leftAlt' => 'Izquierda',
    'rightAlt' => 'Derecha',
])

{{-- Lightning-split: two layered images with an animated wavy electric divider.
     Behavior is driven by resources/js/lightning-split.js via [data-lightning-split]. --}}
<div data-lightning-split class="absolute inset-0 select-none overflow-hidden">
    {{-- Right layer (base) --}}
    <div class="absolute inset-0">
        <img
            src="{{ $rightImage }}"
            alt="{{ $rightAlt }}"
            class="h-full w-full object-cover"
            draggable="false"
        />
        <div class="absolute inset-0 bg-gradient-to-b from-[#0f2540]/50 via-[#1B3A5C]/40 to-black/70"></div>
    </div>

    {{-- Left layer (wavy-clipped) --}}
    <div data-ls-left class="absolute inset-0" style="clip-path: polygon(0% 0%, 60% 0%, 35% 100%, 0% 100%);">
        <img
            src="{{ $leftImage }}"
            alt="{{ $leftAlt }}"
            class="h-full w-full object-cover"
            draggable="false"
        />
        <div class="absolute inset-0 bg-gradient-to-b from-[#c43d0c]/40 via-[#E8531D]/30 to-black/70"></div>
    </div>

    {{-- Electric arc polylines --}}
    <svg
        data-ls-svg
        class="pointer-events-none absolute inset-0 z-30 h-full w-full"
        viewBox="0 0 100 100"
        preserveAspectRatio="none"
        aria-hidden="true"
    >
        <defs>
            <filter id="ls-glow" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stdDeviation="1.2" result="blur"/>
                <feMerge>
                    <feMergeNode in="blur"/>
                    <feMergeNode in="SourceGraphic"/>
                </feMerge>
            </filter>
        </defs>
        {{-- Outer halo (electric cyan) --}}
        <polyline points="60,0 35,100" fill="none"
                  stroke="rgba(135,206,250,0.65)" stroke-width="3.8"
                  vector-effect="non-scaling-stroke" filter="url(#ls-glow)"/>
        {{-- Mid glow (brand orange) --}}
        <polyline points="60,0 35,100" fill="none"
                  stroke="rgba(232,83,29,0.70)" stroke-width="2.4"
                  vector-effect="non-scaling-stroke" filter="url(#ls-glow)"/>
        {{-- Bright core --}}
        <polyline points="60,0 35,100" fill="none"
                  stroke="white" stroke-opacity="0.98" stroke-width="1.4"
                  vector-effect="non-scaling-stroke"/>
    </svg>
</div>
