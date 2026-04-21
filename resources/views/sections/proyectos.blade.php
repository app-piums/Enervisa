<section id="proyectos" class="relative bg-gradient-to-b from-slate-50 to-white py-24">
    <div class="mx-auto max-w-7xl px-6">
        <p class="section-title">Nuestro Trabajo</p>
        <h2 class="section-heading">Proyectos Realizados</h2>

        @if($galleries->isEmpty())
            <p class="text-center text-slate-500">Próximamente publicaremos los proyectos realizados.</p>
        @else
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($galleries as $i => $item)
                    @php
                        $spanClass = match($i % 6) {
                            0, 3 => 'md:row-span-2',
                            default => '',
                        };
                    @endphp
                    <a href="{{ $item->image_url }}"
                       class="glightbox group relative block overflow-hidden rounded-2xl bg-slate-900 shadow-lg {{ $spanClass }}"
                       data-gallery="proyectos"
                       data-title="{{ $item->title }}"
                       data-description="{{ $item->description }}">
                        <img src="{{ $item->thumbnail_url }}"
                             alt="{{ $item->title }}"
                             loading="lazy"
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105 group-hover:opacity-90 {{ str_contains($spanClass, 'row-span-2') ? 'aspect-[3/4]' : 'aspect-[4/3]' }}">
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/80 via-black/0 to-transparent opacity-0 transition group-hover:opacity-100"></div>
                        <div class="pointer-events-none absolute inset-x-0 bottom-0 translate-y-4 p-5 text-white opacity-0 transition group-hover:translate-y-0 group-hover:opacity-100">
                            <h3 class="text-lg font-bold">{{ $item->title }}</h3>
                            @if($item->description)
                                <p class="mt-1 text-sm text-slate-200 line-clamp-2">{{ $item->description }}</p>
                            @endif
                        </div>
                        <div class="absolute right-3 top-3 rounded-full bg-white/20 p-2 backdrop-blur opacity-0 transition group-hover:opacity-100">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16zM8 11h6M11 8v6"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
