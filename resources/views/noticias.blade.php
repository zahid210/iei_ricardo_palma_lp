@extends('layouts.app')

@section('title', 'Noticias Institucionales | I.E.I. N° 31756 Ricardo Palma')
@section('meta_description', 'Entérate de las últimas novedades, eventos institucionales, logros deportivos y actividades de nuestra comunidad ricardina en Pasco.')

@section('content')
    <!-- BANNER INSTITUCIONAL -->
    <section class="institution-hero" style="--hero-bg: url('{{ asset('images/ricardino_aula.jpg') }}');">
        <div class="institution-overlay"></div>

        <div class="institution-content">
            <span class="institution-eyebrow">
                ACTUALIDAD Y COMUNICADOS
            </span>

            <h1>
                Noticias
                <span class="text-highlight">Institucionales</span>
            </h1>

            <p>
                Mantente informado sobre las actividades, logros institucionales y novedades de nuestra comunidad educativa.
            </p>
        </div>
    </section>

    <!-- SECCIÓN DE PRESENTACIÓN -->
    <section class="institution-intro">
        <div class="intro-content">

            <div class="intro-icon" aria-hidden="true">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="36"
                    height="36"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/>
                    <path d="M18 14h-8"/>
                    <path d="M15 18h-5"/>
                    <path d="M10 6h8v4h-8V6Z"/>
                </svg>
            </div>

            <p>
                Compartimos día a día el entusiasmo, la dedicación y los logros de nuestros estudiantes y docentes. Aquí encontrarás comunicados oficiales, proyectos pedagógicos, celebraciones y momentos destacados de la familia ricardina.
            </p>

        </div>
    </section>

    <!-- CUERPO DE NOTICIAS CON DISEÑO DE MOSAICO -->
    <section class="section-muted py-8 sm:py-12">
        <div class="news-section">

            <!-- TÍTULO DE LA SECCIÓN -->
            <div class="section-heading">
                <h2>Entérate sobre lo último</h2>
            </div>

            <!-- NOTICIAS DESTACADAS EN MOSAICO -->
            <div class="featured-news">

                @if($destacada)
                    <!-- NOTICIA PRINCIPAL -->
                    <a href="{{ route('noticias.show', $destacada->slug) }}" class="news-card news-main">
                        <img src="{{ asset($destacada->imagen) }}"
                             alt="{{ $destacada->titulo }}"
                             loading="eager">

                        <div class="news-shade"></div>

                        <div class="news-content">
                            <h3>{{ $destacada->titulo }}</h3>
                            <span class="news-date">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                                    <path d="M16 3v4M8 3v4M3 10h18"/>
                                </svg>
                                {{ $destacada->fecha_publicacion->translatedFormat('d \d\e F \d\e Y') }}
                            </span>
                        </div>
                    </a>
                @endif

                <!-- NOTICIAS SECUNDARIAS -->
                @foreach($secundarias as $item)
                    <a href="{{ route('noticias.show', $item->slug) }}" class="news-card news-small">
                        <img src="{{ asset($item->imagen) }}"
                             alt="{{ $item->titulo }}"
                             loading="lazy">

                        <div class="news-shade"></div>

                        <div class="news-content">
                            <h3>{{ Str::limit($item->titulo, 55) }}</h3>
                            <span class="news-date">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                                    <path d="M16 3v4M8 3v4M3 10h18"/>
                                </svg>
                                {{ $item->fecha_publicacion->translatedFormat('d \d\e F \d\e Y') }}
                            </span>
                        </div>
                    </a>
                @endforeach

            </div>

            <!-- PARTE INFERIOR: OTRAS NOTICIAS Y REDES SOCIALES -->
            <div class="news-bottom">

                <!-- OTRAS NOTICIAS -->
                <div class="other-news">
                    <div class="section-heading subsection-heading">
                        <h2>Otras noticias</h2>
                    </div>

                    <div class="other-news-list">
                        @forelse($otrasNoticias as $otra)
                            <a href="{{ route('noticias.show', $otra->slug) }}" class="news-card other-news-card">
                                <img src="{{ asset($otra->imagen) }}"
                                     alt="{{ $otra->titulo }}"
                                     loading="lazy">
                                <div class="news-shade"></div>

                                <div class="news-content">
                                    <h3>{{ Str::limit($otra->titulo, 45) }}</h3>
                                    <span class="news-date">
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <rect x="3" y="5" width="18" height="16" rx="2"/>
                                            <path d="M16 3v4M8 3v4M3 10h18"/>
                                        </svg>
                                        {{ $otra->fecha_publicacion->translatedFormat('d \d\e M \d\e Y') }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-neutral-500 font-sans italic">No hay más noticias registradas por el momento.</p>
                        @endforelse
                    </div>
                </div>

                <!-- REDES SOCIALES: PERFIL Y COMUNICACIÓN OFICIAL -->
                <aside class="social-sidebar">
                    <div class="section-heading subsection-heading">
                        <h2>Entérate más en nuestras redes sociales</h2>
                    </div>

                    <!-- TARJETA DE REDES SOCIALES -->
                    <section class="social-profile">
                        <div class="profile-header">
                            <img
                                src="{{ asset('images/logo_color.png') }}"
                                alt="Logo de la I.E.I. 31756 Ricardo Palma"
                                class="profile-logo"
                            >

                            <h2>I.E.I. 31756 Ricardo Palma</h2>
                            <p>Barrio La Esperanza, Chaupimarca</p>
                        </div>

                        <div class="profile-stats">
                            <div class="stat">
                                <strong>1000+</strong>
                                <span>SEGUIDORES</span>
                            </div>

                            <div class="stat">
                                <strong>500+</strong>
                                <span>PUBLICACIONES</span>
                            </div>
                        </div>

                        <a
                            href="https://www.facebook.com/ricardinosemprendeores"
                            class="facebook-button"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <span class="facebook-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="11" fill="#ffffff" />
                                    {{-- Trazo exacto centrado geométricamente --}}
                                    <path d="M13.2 12.2h1.8l.3-2.3h-2.1V8.5c0-.6.3-1.1 1.2-1.1h1V5.4c-.4 0-1.2-.1-2.1-.1-2.2 0-3.6 1.3-3.6 3.7v2.2H8v2.3h1.7V19h3.5v-6.8z" fill="#1877F2"/>
                                </svg>
                            </span>
                            Visitar Página
                        </a>
                    </section>

                    <!-- TARJETA DE COMUNICACIÓN OFICIAL -->
                    <section class="official-communication">
                        <h2>Comunicación Oficial</h2>

                        <p>
                            Todos los comunicados, avisos de reuniones y anuncios
                            importantes de la institución se canalizan formalmente
                            a través de nuestra página de Facebook. Síguenos para
                            estar al día.
                        </p>
                    </section>
                </aside>

            </div>

        </div>
    </section>
@endsection
