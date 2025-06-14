@extends('layouts.main')
@include('shared.aside')



@section('contenido')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Detalle de Recepción #{{ $recepcion->numero_recepcion }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('recepciones.index') }}">Recepciones</a></li>
                <li class="breadcrumb-item active">Detalle</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Datos de la Recepción -->
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary bg-opacity-10 py-2 border-bottom border-primary">
                                <h6 class="mb-0 text-primary">
                                    <i class="bi bi-clipboard-data me-2"></i>Datos de la Recepción
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p><strong>Número de Recepción:</strong> {{ $recepcion->numero_recepcion }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Fecha:</strong> {{ $recepcion->fecha_recepcion->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Hora:</strong> {{ $recepcion->hora_ingreso }}</p>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p><strong>Cliente:</strong> {{ $recepcion->cliente->nombre ?? 'No especificado' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Encargado:</strong> {{ $recepcion->encargado->name ?? 'No especificado' }}</p>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p><strong>Procedente:</strong> {{ $recepcion->procedente ?? 'No especificado' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Presupuesto Inicial:</strong> Bs. {{ number_format($recepcion->presupuesto_inicial, 2) }}</p>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p><strong>Registro Fotográfico:</strong> {{ $recepcion->registro_fotografico ? 'Sí' : 'No' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Estado:</strong> 
                                            <span class="badge bg-{{ $recepcion->estado === 'recibido' ? 'primary' : ($recepcion->estado === 'entregado' ? 'success' : 'secondary') }}">
                                                {{ ucfirst($recepcion->estado) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                @if($recepcion->fecha_limite_retiro)
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p><strong>Fecha Límite de Retiro:</strong> {{ $recepcion->fecha_limite_retiro->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($recepcion->estado === 'entregado')
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p><strong>Fecha de Entrega:</strong> {{ $recepcion->fecha_entrega->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Entregado con boleta:</strong> {{ $recepcion->entregado_con_boleta ? 'Sí' : 'No' }}</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <p><strong>Receptor de entrega:</strong> {{ $recepcion->nombre_receptor_entrega ?? 'No especificado' }}</p>
                                    </div>
                                </div>
                                @endif

                                <div class="mt-3">
                                    <p><strong>Observaciones Generales:</strong></p>
                                    <p>{{ $recepcion->observaciones ?? 'Ninguna' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Equipos -->
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary bg-opacity-10 py-2 border-bottom border-primary">
                                <h6 class="mb-0 text-primary">
                                    <i class="bi bi-pc-display me-2"></i>Equipo(s) Recepcionado(s)
                                </h6>
                            </div>
                            <div class="card-body">
                                @foreach($recepcion->equipos as $equipo)
                                    <div class="card mb-3 equipo-item border">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                            <h6 class="card-title mb-0">
                                                <i class="bi bi-pc-display-horizontal me-2"></i>
                                                {{ $equipo->nombre }}
                                            </h6>
                                            <span class="badge bg-info">{{ str_replace('_', ' ', ucfirst($equipo->tipo)) }}</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Número de Serie:</strong> {{ $equipo->serie ?? 'No especificado' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Marca/Modelo:</strong> {{ $equipo->marca ?? 'No especificado' }} / {{ $equipo->modelo ?? 'No especificado' }}</p>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <p><strong>Color:</strong> {{ $equipo->color ?? 'No especificado' }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p><strong>Voltaje:</strong> {{ $equipo->voltaje ?? 'No especificado' }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p><strong>RPM:</strong> {{ $equipo->rpm ?? 'No especificado' }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p><strong>Potencia:</strong> {{ $equipo->potencia ?? 'No especificado' }}</p>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <p><strong>Cable Positivo:</strong> {{ $equipo->cable_positivo ?? 'No especificado' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Cable Negativo:</strong> {{ $equipo->cable_negativo ?? 'No especificado' }}</p>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <p><strong>Estado al recibir:</strong> {{ $equipo->estado ?? 'No especificado' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Costo Estimado:</strong> Bs. {{ number_format($equipo->costo_estimado, 2) }}</p>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <p><strong>Partes Faltantes:</strong></p>
                                                    <p>{{ $equipo->partes_faltantes ?? 'Ninguna' }}</p>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <p><strong>Trabajo a Realizar:</strong></p>
                                                    <p>{{ $equipo->trabajo_realizar ?? 'No especificado' }}</p>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <p><strong>Observaciones:</strong></p>
                                                    <p>{{ $equipo->observaciones ?? 'Ninguna' }}</p>
                                                </div>
                                            </div>

                                            @if($equipo->fotos->count() > 0)
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <p><strong>Fotos del Equipo:</strong></p>
                                                        <div class="row">
                                                            @foreach($equipo->fotos as $foto)
                                                                <div class="col-md-3 mb-3">
                                                                    <a href="{{ Storage::url($foto->ruta) }}" data-lightbox="equipo-{{ $equipo->id }}" data-title="{{ $equipo->nombre }}">
                                                                        <img src="{{ asset('storage/' . $foto->ruta) }}" class="img-thumbnail">
                                                                    </a>
                                                                    @if($foto->descripcion)
                                                                        <p class="small text-muted mt-1">{{ $foto->descripcion }}</p>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('recepciones.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver
                            </a>
                            <div>
                                <a href="{{ route('recepciones.edit', $recepcion->id) }}" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-pencil me-2"></i>Editar
                                </a>
                                <button class="btn btn-primary" onclick="window.print()">
                                    <i class="bi bi-printer me-2"></i>Imprimir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('styles')
<!-- Lightbox CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<style>
    .card-header {
        background-color: #f8f9fa;
    }
    .equipo-item {
        border-left: 4px solid #0d6efd !important;
    }
    .badge {
        font-size: 0.85em;
    }
</style>
@endpush

@push('scripts')
<!-- Lightbox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endpush