@if($errors->any())
    <div class="rounded-lg border border-red-300 bg-red-50 px-4 py-2 text-sm text-red-800">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
@endif
<div>
    <label class="label">Nombre *</label>
    <input name="name" class="input" value="{{ old('name', $user->name ?? '') }}" required>
</div>
<div>
    <label class="label">Correo *</label>
    <input name="email" type="email" class="input" value="{{ old('email', $user->email ?? '') }}" required>
</div>
<div>
    <label class="label">Rol *</label>
    <select name="role" class="input" required>
        @foreach(['admin'=>'Administrador','editor'=>'Editor'] as $k=>$v)
            <option value="{{ $k }}" @selected(old('role', $user->role ?? 'admin')===$k)>{{ $v }}</option>
        @endforeach
    </select>
</div>
<div>
    <label class="label">Contraseña {{ isset($user) ? '(dejar vacío para mantener)' : '*' }}</label>
    <input name="password" type="password" class="input" {{ isset($user) ? '' : 'required' }}>
</div>
<div>
    <label class="label">Confirmar Contraseña</label>
    <input name="password_confirmation" type="password" class="input">
</div>
