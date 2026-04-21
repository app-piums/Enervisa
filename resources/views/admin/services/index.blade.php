@extends('admin.layouts.admin')
@section('title', 'Servicios')
@section('content')
<div class="mb-4 flex justify-between">
    <p class="text-sm text-slate-500">Gestiona los servicios que aparecen en la página pública.</p>
    <a href="{{ route('admin.services.create') }}" class="btn-primary !py-2 !text-sm">+ Nuevo Servicio</a>
</div>
<div class="overflow-hidden rounded-2xl bg-white shadow-md">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
            <tr><th class="p-3">Orden</th><th class="p-3">Título</th><th class="p-3">Ícono</th><th class="p-3">Activo</th><th class="p-3 text-right">Acciones</th></tr>
        </thead>
        <tbody>
            @forelse($services as $service)
                <tr class="border-t">
                    <td class="p-3">{{ $service->sort_order }}</td>
                    <td class="p-3 font-semibold text-brand-blue">{{ $service->title }}</td>
                    <td class="p-3"><code class="rounded bg-slate-100 px-2 py-0.5 text-xs">{{ $service->icon }}</code></td>
                    <td class="p-3">
                        @if($service->active)
                            <span class="inline-block rounded-full bg-green-100 px-2 py-0.5 text-xs text-green-700">Sí</span>
                        @else
                            <span class="inline-block rounded-full bg-red-100 px-2 py-0.5 text-xs text-red-700">No</span>
                        @endif
                    </td>
                    <td class="p-3 text-right">
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-sm font-semibold text-brand-orange hover:underline">Editar</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline" onsubmit="return confirm('¿Eliminar este servicio?')">
                            @csrf @method('DELETE')
                            <button class="ml-2 text-sm font-semibold text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-6 text-center text-slate-400">Sin servicios.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $services->links() }}</div>
@endsection
