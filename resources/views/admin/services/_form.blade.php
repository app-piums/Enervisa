@if($errors->any())
    <div class="rounded-lg border border-red-300 bg-red-50 px-4 py-2 text-sm text-red-800">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
@endif
<div>
    <label class="label">Título *</label>
    <input name="title" class="input" value="{{ old('title', $service->title ?? '') }}" required>
</div>
<div>
    <label class="label">Descripción *</label>
    <textarea name="description" class="input" rows="4" required>{{ old('description', $service->description ?? '') }}</textarea>
</div>
<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="label">Ícono</label>
        <select name="icon" class="input">
            @foreach(['bolt'=>'⚡ Rayo','tower'=>'🗼 Torre','cube'=>'📦 Subestación','sun'=>'☀️ Solar','wrench'=>'🔧 Herramienta','chart'=>'📊 Gráfico'] as $k=>$v)
                <option value="{{ $k }}" @selected(old('icon', $service->icon ?? 'bolt')===$k)>{{ $v }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">Orden</label>
        <input name="sort_order" type="number" min="0" class="input" value="{{ old('sort_order', $service->sort_order ?? 0) }}">
    </div>
</div>
<label class="flex items-center gap-2">
    <input type="checkbox" name="active" value="1" @checked(old('active', $service->active ?? true))
           class="rounded border-slate-300 text-brand-orange focus:ring-brand-orange">
    <span class="text-sm">Activo (visible en el sitio)</span>
</label>
