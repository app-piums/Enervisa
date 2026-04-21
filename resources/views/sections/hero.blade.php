@php
    $s = fn($k, $d = '') => \App\Models\Setting::get($k, $d);
    $leftImg = asset('storage/gallery/proyecto-04.jpg');
    $rightImg = asset('storage/gallery/proyecto-01.jpg');
@endphp
<section id="hero" class="relative flex min-h-screen items-center justify-center overflow-hidden">
    {{-- Fondo WebGL (ondas naranja↔azul) como capa base --}}
    <canvas id="hero-shader" class="absolute inset-0 -z-10 h-full w-full"></canvas>

    {{-- Divisor eléctrico animado entre dos imágenes de proyectos --}}
    <x-lightning-split
        :leftImage="$leftImg"
        :rightImage="$rightImg"
        leftAlt="Proyecto solar fotovoltaico"
        rightAlt="Instalación de subestación"
    />

    {{-- Viñeta para mejorar contraste del texto --}}
    <div class="pointer-events-none absolute inset-0 z-20 bg-gradient-to-b from-black/40 via-black/20 to-black/80"></div>

    {{-- Contenido del hero --}}
    <div class="pointer-events-none relative z-40 mx-auto max-w-5xl px-6 py-32 text-center">
           <img src="{{ asset('images/logo.png') }}" alt="Enervisa"
               class="mx-auto mb-8 h-28 w-auto drop-shadow-2xl md:h-36" />
        <p class="pointer-events-auto mb-4 inline-block rounded-full bg-white/10 px-4 py-1 text-xs font-bold uppercase tracking-[0.3em] text-white backdrop-blur">
            ⚡ Energía del futuro
        </p>
        <h1 class="mb-4 text-5xl font-extrabold leading-none tracking-tight text-white drop-shadow-2xl md:text-7xl">
            {{ $s('hero_title', 'ENERVISA') }}
        </h1>
        <p class="mx-auto mb-3 max-w-3xl text-xl font-semibold text-brand-orange-light drop-shadow md:text-2xl">
            {{ $s('hero_subtitle') }}
        </p>
        <p class="mx-auto mb-10 max-w-2xl text-base text-slate-100 md:text-lg">
            {{ $s('hero_description') }}
        </p>
        <div class="pointer-events-auto flex flex-wrap justify-center gap-4">
            <a href="#servicios" class="btn-primary">Nuestros Servicios →</a>
            <a href="#contacto" class="rounded-full border-2 border-white px-6 py-3 font-semibold text-white transition hover:bg-white hover:text-brand-blue">
                Contáctanos
            </a>
        </div>
    </div>

    <a href="#servicios" class="absolute bottom-8 left-1/2 z-40 -translate-x-1/2 text-white animate-bounce">
        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </a>
</section>
