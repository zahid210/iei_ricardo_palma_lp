@extends('layouts.app')

@section('title', $noticia->titulo . ' | I.E.I. N° 31756 Ricardo Palma')
@section('meta_description', Str::limit($noticia->extracto ?? $noticia->contenido, 155))

@section('content')
<div class="bg-neutral-50 py-8">
    <main class="article-page">

        <!-- COLUMNA PRINCIPAL -->
        <article class="article-main shadow-xs">

            <a href="{{ route('noticias') }}" class="back-link">
                <span>←</span> Volver a la lista de noticias
            </a>

            <h1 class="article-title">
                {{ $noticia->titulo }}
            </h1>

            <img
                class="article-image"
                src="{{ asset($noticia->imagen) }}"
                alt="{{ $noticia->titulo }}"
            >

            <!-- DATOS DE PUBLICACIÓN -->
            <div class="article-meta">

                <div class="meta-item">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M4 21v-2a8 8 0 0 1 16 0v2"/>
                    </svg>
                    <span>{{ $noticia->autor }}</span>
                </div>

                <div class="meta-item">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                        <path d="M16 3v4M8 3v4M3 10h18"/>
                    </svg>
                    <span>{{ $noticia->fecha_publicacion->translatedFormat('d \d\e F \d\e Y') }}</span>
                </div>

            </div>

            <!-- CONTENIDO DE LA NOTICIA -->
            <div class="article-body">
                <p>
                    {{ $noticia->contenido }}
                </p>
            </div>

        </article>

        <!-- BARRA LATERAL -->
        <aside class="article-sidebar">

            <!-- REDES SOCIALES: PERFIL Y COMUNICACIÓN OFICIAL -->
            <section class="sidebar-social">
                <h2 class="sidebar-title">
                    Síguenos en redes sociales
                </h2>

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
            </section>

            <!-- NOTICIA ANTERIOR -->
            @if($anterior)
                <section class="previous-news shadow-xs">
                    <a href="{{ route('noticias.show', $anterior->slug) }}" class="previous-label">
                        ‹ Anterior
                    </a>

                    <p>
                        <a href="{{ route('noticias.show', $anterior->slug) }}">
                            {{ $anterior->titulo }}
                        </a>
                    </p>
                </section>
            @endif

            <!-- OTRAS NOTICIAS -->
            @if($relacionadas->isNotEmpty())
                <section class="related-news shadow-xs">
                    <h2>Otras noticias</h2>

                    @foreach($relacionadas as $rel)
                        <a href="{{ route('noticias.show', $rel->slug) }}" class="related-card">
                            <img src="{{ asset($rel->imagen) }}" alt="{{ $rel->titulo }}">
                            <span>
                                {{ $rel->titulo }}
                            </span>
                        </a>
                    @endforeach

                </section>
            @endif

        </aside>

    </main>
</div>
@endsection
