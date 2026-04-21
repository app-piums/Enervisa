@extends('admin.layouts.admin')
@section('title', 'Editar Imagen')
@section('content')
<form method="POST" action="{{ route('admin.gallery.update', $gallery) }}" class="grid max-w-4xl gap-6 md:grid-cols-2">
    @csrf @method('PUT')
    <div class="rounded-2xl bg-white p-4 shadow-md">
        <img src="{{ $gallery->image_url }}" class="w-full rounded-lg">
    </div>
    <div class="space-y-4 rounded-2xl bg-white p-6 shadow-md">
        @if($errors->any())
            <div class="rounded-lg border border-red-300 bg-red-50 px-4 py-2 text-sm text-red-800">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif
        <div>
            <label class="label">Título</label>
            <input name="title" class="input" value="{{ old('title', $gallery->title) }}">
        </div>
        <div>
            <label class="label">Descripción</label>
            <textarea name="description" class="input" rows="4">{{ old('description', $gallery->description) }}</textarea>
        </div>
        <div>
            <label class="label">Orden</label>
            <input name="sort_order" type="number" class="input" value="{{ old('sort_order', $gallery->sort_order) }}">
        </div>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="active" value="1" @checked(old('active', $gallery->active)) class="rounded">
            <span class="text-sm">Activa</span>
        </label>
        <div class="flex gap-2">
            <button class="btn-primary">Guardar</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn-secondary">Cancelar</a>
        </div>
    </div>
</form>
@endsection
