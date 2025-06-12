@extends('layouts.main')
@include('shared.aside')
@section('contenido')
<main id="main" class="main">

    <div class="pagetitle d-flex justify-content-between">
        <h1>Detalle de Recepción N° {{ $recepcion->numero_recepcion }}</h1>
        <a href="{{ route('recepciones.pdf', ['recepcion' => $recepcion->id]) }}" class="btn btn-outline-secondary">📄 Descargar PDF</a>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información General</h5>
                <ul class="list-group mb-3">
                    <li class="list-group-item"><strong>Fecha Recepción:</strong> {{ $recepcion->fecha_recepcion->format('d/m/Y') }}</li>
                    <li class="list-group-item"><strong>Cliente:</strong> {{ $recepcion->cliente->nombre }}</li>
                    <li class="list-group-item"><strong>Encargado:</strong> {{ $recepcion->encargado->name }}</li>
                    <li class="list-group-item"><strong>Estado:</strong> {{ ucfirst($recepcion->estado) }}</li>
                    <li class="list-group-item"><strong>Observaciones:</strong> {{ $recepcion->observaciones }}</li>
                </ul>

                <h5 class="card-title">Equipos Recepcionados</h5>
                @foreach($recepcion->equipos as $equipo)
                    <div class="border p-3 mb-4 rounded shadow-sm">
                        <h6>Equipo ID: {{ $equipo->id }}</h6>
                        <p><strong>Descripción:</strong> {{ $equipo->descripcion ?? 'Sin descripción' }}</p>

                        @if ($equipo->fotos->count())
                            <div class="row">
                                @foreach ($equipo->fotos as $foto)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset($foto->ruta) }}" class="card-img-top" alt="Foto equipo">
                                            <div class="card-body p-2">
                                                <p class="card-text">{{ $foto->descripcion }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No hay fotos para este equipo.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</main>
@endsection