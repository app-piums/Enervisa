@extends('admin.layouts.admin')
@section('title', 'Subir Fotos')
@section('content')
<form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data"
      class="max-w-2xl space-y-4 rounded-2xl bg-white p-6 shadow-md"
      x-data="{ files: [] }">
    @csrf
    @if($errors->any())
        <div class="rounded-lg border border-red-300 bg-red-50 px-4 py-2 text-sm text-red-800">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif
    <div>
        <label class="label">Título (común a todas)</label>
        <input name="title" class="input" value="{{ old('title') }}" placeholder="Ej: Proyecto XYZ">
    </div>
    <div>
        <label class="label">Descripción</label>
        <textarea name="description" class="input" rows="3">{{ old('description') }}</textarea>
    </div>
    <div>
        <label class="label">Imágenes * (JPG, PNG, WEBP — máx. 10MB c/u)</label>
        <input name="images[]" type="file" accept="image/*" multiple required
               @change="files = Array.from($event.target.files)"
               class="block w-full rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 text-sm">
        <div class="mt-2 flex flex-wrap gap-2" x-show="files.length">
            <template x-for="f in files" :key="f.name">
                <span class="inline-block rounded bg-slate-100 px-2 py-1 text-xs" x-text="f.name"></span>
            </template>
        </div>
    </div>
    <div class="flex gap-2">
        <button class="btn-primary">Subir</button>
        <a href="{{ route('admin.gallery.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
@endsection
