<nav x-data="{ open: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
     :class="scrolled ? 'bg-white/95 shadow-md backdrop-blur' : 'bg-transparent'"
     class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3">
        <a href="{{ route('home') }}#hero" class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Enervisa" class="h-11 w-auto md:h-14" />
        </a>

        <div class="hidden items-center gap-1 md:flex">
            <a href="#hero"      data-nav-link class="nav-link" :class="scrolled ? '' : 'text-white'">Inicio</a>
            <a href="#servicios" data-nav-link class="nav-link" :class="scrolled ? '' : 'text-white'">Servicios</a>
            <a href="#proyectos" data-nav-link class="nav-link" :class="scrolled ? '' : 'text-white'">Proyectos</a>
            <a href="#contacto"  data-nav-link class="nav-link" :class="scrolled ? '' : 'text-white'">Contáctanos</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="ml-3 btn-primary !py-2 !px-4 !text-sm">Panel</a>
            @endauth
        </div>

        <button @click="open = !open" class="md:hidden rounded p-2" :class="scrolled ? 'text-brand-blue' : 'text-white'">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path x-show="open"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div x-show="open" x-transition @click="open = false" class="md:hidden bg-white shadow-lg">
        <div class="flex flex-col px-6 py-4">
            <a href="#hero"      class="border-b py-3 font-semibold text-slate-700">Inicio</a>
            <a href="#servicios" class="border-b py-3 font-semibold text-slate-700">Servicios</a>
            <a href="#proyectos" class="border-b py-3 font-semibold text-slate-700">Proyectos</a>
            <a href="#contacto"  class="border-b py-3 font-semibold text-slate-700">Contáctanos</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="mt-2 btn-primary">Panel Admin</a>
            @endauth
        </div>
    </div>
</nav>
