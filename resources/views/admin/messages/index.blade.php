@extends('admin.layouts.admin')
@section('title', 'Mensajes de Contacto')
@section('content')
<div class="overflow-hidden rounded-2xl bg-white shadow-md">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
            <tr><th class="p-3">Estado</th><th class="p-3">Nombre</th><th class="p-3">Correo</th><th class="p-3">Asunto</th><th class="p-3">Fecha</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($messages as $m)
                <tr class="border-t {{ $m->read ? '' : 'bg-orange-50/50' }}">
                    <td class="p-3">
                        @if($m->read)
                            <span class="inline-block h-2 w-2 rounded-full bg-slate-300"></span>
                        @else
                            <span class="inline-block h-2 w-2 rounded-full bg-brand-orange"></span>
                        @endif
                    </td>
                    <td class="p-3 font-semibold">{{ $m->name }}</td>
                    <td class="p-3">{{ $m->email }}</td>
                    <td class="p-3">{{ $m->subject ?? '—' }}</td>
                    <td class="p-3 text-xs text-slate-500">{{ $m->created_at->diffForHumans() }}</td>
                    <td class="p-3 text-right">
                        <a href="{{ route('admin.messages.show', $m) }}" class="text-sm font-semibold text-brand-orange hover:underline">Ver</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="p-6 text-center text-slate-400">Aún no hay mensajes.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $messages->links() }}</div>
@endsection
