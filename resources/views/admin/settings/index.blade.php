@extends('admin.layouts.admin')
@section('title', 'Configuración del Sitio')
@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
    @csrf
    @foreach($grouped as $group => $items)
        <div class="rounded-2xl bg-white p-6 shadow-md">
            <h2 class="mb-4 text-lg font-bold capitalize text-brand-blue">
                {{ ['hero'=>'Hero / Portada','about'=>'Sobre Nosotros','contact'=>'Contacto','social'=>'Redes Sociales','seo'=>'SEO'][$group] ?? $group }}
            </h2>
            <div class="grid gap-4 md:grid-cols-2">
                @foreach($items as $item)
                    <div class="{{ $item->type === 'textarea' ? 'md:col-span-2' : '' }}">
                        <label class="label">{{ $item->label ?? $item->key }}</label>
                        @if($item->type === 'textarea')
                            <textarea name="settings[{{ $item->key }}]" class="input" rows="3">{{ $item->value }}</textarea>
                        @else
                            <input type="{{ in_array($item->type,['email','url']) ? $item->type : 'text' }}"
                                   name="settings[{{ $item->key }}]" class="input" value="{{ $item->value }}">
                        @endif
                        <div class="mt-1 text-xs text-slate-400">{{ $item->key }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    <button class="btn-primary">Guardar Cambios</button>
</form>
@endsection
