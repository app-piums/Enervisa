@extends('admin.layouts.admin')
@section('title', 'Usuarios')
@section('content')
<div class="mb-4 flex justify-between">
    <p class="text-sm text-slate-500">Gestiona los usuarios que pueden acceder al panel.</p>
    <a href="{{ route('admin.users.create') }}" class="btn-primary !py-2 !text-sm">+ Nuevo Usuario</a>
</div>
<div class="overflow-hidden rounded-2xl bg-white shadow-md">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
            <tr><th class="p-3">Nombre</th><th class="p-3">Correo</th><th class="p-3">Rol</th><th class="p-3 text-right">Acciones</th></tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-t">
                    <td class="p-3 font-semibold">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3"><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs">{{ $user->role }}</span></td>
                    <td class="p-3 text-right">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-sm font-semibold text-brand-orange hover:underline">Editar</a>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('¿Eliminar este usuario?')">
                                @csrf @method('DELETE')
                                <button class="ml-2 text-sm font-semibold text-red-600 hover:underline">Eliminar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
