@extends('admin.layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <div class="grid gap-6 md:grid-cols-4">
        @foreach([
            ['Servicios', $stats['services'], 'bg-blue-500'],
            ['Fotos en Galería', $stats['photos'], 'bg-orange-500'],
            ['Mensajes Totales', $stats['messages'], 'bg-emerald-500'],
            ['Mensajes sin Leer', $stats['unread'], 'bg-rose-500'],
        ] as [$label, $value, $color])
            <div class="rounded-2xl bg-white p-6 shadow-md">
                <div class="inline-block rounded-lg {{ $color }} p-2 text-white">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z"/></svg>
                </div>
                <div class="mt-3 text-3xl font-extrabold text-brand-blue">{{ $value }}</div>
                <div class="text-sm text-slate-500">{{ $label }}</div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 rounded-2xl bg-white p-6 shadow-md">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-brand-blue">Mensajes Recientes</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-sm font-semibold text-brand-orange hover:underline">Ver todos →</a>
        </div>
        @forelse($recentMessages as $m)
            <a href="{{ route('admin.messages.show', $m) }}" class="flex items-center justify-between border-b py-3 last:border-0 hover:bg-slate-50">
                <div>
                    <div class="font-semibold">{{ $m->name }} <span class="text-xs text-slate-400">&lt;{{ $m->email }}&gt;</span></div>
                    <div class="text-sm text-slate-600 line-clamp-1">{{ $m->message }}</div>
                </div>
                <div class="text-xs text-slate-400">{{ $m->created_at->diffForHumans() }}</div>
            </a>
        @empty
            <p class="text-sm text-slate-500">Aún no hay mensajes.</p>
        @endforelse
    </div>
@endsection
