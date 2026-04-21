@php($s = fn($k,$d='') => \App\Models\Setting::get($k,$d))
<footer class="bg-brand-blue-dark text-slate-300">
    <div class="mx-auto grid max-w-7xl gap-10 px-6 py-14 md:grid-cols-4">
        <div>
            <div class="mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Enervisa" class="h-14 w-auto" />
            </div>
            <p class="text-sm leading-relaxed">{{ $s('hero_subtitle') }}</p>
        </div>
        <div>
            <h4 class="mb-3 text-sm font-bold uppercase tracking-wider text-white">Navegación</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#hero" class="hover:text-brand-orange">Inicio</a></li>
                <li><a href="#servicios" class="hover:text-brand-orange">Servicios</a></li>
                <li><a href="#proyectos" class="hover:text-brand-orange">Proyectos</a></li>
                <li><a href="#contacto" class="hover:text-brand-orange">Contáctanos</a></li>
            </ul>
        </div>
        <div>
            <h4 class="mb-3 text-sm font-bold uppercase tracking-wider text-white">Contacto</h4>
            <ul class="space-y-2 text-sm">
                <li>{{ $s('contact_email') }}</li>
                <li>{{ $s('contact_phone') }}</li>
                <li>{{ $s('contact_address') }}</li>
            </ul>
        </div>
        <div>
            <h4 class="mb-3 text-sm font-bold uppercase tracking-wider text-white">Síguenos</h4>
            <div class="flex gap-3">
                @if($s('social_facebook') && $s('social_facebook') !== '#')
                    <a href="{{ $s('social_facebook') }}" class="rounded-full bg-white/10 p-2 hover:bg-brand-orange" target="_blank">FB</a>
                @endif
                @if($s('social_instagram') && $s('social_instagram') !== '#')
                    <a href="{{ $s('social_instagram') }}" class="rounded-full bg-white/10 p-2 hover:bg-brand-orange" target="_blank">IG</a>
                @endif
                @if($s('social_linkedin') && $s('social_linkedin') !== '#')
                    <a href="{{ $s('social_linkedin') }}" class="rounded-full bg-white/10 p-2 hover:bg-brand-orange" target="_blank">IN</a>
                @endif
            </div>
        </div>
    </div>
    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-6 py-4 text-xs sm:flex-row">
            <p>© {{ date('Y') }} Enervisa. Todos los derechos reservados.</p>
            <a href="{{ route('login') }}" class="hover:text-white">Acceso Administrativo</a>
        </div>
    </div>
</footer>
