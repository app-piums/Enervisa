@php
    $icons = [
        'bolt'   => '<path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z"/>',
        'tower'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 4v16m16-16v16M8 4l4 16 4-16M6 10h12M5 14h14"/>',
        'cube'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.3 7L12 12l8.7-5M12 22V12"/>',
        'sun'    => '<circle cx="12" cy="12" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>',
        'wrench' => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>',
        'chart'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 15l4-4 4 4 5-5"/>',
    ];
@endphp

<section id="servicios" class="relative bg-slate-50 py-24">
    <div class="mx-auto max-w-7xl px-6">
        <p class="section-title">Qué Hacemos</p>
        <h2 class="section-heading">Nuestros Servicios</h2>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($services as $service)
                <div class="card group">
                    <div class="mb-5 inline-flex h-14 w-14 items-center justify-center rounded-xl bg-brand-blue text-brand-orange transition group-hover:bg-brand-orange group-hover:text-white">
                        <svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="0" class="h-7 w-7">
                            {!! $icons[$service->icon] ?? $icons['bolt'] !!}
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-brand-blue">{{ $service->title }}</h3>
                    <p class="text-sm leading-relaxed text-slate-600">{{ $service->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
