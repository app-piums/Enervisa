<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso Administrativo — Enervisa</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gradient-to-br from-brand-blue-dark via-brand-blue to-brand-orange">
    <div class="flex min-h-screen items-center justify-center p-6">
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl">
            <div class="mb-8 flex flex-col items-center text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Enervisa"
                     class="mb-3 h-20 w-auto max-w-full" />
                <div class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">
                    Panel Administrativo
                </div>
            </div>

            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-800">
                    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="label" for="email">Correo Electrónico</label>
                    <input class="input" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div>
                    <label class="label" for="password">Contraseña</label>
                    <input class="input" id="password" name="password" type="password" required>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-orange focus:ring-brand-orange">
                    Recordarme
                </label>
                <button class="btn-primary w-full" type="submit">Iniciar Sesión</button>
            </form>

            <div class="mt-6 text-center text-xs text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-brand-orange">← Volver al sitio</a>
            </div>
        </div>
    </div>
</body>
</html>
