<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') — Enervisa Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100">
    <div x-data="{ sidebar: false }" class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
               class="fixed inset-y-0 left-0 z-40 w-64 transform bg-brand-blue-dark text-slate-200 transition-transform md:static">
            <div class="border-b border-white/10 p-5">
                <img src="{{ asset('images/logo.png') }}" alt="Enervisa" class="h-10 w-auto" />
            </div>
            <nav class="space-y-1 p-3 text-sm">
                @php
                    $nav = [
                        ['admin.dashboard',      'Dashboard',    'M3 12l9-9 9 9M5 10v10h14V10'],
                        ['admin.services.index', 'Servicios',    'M13 10V3L4 14h7v7l9-11h-7z'],
                        ['admin.gallery.index',  'Galería',      'M4 4h16v16H4zM4 14l4-4 4 4 4-4 4 4'],
                        ['admin.messages.index', 'Mensajes',     'M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['admin.settings.index', 'Configuración','M10.3 3.6a2 2 0 013.4 0l.5.9a2 2 0 001.8 1l1 .1a2 2 0 011.8 1.8l.1 1a2 2 0 001 1.8l.9.5a2 2 0 010 3.4l-.9.5a2 2 0 00-1 1.8l-.1 1a2 2 0 01-1.8 1.8l-1 .1a2 2 0 00-1.8 1l-.5.9a2 2 0 01-3.4 0l-.5-.9a2 2 0 00-1.8-1l-1-.1a2 2 0 01-1.8-1.8l-.1-1a2 2 0 00-1-1.8l-.9-.5a2 2 0 010-3.4l.9-.5a2 2 0 001-1.8l.1-1a2 2 0 011.8-1.8l1-.1a2 2 0 001.8-1l.5-.9zM12 15a3 3 0 100-6 3 3 0 000 6z'],
                        ['admin.users.index',    'Usuarios',     'M12 11a4 4 0 100-8 4 4 0 000 8zM2 20a10 10 0 0120 0'],
                    ];
                @endphp
                @foreach($nav as [$route, $label, $path])
                    @php($active = request()->routeIs(str_replace('.index', '', $route) . '*'))
                    <a href="{{ route($route) }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 transition {{ $active ? 'bg-brand-orange text-white' : 'hover:bg-white/10' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/>
                        </svg>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
            <div class="absolute bottom-0 w-full border-t border-white/10 p-3 text-xs">
                <a href="{{ route('home') }}" target="_blank" class="block rounded px-3 py-2 hover:bg-white/10">↗ Ver sitio</a>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="w-full rounded px-3 py-2 text-left text-red-300 hover:bg-red-500/20">Cerrar sesión</button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex items-center justify-between border-b bg-white px-6 py-3 shadow-sm">
                <button @click="sidebar = !sidebar" class="md:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-bold text-brand-blue">@yield('title', 'Dashboard')</h1>
                <div class="text-sm text-slate-600">
                    {{ auth()->user()->name }} <span class="text-xs text-slate-400">({{ auth()->user()->role }})</span>
                </div>
            </header>

            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-4 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
