@extends('admin.layouts.admin')
@section('title', 'Mensaje')
@section('content')
<div class="max-w-3xl space-y-4">
    <a href="{{ route('admin.messages.index') }}" class="text-sm text-slate-500 hover:text-brand-orange">← Volver a mensajes</a>
    <div class="rounded-2xl bg-white p-6 shadow-md">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <div class="text-lg font-bold text-brand-blue">{{ $message->name }}</div>
                <a href="mailto:{{ $message->email }}" class="text-sm text-slate-600 hover:text-brand-orange">{{ $message->email }}</a>
                @if($message->phone)
                    <div class="text-sm text-slate-500">📞 {{ $message->phone }}</div>
                @endif
            </div>
            <div class="text-xs text-slate-400">{{ $message->created_at->format('d/m/Y H:i') }}</div>
        </div>
        @if($message->subject)
            <div class="mb-3 text-sm font-semibold text-slate-600">Asunto: {{ $message->subject }}</div>
        @endif
        <div class="whitespace-pre-wrap rounded-lg bg-slate-50 p-4 text-sm text-slate-700">{{ $message->message }}</div>

        <div class="mt-6 flex justify-between">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn-primary !py-2 !text-sm">Responder por correo</a>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('¿Eliminar este mensaje?')">
                @csrf @method('DELETE')
                <button class="rounded-full border border-red-300 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
