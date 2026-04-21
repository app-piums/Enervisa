@php($s = fn($k,$d='') => \App\Models\Setting::get($k,$d))
<section id="contacto" class="relative bg-brand-blue py-24 text-white">
    <div class="mx-auto max-w-7xl px-6">
        <p class="mb-2 text-center text-sm font-bold uppercase tracking-[0.3em] text-brand-orange">Contáctanos</p>
        <h2 class="mb-12 text-center text-4xl font-extrabold text-white md:text-5xl">Conversemos sobre tu Proyecto</h2>

        <div class="grid gap-10 lg:grid-cols-2">
            {{-- FORM --}}
            <div class="rounded-2xl bg-white p-8 text-slate-800 shadow-2xl">
                @if(session('success'))
                    <div class="mb-4 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <ul class="list-inside list-disc">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="label" for="name">Nombre *</label>
                            <input class="input" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div>
                            <label class="label" for="email">Correo *</label>
                            <input class="input" id="email" name="email" type="email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="label" for="phone">Teléfono</label>
                            <input class="input" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div>
                            <label class="label" for="subject">Asunto</label>
                            <input class="input" id="subject" name="subject" value="{{ old('subject') }}">
                        </div>
                    </div>
                    <div>
                        <label class="label" for="message">Mensaje *</label>
                        <textarea class="input" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full">Enviar Mensaje</button>
                </form>
            </div>

            {{-- INFO + MAPA --}}
            <div class="space-y-6">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl bg-white/10 p-5 backdrop-blur">
                        <div class="text-xs font-bold uppercase tracking-wider text-brand-orange">Correo</div>
                        <div class="mt-1 text-sm">{{ $s('contact_email') }}</div>
                    </div>
                    <div class="rounded-xl bg-white/10 p-5 backdrop-blur">
                        <div class="text-xs font-bold uppercase tracking-wider text-brand-orange">Teléfono</div>
                        <div class="mt-1 text-sm">{{ $s('contact_phone') }}</div>
                    </div>
                    <div class="rounded-xl bg-white/10 p-5 backdrop-blur">
                        <div class="text-xs font-bold uppercase tracking-wider text-brand-orange">Dirección</div>
                        <div class="mt-1 text-sm">{{ $s('contact_address') }}</div>
                    </div>
                    <div class="rounded-xl bg-white/10 p-5 backdrop-blur">
                        <div class="text-xs font-bold uppercase tracking-wider text-brand-orange">Horario</div>
                        <div class="mt-1 text-sm">{{ $s('contact_hours') }}</div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl shadow-2xl ring-4 ring-white/10">
                    @if($s('maps_embed_url'))
                        <iframe src="{{ $s('maps_embed_url') }}"
                                class="h-80 w-full"
                                style="border:0;"
                                allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        <div class="flex h-80 items-center justify-center bg-white/5 text-sm text-slate-300">
                            Ubicación próximamente disponible.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
