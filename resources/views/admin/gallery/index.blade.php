@extends('admin.layouts.admin')
@section('title', 'Galería de Proyectos')
@section('content')
<div class="mb-4 flex justify-between">
    <p class="text-sm text-slate-500">Sube, edita y organiza las fotos de proyectos.</p>
    <a href="{{ route('admin.gallery.create') }}" class="btn-primary !py-2 !text-sm">+ Subir Fotos</a>
</div>

@if($items->isEmpty())
    <div class="rounded-2xl bg-white p-12 text-center shadow-md">
        <p class="text-slate-500">Aún no hay fotos. Sube la primera.</p>
    </div>
@else
    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach($items as $item)
            <div class="overflow-hidden rounded-2xl bg-white shadow-md">
                <img src="{{ $item->thumbnail_url }}" alt="" class="aspect-[4/3] w-full object-cover">
                <div class="p-3">
                    <div class="truncate text-sm font-semibold text-brand-blue">{{ $item->title ?: 'Sin título' }}</div>
                    <div class="mt-1 flex justify-between text-xs text-slate-500">
                        <span>Orden: {{ $item->sort_order }}</span>
                        <span>{{ $item->active ? '✓ Activo' : '✕ Oculto' }}</span>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('admin.gallery.edit', $item) }}" class="flex-1 rounded bg-slate-100 px-3 py-1.5 text-center text-xs font-semibold hover:bg-slate-200">Editar</a>
                        <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" class="flex-1" onsubmit="return confirm('¿Eliminar esta foto?')">
                            @csrf @method('DELETE')
                            <button class="w-full rounded bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $items->links() }}</div>
@endif
@endsection
