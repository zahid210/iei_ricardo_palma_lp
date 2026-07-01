@extends('layouts.app')

@section('title', 'Contacto | I.E.I. 31756 Ricardo Palma')

@section('content')

    {{-- Cuerpo Principal --}}
    <section class="py-10 sm:py-16 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">

                {{-- COLUMNA IZQUIERDA: Formulario Institucional --}}
                <div class="lg:col-span-7">
                    <div class="bg-white p-6 shadow-sm border border-neutral-100/60">
                        <h2 class="font-mate text-lg font-bold text-neutral-800 uppercase tracking-wide">
                            <span class="mr-2 inline-block h-4 w-1 bg-ricardo-red align-middle"></span>
                            Envíanos un mensaje
                        </h2>
                        <p class="mt-1 font-literata text-xs text-neutral-500">
                            Completa tus datos y te responderemos a la brevedad posible.
                        </p>

                        <form action="#" method="POST" class="mt-6 space-y-5 font-system text-sm">
                            @csrf

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="nombre" class="block font-bold text-neutral-700 uppercase tracking-wider text-[11px]">
                                        Nombre del Padre o Apoderado
                                    </label>
                                    <input type="text" id="nombre" name="nombre" required
                                           class="mt-1.5 w-full bg-neutral-50 border border-neutral-200 px-3 py-2.5 text-neutral-800 focus:border-ricardo-teal focus:bg-white focus:outline-none transition-colors duration-150">
                                </div>

                                <div>
                                    <label for="telefono" class="block font-bold text-neutral-700 uppercase tracking-wider text-[11px]">
                                        Teléfono de Contacto
                                    </label>
                                    <input type="tel" id="telefono" name="telefono" required
                                           class="mt-1.5 w-full bg-neutral-50 border border-neutral-200 px-3 py-2.5 text-neutral-800 focus:border-ricardo-teal focus:bg-white focus:outline-none transition-colors duration-150">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="correo" class="block font-bold text-neutral-700 uppercase tracking-wider text-[11px]">
                                        Correo Electrónico
                                    </label>
                                    <input type="email" id="correo" name="correo" required
                                           class="mt-1.5 w-full bg-neutral-50 border border-neutral-200 px-3 py-2.5 text-neutral-800 focus:border-ricardo-teal focus:bg-white focus:outline-none transition-colors duration-150">
                                </div>

                                <div>
                                    <label for="nivel" class="block font-bold text-neutral-700 uppercase tracking-wider text-[11px]">
                                        Nivel
                                    </label>
                                    {{-- SOLUCIÓN AL SELECT (image_0b0470.png) --}}
                                    <div class="relative mt-1.5">
                                        <select id="nivel" name="nivel" required
                                                class="w-full appearance-none bg-neutral-50 border border-neutral-200 pl-3 pr-10 py-2.5 text-neutral-800 focus:border-ricardo-teal focus:bg-white focus:outline-none transition-colors duration-150 cursor-pointer">
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="Inicial">Inicial</option>
                                            <option value="Primaria">Primaria</option>
                                            <option value="Secundaria">Secundaria</option>
                                            <option value="todos">Consultas Generales</option>
                                        </select>
                                        {{-- Flecha estilizada con separación controlada (pr-3) --}}
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-500">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="mensaje" class="block font-bold text-neutral-700 uppercase tracking-wider text-[11px]">
                                    Mensaje o Consulta
                                </label>
                                <textarea id="mensaje" name="mensaje" rows="5" required
                                          class="mt-1.5 w-full bg-neutral-50 border border-neutral-200 px-3 py-2.5 text-neutral-800 focus:border-ricardo-teal focus:bg-white focus:outline-none transition-colors duration-150 resize-none"></textarea>
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                        class="inline-flex items-center justify-center bg-ricardo-teal px-6 py-3 font-system text-xs font-bold uppercase tracking-wider text-white transition-colors hover:bg-ricardo-teal-dark cursor-pointer">
                                    Enviar consulta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: Mapa Estático y Canales de Atención --}}
                <div class="lg:col-span-5 space-y-6">

                    {{-- Bloque de Ubicación con tu Mapa --}}
                    <div class="bg-white p-6 shadow-sm border border-neutral-100/60 text-left">
                        <h2 class="font-mate text-lg font-bold text-neutral-800 uppercase tracking-wide">
                            <span class="mr-2 inline-block h-4 w-1 bg-ricardo-teal align-middle"></span>
                            Nuestra Ubicación
                        </h2>
                        <p class="mt-2 font-system text-xs text-neutral-600 leading-relaxed">
                            Barrio La Esperanza, Chaupimarca - Pasco
                        </p>

                        {{-- Contenedor con aspecto controlado para evitar saltos de maquetación --}}
                        <div class="mt-4 inline-block w-full overflow-hidden rounded-sm bg-white p-1 shadow-sm text-left border border-neutral-100">
                            <div class="relative w-full overflow-hidden bg-[#e7ecef]">
                                <a href="https://maps.app.goo.gl/UFgLwdUeNxSo5gAa9" target="_blank" rel="noopener noreferrer"
                                   class="block h-full w-full group">
                                    <img
                                        src="https://maps.googleapis.com/maps/api/staticmap?center=-10.6852,-76.2592&zoom=16&size=450x224&scale=2&maptype=roadmap&markers=color:red%7C-10.6852,-76.2592&key=AIzaSyCUxQyRkTBGfV1WYm95ZmM-tzQ0nCAO2Es"
                                        alt="Mapa de ubicación exacta de la I.E.I. Ricardo Palma"
                                        class="h-full w-full object-cover transition-opacity duration-200 group-hover:opacity-90"
                                        loading="lazy"
                                    >
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/5 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                                        <span class="rounded bg-neutral-900/80 px-3 py-1.5 font-system text-[10px] font-medium text-white shadow-sm uppercase tracking-wider">
                                            Ver en Google Maps
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Canales Directos y Horarios --}}
                    <div class="bg-white p-6 shadow-sm border border-neutral-100/60 font-system">
                        <h2 class="font-mate text-base font-bold text-neutral-800 uppercase tracking-wide border-b border-neutral-50 pb-3">
                            Información de Atención
                        </h2>

                        <div class="mt-4 space-y-4 text-xs">
                            <div>
                                <p class="font-bold uppercase tracking-wider text-neutral-400 text-[10px]">Horario Escolar</p>
                                <p class="mt-1 font-literata text-sm text-neutral-700">Lunes a Viernes de 8:00 a.m. a 1:00 p.m.</p>
                            </div>

                            <div>
                                <p class="font-bold uppercase tracking-wider text-neutral-400 text-[10px]">Atención Telefónica</p>
                                <p class="mt-1 font-literata text-sm text-neutral-700">+51 921 896 330</p>
                            </div>

                            <div class="pt-2">
                                <a href="https://wa.me/51921896330" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex w-full items-center justify-center gap-2 bg-[#25D366] px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white transition-colors hover:bg-[#20ba56]">
                                    <img src="{{ asset('images/whatsapp.svg') }}" alt="" class="h-4 w-4 brightness-0 invert">
                                    Atención inmediata por WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
