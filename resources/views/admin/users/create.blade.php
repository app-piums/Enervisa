@extends('admin.layouts.admin')
@section('title', 'Nuevo Usuario')
@section('content')
<form method="POST" action="{{ route('admin.users.store') }}" class="max-w-2xl space-y-4 rounded-2xl bg-white p-6 shadow-md">
    @csrf
    @include('admin.users._form')
    <div class="flex gap-2">
        <button class="btn-primary">Crear</button>
        <a href="{{ route('admin.users.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
@endsection
