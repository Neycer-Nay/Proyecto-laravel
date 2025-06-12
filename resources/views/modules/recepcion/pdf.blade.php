<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recepción N° {{ $recepcion->numero_recepcion }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        .section { margin-bottom: 20px; }
        img { max-width: 100px; height: auto; margin: 5px; }
    </style>
</head>
<body>
    <div class="title">Recepción N° {{ $recepcion->numero_recepcion }}</div>

    <div class="section">
        <strong>Fecha:</strong> {{ $recepcion->fecha_recepcion->format('d/m/Y') }}<br>
        <strong>Cliente:</strong> {{ $recepcion->cliente->nombre }}<br>
        <strong>Encargado:</strong> {{ $recepcion->encargado->name }}<br>
        <strong>Estado:</strong> {{ ucfirst($recepcion->estado) }}<br>
        <strong>Observaciones:</strong> {{ $recepcion->observaciones }}<br>
    </div>

    <div class="section">
        <strong>Equipos:</strong><br>
        @foreach($recepcion->equipos as $equipo)
            <p><strong>ID Equipo:</strong> {{ $equipo->id }} <br>
            <strong>Descripción:</strong> {{ $equipo->descripcion }}</p>

            @if ($equipo->fotos->count())
                @foreach ($equipo->fotos as $foto)
                    <div>
                        <img src="{{ public_path($foto->ruta) }}" alt="Foto">
                        <p>{{ $foto->descripcion }}</p>
                    </div>
                @endforeach
            @endif
        @endforeach
    </div>
</body>
</html>
