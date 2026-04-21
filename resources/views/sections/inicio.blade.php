@php($s = fn($k,$d='') => \App\Models\Setting::get($k,$d))
<section id="inicio" class="relative bg-white py-24">
    <div class="mx-auto max-w-6xl px-6">
        <p class="section-title">Sobre Nosotros</p>
        <h2 class="section-heading">{{ $s('about_title') }}</h2>

        <div class="mx-auto max-w-4xl text-center">
            <p class="text-lg leading-relaxed text-slate-600">{{ $s('about_text') }}</p>
        </div>

        <div class="mt-16 grid grid-cols-2 gap-6 md:grid-cols-4">
            @foreach([
                ['label' => 'Proyectos Completados', 'key' => 'stat_projects'],
                ['label' => 'Clientes Satisfechos', 'key' => 'stat_clients'],
                ['label' => 'Años de Experiencia',  'key' => 'stat_years'],
                ['label' => 'Equipo Profesional',   'key' => 'stat_team'],
            ] as $stat)
                <div class="card text-center">
                    <div class="text-4xl font-extrabold text-brand-orange md:text-5xl">
                        {{ $s($stat['key']) }}
                    </div>
                    <div class="mt-2 text-sm font-semibold text-brand-blue">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
