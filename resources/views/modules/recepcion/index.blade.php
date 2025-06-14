@extends('layouts.main')


@section('titulo', $titulo)

@section('contenido')
  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Recepciones de equipos</h1>

    </div>

    <section class="section">
    <div class="row">
      <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
        <h3 class="card-title">Administar reccepciones</h3>
        <p>En esta sección podrás registrar las recepciones de equipos de los clientes, para su posterior reparación
          o mantenimiento.</p>
        <button class="btn btn-primary"> <a href="{{route('recepciones.create')}}">Nueva recepción</a></button>
        <!-- Table with stripped rows -->
        <table class="table datatable">
          <thead>
          <tr>
            <th>ID</th>
            <th>N° Recepción</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Usuario</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($recepciones as $recepcion)
        <tr>
        <td>{{ $recepcion->id }}</td>
        <td>{{ $recepcion->numero_recepcion }}</td>
        <td>{{ $recepcion->fecha_recepcion }}</td>
        <td>{{ $recepcion->cliente->nombre ?? 'Sin cliente' }}</td>
        <td>{{ $recepcion->encargado->rol ?? 'Sin encargado' }}</td>
        <td>
        <span class="badge bg-{{ $recepcion->estado === 'recibido' ? 'primary' : 'secondary' }}">
          {{ ucfirst($recepcion->estado) }}
        </span>
        </td>
        <td>
        <a href="{{ route('recepciones.show', $recepcion->id) }}" class="btn btn-sm btn-info">Ver</a>
        <!-- Aquí puedes agregar editar/eliminar si lo deseas -->
        </td>
        </tr>
      @endforeach
          </tbody>
        </table>

        <div class="mt-3">
          {{ $recepciones->links() }}
        </div>
        <!-- End Table with stripped rows -->

        </div>
      </div>

      </div>
    </div>
    </section>

  </main>
@endsection

