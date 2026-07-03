@extends('layouts.app')

@section('title', 'Contacto | I.E.I. N° 31756 Ricardo Palma')

@section('content')

    {{-- Cuerpo Principal --}}
    <section class="py-10 sm:py-16 bg-neutral-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 items-start">

                {{-- COLUMNA IZQUIERDA: Formulario Institucional --}}
                <div class="lg:col-span-7 opacity-0 translate-y-8 transition-all duration-700 ease-out" data-reveal>
                    <div class="bg-white p-6 shadow-sm border border-neutral-100/60 rounded-xs">
                        <h2 class="font-mate text-lg font-bold text-neutral-800 uppercase tracking-wide">
                            <span class="mr-2 inline-block h-4 w-[3px] bg-ricardo-red align-middle rounded-full"></span>
                            Envíanos un mensaje
                        </h2>
                        <p class="mt-1 font-literata text-xs text-neutral-500">
                            Completa tus datos y te responderemos a la brevedad posible.
                        </p>

                        <form action="{{route('contacto.store')}}" method="POST" class="mt-6 space-y-5 font-system text-sm" novalidate>
                            @csrf

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="nombre" class="block font-bold text-neutral-700 uppercase tracking-wider text-[11px]">
                                        Nombre del Padre o Apoderado
                                    </label>
                                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                                           class="mt-1.5 w-full bg-neutral-50 border @error('nombre') border-red-500 @else border-neutral-200 @enderror px-3 py-2.5 text-neutral-800 focus:border-ricardo-teal focus:ring-1 focus:ring-ricardo-teal focus:bg-white focus:outline-none transition-all duration-150 rounded-sm">
                                    @error('nombre')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="telefono" class="block font-bold text-neutral-700 uppercase tracking-wider text-[11px]">
                                        Teléfono de Contacto
                                    </label>
                                    <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" required
                                           class="mt-1.5 w-full bg-neutral-50 border @error('telefono') border-red-500 @else border-neutral-200 @enderror px-3 py-2.5 text-neutral-800 focus:border-ricardo-teal focus:ring-1 focus:ring-ricardo-teal focus:bg-white focus:outline-none transition-all duration-150 rounded-sm">
                                    @error('telefono')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="correo" class="block font-bold text-neutral-700 uppercase tracking-wider text-[11px]">
                                        Correo Electrónico
                                    </label>
                                    <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required
                                           class="mt-1.5 w-full bg-neutral-50 border @error('correo') border-red-500 @else border-neutral-200 @enderror px-3 py-2.5 text-neutral-800 focus:border-ricardo-teal focus:ring-1 focus:ring-ricardo-teal focus:bg-white focus:outline-none transition-all duration-150 rounded-sm">
                                    @error('correo')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nivel" class="block font-bold text-neutral-700 uppercase tracking-wider text-[11px]">
                                        Nivel Académico
                                    </label>
                                    <div class="relative mt-1.5">
                                        <select id="nivel" name="nivel" required
                                                class="w-full appearance-none bg-neutral-50 border @error('nivel') border-red-500 @else border-neutral-200 @enderror pl-3 pr-10 py-2.5 text-neutral-800 focus:border-ricardo-teal focus:ring-1 focus:ring-ricardo-teal focus:bg-white focus:outline-none transition-all duration-150 cursor-pointer rounded-sm">
                                            <option value="" disabled {{ old('nivel') ? '' : 'selected' }}>Selecciona una opción</option>
                                            <option value="Inicial" {{ old('nivel') == 'Inicial' ? 'selected' : '' }}>Inicial</option>
                                            <option value="Primaria" {{ old('nivel') == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                                            <option value="Secundaria" {{ old('nivel') == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                                            <option value="todos" {{ old('nivel') == 'todos' ? 'selected' : '' }}>Consultas Generales</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-500">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('nivel')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="mensaje" class="block font-bold text-neutral-700 uppercase tracking-wider text-[11px]">
                                    Mensaje o Consulta
                                </label>
                                <div class="relative mt-1.5">
                                    <textarea id="mensaje" name="mensaje" rows="5" maxlength="255" required
                                              class="w-full bg-neutral-50 border @error('mensaje') border-red-500 @else border-neutral-200 @enderror pl-3 pr-3 pt-2.5 pb-8 text-neutral-800 focus:border-ricardo-teal focus:ring-1 focus:ring-ricardo-teal focus:bg-white focus:outline-none transition-all duration-150 resize-none rounded-sm">{{ old('mensaje') }}</textarea>
                                    <div id="mensaje-counter" class="absolute bottom-2 right-3 font-system text-[10px] font-bold text-neutral-400 select-none pointer-events-none tracking-wider transition-colors duration-150">
                                        0/255
                                    </div>
                                </div>
                                @error('mensaje')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                        class="inline-flex items-center justify-center bg-ricardo-teal px-6 py-3 font-system text-xs font-bold uppercase tracking-wider text-white transition-all hover:bg-ricardo-teal-dark shadow-xs cursor-pointer rounded-sm">
                                    Enviar consulta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: Mapa Estático y Canales de Atención --}}
                <div class="lg:col-span-5 space-y-6 opacity-0 translate-y-8 transition-all duration-700 delay-200 ease-out" data-reveal>

                    {{-- Bloque de Ubicación --}}
                    <div class="bg-white p-6 shadow-sm border border-neutral-100/60 text-left rounded-xs">
                        <h2 class="font-mate text-lg font-bold text-neutral-800 uppercase tracking-wide">
                            <span class="mr-2 inline-block h-4 w-[3px] bg-ricardo-teal align-middle rounded-full"></span>
                            Nuestra Ubicación
                        </h2>
                        <p class="mt-2 font-system text-xs text-neutral-600 leading-relaxed">
                            Barrio La Esperanza, Chaupimarca - Pasco
                        </p>

                        {{-- Contenedor de mapa protegido --}}
                        <div class="mt-4 inline-block w-full overflow-hidden rounded-sm bg-white p-1 shadow-xs text-left border border-neutral-100">
                            <div class="relative w-full overflow-hidden bg-[#e7ecef] aspect-[450/224]">
                                <a href="https://maps.app.goo.gl/UFgLwdUeNxSo5gAa9" target="_blank"
                                   rel="noopener noreferrer"
                                   class="block h-full w-full group">
                                    <img
                                        src="https://maps.googleapis.com/maps/api/staticmap?center=-10.6852,-76.2592&zoom=16&size=450x224&scale=2&maptype=roadmap&markers=color:red%7C-10.6852,-76.2592&key={{ config('services.google.maps_key', '') }}"
                                        alt="Mapa de ubicación exacta de la I.E.I. Ricardo Palma"
                                        class="h-full w-full object-cover transition-opacity duration-200 group-hover:opacity-90"
                                        loading="lazy"
                                    >
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/5 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                                        <span class="rounded bg-neutral-900/80 px-3 py-1.5 font-system text-[10px] font-bold text-white shadow-sm uppercase tracking-wider">
                                            Ver en Google Maps
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Canales Directos y Horarios --}}
                    <div class="bg-white p-6 shadow-sm border border-neutral-100/60 font-system rounded-xs">
                        <h2 class="font-mate text-xs font-bold text-neutral-800 uppercase tracking-wider border-b border-neutral-100 pb-3">
                            Información de Atención
                        </h2>

                        <div class="mt-4 space-y-4 text-xs">
                            <div>
                                <p class="font-bold uppercase tracking-wider text-neutral-400 text-[9px]">Horario Escolar</p>
                                <p class="mt-1 font-literata text-sm text-neutral-700">Lunes a Viernes de 8:00 a.m. a 1:00 p.m.</p>
                            </div>

                            <div>
                                <p class="font-bold uppercase tracking-wider text-neutral-400 text-[9px]">Atención Telefónica</p>
                                <p class="mt-1 font-literata text-sm text-neutral-700">+51 921 896 330</p>
                            </div>

                            <div class="pt-2">
                                <a href="https://wa.me/51921896330" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex w-full items-center justify-center gap-2 bg-[#25D366] px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white transition-all hover:bg-[#20ba56] shadow-xs rounded-sm">
                                    <img src="{{ asset('images/whatsapp.svg') }}" alt=""
                                         class="h-4 w-4 brightness-0 invert">
                                    Atención inmediata por WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- Notificación Flotante (Toast) --}}
    @if (session('success'))
        <div id="toast-success" class="fixed bottom-6 right-6 z-50 flex items-center w-full max-w-xs p-4 space-x-3 text-neutral-600 bg-white border border-neutral-100 rounded-sm shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-500 opacity-100 translate-y-0" role="alert">
            {{-- Icono SVG Check --}}
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-50 rounded-full">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
            </div>

            {{-- Mensaje --}}
            <div class="ms-3 text-sm font-system font-medium">
                {{ session('success') }}
            </div>
        </div>
    @endif
@endsection
