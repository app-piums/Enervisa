@extends('admin.layouts.admin')
@section('title', 'Editar Servicio')
@section('content')
<form method="POST" action="{{ route('admin.services.update', $service) }}" class="max-w-2xl space-y-4 rounded-2xl bg-white p-6 shadow-md">
    @csrf @method('PUT')
    @include('admin.services._form', ['service' => $service])
    <div class="flex gap-2">
        <button class="btn-primary">Guardar Cambios</button>
        <a href="{{ route('admin.services.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
@endsection
