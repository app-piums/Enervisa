@extends('admin.layouts.admin')
@section('title', 'Editar Usuario')
@section('content')
<form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-2xl space-y-4 rounded-2xl bg-white p-6 shadow-md">
    @csrf @method('PUT')
    @include('admin.users._form', ['user' => $user])
    <div class="flex gap-2">
        <button class="btn-primary">Guardar</button>
        <a href="{{ route('admin.users.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
@endsection
