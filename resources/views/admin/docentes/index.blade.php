@extends('admin.layout')

@section('title', 'Sección Docentes')

@push('styles')
<style>
    .info-card {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        padding: 32px;
        max-width: 900px;
    }

    .docentes-preview-header {
        display: flex;
        gap: 20px;
        align-items: center;
        padding-bottom: 24px;
        margin-bottom: 24px;
        border-bottom: 1px solid var(--border-color);
    }

    .docentes-img {
        width: 140px;
        height: 100px;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }

    .ejes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }

    .eje-item {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        padding: 16px;
        border-left: 3px solid var(--brand-green);
    }

    .eje-item h4 {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--text-primary);
    }

    .eje-item p {
        font-size: 12px;
        color: var(--text-secondary);
        line-height: 1.4;
    }
</style>
@endpush

@section('content')
    <div class="section-header">
        <div class="section-title">
            <h2>Plana Docente</h2>
            <p>Supervisión del equipo pedagógico y ejes institucionales activos.</p>
        </div>
        <a href="{{ route('docentes') }}" target="_blank" class="btn-outline">
            Ver página pública de docentes →
        </a>
    </div>

    <div class="info-card">
        <div class="docentes-preview-header">
            <img src="{{ asset('images/plana_docente.jpg') }}" alt="Plana docente" class="docentes-img">
            <div>
                <h3 style="font-size: 17px; font-weight: 700; color: var(--text-primary); margin-bottom: 6px;">
                    Cuerpo Académico y Pedagógico
                </h3>
                <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.5;">
                    La plana docente de la I.E.I. N° 31756 Ricardo Palma cuenta con maestros en los niveles Primaria y Secundaria, enfocados en innovación formativa, inclusión y valores ricardinos.
                </p>
            </div>
        </div>

        <h3 style="font-size: 15px; font-weight: 600; color: var(--text-primary);">
            Ejes Pedagógicos Institucionales
        </h3>

        <div class="ejes-grid">
            <div class="eje-item">
                <h4>Comprensión lectora</h4>
                <p>Desarrollo de habilidades comunicativas y análisis crítico de textos.</p>
            </div>
            <div class="eje-item">
                <h4>Resolución de problemas</h4>
                <p>Razonamiento lógico-matemático y aplicación en situaciones cotidianas.</p>
            </div>
            <div class="eje-item">
                <h4>Pensamiento crítico</h4>
                <p>Estímulo a la indagación, autonomía reflexiva y creatividad.</p>
            </div>
            <div class="eje-item">
                <h4>Convivencia democrática</h4>
                <p>Ambiente escolar participativo basado en empatía, respeto y civismo.</p>
            </div>
            <div class="eje-item">
                <h4>Formación integral</h4>
                <p>Educación física, artes, ciencias y sólidos valores éticos.</p>
            </div>
            <div class="eje-item">
                <h4>Uso de tecnología</h4>
                <p>Aprovechamiento pedagógico responsable de recursos digitales.</p>
            </div>
        </div>
    </div>
@endsection
