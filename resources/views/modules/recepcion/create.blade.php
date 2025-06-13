@extends('layouts.main')
@include('shared.aside')
@section('contenido')
<div class="container-lg" style="padding-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-9 col-lg-10 col-md-12">
            <div class="card shadow-sm border-0 ">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4 text-primary">
                        <i class="bi bi-clipboard2-plus me-2"></i>Nueva Recepción de Equipo
                    </h4>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form id="recepcionForm" method="POST" action="{{ route('recepciones.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Sección de Cliente -->
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary bg-opacity-10 py-2 border-bottom border-primary">
                                <h6 class="mb-0 text-primary">
                                    <i class="bi bi-person-badge me-2"></i>Datos del Cliente
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label for="cliente_id" class="form-label">Seleccionar Cliente Existente <span class="text-danger">*</span></label>
                                        <select class="form-select" id="cliente_id" name="cliente_id" required>
                                            <option value="">Seleccione un cliente...</option>
                                            @foreach($clientes as $cliente)
                                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                                    {{ $cliente->nombre }} - {{ $cliente->documento }} ({{ $cliente->telefono }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Por favor seleccione un cliente</div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">
                                            <i class="bi bi-plus-circle me-2"></i>Nuevo Cliente
                                        </button>
                                    </div>
                                </div>
                                
                                @if(old('cliente_id'))
                                    @php
                                        $clienteSeleccionado = $clientes->firstWhere('id', old('cliente_id'));
                                    @endphp
                                    @if($clienteSeleccionado)
                                        <div class="row mt-3 g-2" id="clienteInfo">
                                            <div class="col-md-3">
                                                <div class="bg-light p-2 rounded">
                                                    <small class="text-muted d-block">Documento</small>
                                                    <span id="clienteDocumento" class="fw-bold clienteM">{{ $clienteSeleccionado->documento }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="bg-light p-2 rounded">
                                                    <small class="text-muted d-block">Teléfono</small>
                                                    <span id="clienteTelefono">{{ $clienteSeleccionado->telefono }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="bg-light p-2 rounded">
                                                    <small class="text-muted d-block">Email</small>
                                                    <span id="clienteEmail">{{ $clienteSeleccionado->email }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="bg-light p-2 rounded">
                                                    <small class="text-muted d-block">Dirección</small>
                                                    <span id="clienteDireccion">{{ $clienteSeleccionado->direccion }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        
                        <!-- Datos de la Recepción -->
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary bg-opacity-10 py-2 border-bottom border-primary">
                                <h6 class="mb-0 text-primary">
                                    <i class="bi bi-clipboard-data me-2"></i>Datos de la Recepción
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="numero_recepcion" class="form-label">Número de Recepción <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="numero_recepcion" name="numero_recepcion" value="{{ old('numero_recepcion') }}" required>
                                        <div class="invalid-feedback">Ingrese el número de recepción</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="fecha_recepcion" class="form-label">Fecha <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="fecha_recepcion" name="fecha_recepcion" value="{{ old('fecha_recepcion', date('Y-m-d')) }}" required>
                                        <div class="invalid-feedback">Seleccione la fecha</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="hora_ingreso" class="form-label">Hora <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="hora_ingreso" name="hora_ingreso" value="{{ old('hora_ingreso', date('H:i')) }}" required>
                                        <div class="invalid-feedback">Ingrese la hora</div>
                                    </div>
                                </div>
                                
                                <div class="row g-3 mt-1">
                                    <div class="col-md-6">
                                        <label for="encargado_id" class="form-label">Encargado <span class="text-danger">*</span></label>
                                        <select class="form-select" id="encargado_id" name="encargado_id" required>
                                            <option value="">Seleccione...</option>
                                            @foreach($usuarios as $usuario)
                                                <option value="{{ $usuario->id }}" {{ old('encargado_id') == $usuario->id ? 'selected' : '' }}>{{ $usuario->rol }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Seleccione un encargado</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="procedente" class="form-label">Procedente</label>
                                        <input type="text" class="form-control" id="procedente" name="procedente" value="{{ old('procedente') }}">
                                    </div>
                                </div>
                                
                                <div class="row g-3 mt-1">
                                    <div class="col-md-6">
                                        <label for="presupuesto_inicial" class="form-label">Presupuesto Inicial (Bs)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Bs.</span>
                                            <input type="number" step="0.01" class="form-control" id="presupuesto_inicial" name="presupuesto_inicial" value="{{ old('presupuesto_inicial') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="registro_fotografico" name="registro_fotografico" value="1" {{ old('registro_fotografico') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="registro_fotografico">
                                                Requiere registro fotográfico
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <label for="observaciones" class="form-label">Observaciones Generales</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="2">{{ old('observaciones') }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sección de Equipos -->
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary bg-opacity-10 py-2 border-bottom border-primary d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 text-primary">
                                    <i class="bi bi-pc-display me-2"></i>Equipo(s) a Recepcionar
                                </h6>
                                <button type="button" class="btn btn-sm btn-primary" id="addEquipo">
                                    <i class="bi bi-plus-lg me-1"></i>Agregar Equipo
                                </button>
                            </div>
                            <div class="card-body" id="equiposContainer">
                                @if(old('equipos', []))
                                    @foreach(old('equipos') as $index => $equipo)
                                        <div class="card mb-3 equipo-item border">
                                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                                <h6 class="card-title mb-0">
                                                    <i class="bi bi-pc-display-horizontal me-2"></i>
                                                    Equipo #{{ $index + 1 }}
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-equipo">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nombre del Equipo <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="equipos[{{ $index }}][nombre]" value="{{ $equipo['nombre'] ?? '' }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Número de Serie</label>
                                                        <input type="text" class="form-control" name="equipos[{{ $index }}][serie]" value="{{ $equipo['serie'] ?? '' }}">
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <label class="form-label">Tipo de Equipo <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="equipos[{{ $index }}][tipo]" required>
                                                            <option value="">Seleccione...</option>
                                                            <option value="MOTOR_ELECTRICO" {{ isset($equipo['tipo']) && $equipo['tipo'] == 'MOTOR_ELECTRICO' ? 'selected' : '' }}>Motor Eléctrico</option>
                                                            <option value="MAQUINA_SOLDADORA" {{ isset($equipo['tipo']) && $equipo['tipo'] == 'MAQUINA_SOLDADORA' ? 'selected' : '' }}>Máquina Soldadora</option>
                                                            <option value="GENERADOR_DINAMO" {{ isset($equipo['tipo']) && $equipo['tipo'] == 'GENERADOR_DINAMO' ? 'selected' : '' }}>Generador/Dinamo</option>
                                                            <option value="OTROS" {{ isset($equipo['tipo']) && $equipo['tipo'] == 'OTROS' ? 'selected' : '' }}>Otros</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Marca</label>
                                                        <input type="text" class="form-control" name="equipos[{{ $index }}][marca]" value="{{ $equipo['marca'] ?? '' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Modelo</label>
                                                        <input type="text" class="form-control" name="equipos[{{ $index }}][modelo]" value="{{ $equipo['modelo'] ?? '' }}">
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <label class="form-label">Color</label>
                                                        <input type="text" class="form-control" name="equipos[{{ $index }}][color]" value="{{ $equipo['color'] ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Voltaje</label>
                                                        <input type="text" class="form-control" name="equipos[{{ $index }}][voltaje]" value="{{ $equipo['voltaje'] ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">RPM</label>
                                                        <input type="text" class="form-control" name="equipos[{{ $index }}][rpm]" value="{{ $equipo['rpm'] ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Potencia</label>
                                                        <input type="text" class="form-control" name="equipos[{{ $index }}][potencia]" value="{{ $equipo['potencia'] ?? '' }}">
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label class="form-label">Estado al recibir</label>
                                                        <input type="text" class="form-control" name="equipos[{{ $index }}][estado]" value="{{ $equipo['estado'] ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Costo Estimado (Bs)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Bs.</span>
                                                            <input type="number" step="0.01" class="form-control" name="equipos[{{ $index }}][costo_estimado]" value="{{ $equipo['costo_estimado'] ?? '' }}">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <label class="form-label">Partes Faltantes</label>
                                                        <textarea class="form-control" name="equipos[{{ $index }}][partes_faltantes]" rows="2">{{ $equipo['partes_faltantes'] ?? '' }}</textarea>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <label class="form-label">Trabajo a Realizar</label>
                                                        <textarea class="form-control" name="equipos[{{ $index }}][trabajo_realizar]" rows="2">{{ $equipo['trabajo_realizar'] ?? '' }}</textarea>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <label class="form-label">Observaciones</label>
                                                        <textarea class="form-control" name="equipos[{{ $index }}][observaciones]" rows="2">{{ $equipo['observaciones'] ?? '' }}</textarea>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <label class="form-label">Fotos del Equipo</label>
                                                        <input type="file" class="form-control" name="equipos[{{ $index }}][fotos][]" multiple accept="image/jpeg,image/png,image/jpg,image/gif">
                                                        <div class="form-text">Puede seleccionar hasta 5 fotos (JPEG, PNG, JPG, GIF) - Máx. 8MB cada una</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('recepciones.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-2"></i>Guardar Recepción
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nuevo cliente -->
<div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-labelledby="nuevoClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="nuevoClienteModalLabel">
                    <i class="bi bi-person-plus me-2"></i>Registrar Nuevo Cliente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('clientes.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre/Razón Social <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo <span class="text-danger">*</span></label>
                            <select class="form-select" name="tipo" required>
                                <option value="Persona">Persona</option>
                                <option value="Empresa">Empresa</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                            <select class="form-select" name="tipo_documento" required>
                                <option value="CI">Carnet de Identidad</option>
                                <option value="NIT">NIT</option>
                                <option value="Pasaporte">Pasaporte</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Número de Documento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="documento" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="telefono" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ciudad</label>
                            <input type="text" class="form-control" name="ciudad" value="Santa Cruz">
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Dirección</label>
                            <textarea class="form-control" name="direccion" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Plantilla para nuevos equipos (hidden) -->
<div id="equipoTemplate" class="d-none">
    <div class="card mb-3 equipo-item border">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
            <h6 class="card-title mb-0">
                <i class="bi bi-pc-display-horizontal me-2"></i>
                Equipo #<span class="equipo-count">1</span>
            </h6>
            <button type="button" class="btn btn-sm btn-outline-danger remove-equipo">
                <i class="bi bi-trash"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre del Equipo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][nombre]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Número de Serie</label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][serie]">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Tipo de Equipo <span class="text-danger">*</span></label>
                    <select class="form-select" name="equipos[__INDEX__][tipo]" required>
                        <option value="">Seleccione...</option>
                        <option value="MOTOR_ELECTRICO">Motor Eléctrico</option>
                        <option value="MAQUINA_SOLDADORA">Máquina Soldadora</option>
                        <option value="GENERADOR_DINAMO">Generador/Dinamo</option>
                        <option value="OTROS">Otros</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Marca</label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][marca]">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Modelo</label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][modelo]">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Color</label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][color]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Voltaje</label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][voltaje]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RPM</label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][rpm]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Potencia</label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][potencia]">
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Estado al recibir</label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][estado]">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Costo Estimado (Bs)</label>
                    <div class="input-group">
                        <span class="input-group-text">Bs.</span>
                        <input type="number" step="0.01" class="form-control" name="equipos[__INDEX__][costo_estimado]">
                    </div>
                </div>
                
                <div class="col-md-12">
                    <label class="form-label">Partes Faltantes</label>
                    <textarea class="form-control" name="equipos[__INDEX__][partes_faltantes]" rows="2"></textarea>
                </div>
                
                <div class="col-md-12">
                    <label class="form-label">Trabajo a Realizar</label>
                    <textarea class="form-control" name="equipos[__INDEX__][trabajo_realizar]" rows="2"></textarea>
                </div>
                
                <div class="col-md-12">
                    <label class="form-label">Observaciones</label>
                    <textarea class="form-control" name="equipos[__INDEX__][observaciones]" rows="2"></textarea>
                </div>
                
                <div class="col-md-12">
                    <label class="form-label">Fotos del Equipo</label>
                    <input type="file" class="form-control" name="equipos[__INDEX__][fotos][]" multiple accept="image/jpeg,image/png,image/jpg,image/gif">
                    <div class="form-text">Puede seleccionar hasta 5 fotos (JPEG, PNG, JPG, GIF) - Máx. 8MB cada una</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Estilos personalizados */
    .container-lg {
        max-width: 1200px;
    }

    .clienteM {
        display: block !important;
    }

    .card {
        border-radius: 0.5rem;
    }
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    .form-control, .form-select {
        border-radius: 0.375rem;
    }
    .equipo-item {
        transition: all 0.2s ease;
    }
    .equipo-item:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    @media (max-width: 768px) {
        .container-lg {
            padding-left: 15px;
            padding-right: 15px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Mostrar info del cliente seleccionado al cargar si hay un cliente seleccionado
    if($('#cliente_id').val()) {
        $('#clienteInfo').show();
    }
    
    // Gestión dinámica de equipos
    let equipoCount = {{ count(old('equipos', [])) }};
    
    // Función para reindexar todos los equipos
    function reindexEquipos() {
        $('.equipo-item').each(function(index) {
            $(this).find('.equipo-count').text(index + 1);
            
            // Actualizar todos los names de los inputs
            $(this).find('[name^="equipos["]').each(function() {
                const currentName = $(this).attr('name');
                const newName = currentName.replace(/equipos\[\d+\]/, `equipos[${index}]`);
                $(this).attr('name', newName);
            });
        });
        equipoCount = $('.equipo-item').length;
    }

    // Agregar nuevo equipo
    $('#addEquipo').click(function() {
        const newEquipo = $($('#equipoTemplate').html().replace(/__INDEX__/g, equipoCount));
        $('#equiposContainer').append(newEquipo);
        reindexEquipos();
        
        // Animación para destacar el nuevo equipo
        $('.equipo-item').last().hide().fadeIn(300);
    });

    // Eliminar equipo
    $(document).on('click', '.remove-equipo', function() {
        $(this).closest('.equipo-item').fadeOut(300, function() {
            $(this).remove();
            reindexEquipos();
        });
    });
    
    // Configurar fecha y hora actual por defecto si no hay valor previo
    if(!$('#fecha_recepcion').val()) {
        const now = new Date();
        $('#fecha_recepcion').val(now.toISOString().split('T')[0]);
        $('#hora_ingreso').val(now.toTimeString().substring(0, 5));
    }
    
    // Validación del formulario
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    
                    // Validar campos requeridos de equipos
                    let hasErrors = false;
                    $('.equipo-item:visible').each(function(index) {
                        const nombre = $(this).find('[name^="equipos["][name$="[nombre]"]').val();
                        const tipo = $(this).find('[name^="equipos["][name$="[tipo]"]').val();
                        
                        if (!nombre || !tipo) {
                            $(this).find('[name^="equipos["][name$="[nombre]"]').addClass('is-invalid');
                            $(this).find('[name^="equipos["][name$="[tipo]"]').addClass('is-invalid');
                            hasErrors = true;
                        }
                    });

                    if (hasErrors) {
                        toastr.error('Por favor complete todos los campos requeridos en los equipos');
                    }
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
});
@if(Session::has('toastr'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    toastr.{{ session('toastr.type') }}(
        '{{ session('toastr.message') }}',
        '{{ session('toastr.title') }}',
        { timeOut: 5000 }
    );
});
</script>

// Tu código JavaScript existente...

@if(session('selectedCliente'))
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar automáticamente el cliente recién creado
    const clienteSelect = document.getElementById('cliente_id');
    clienteSelect.value = '{{ session('selectedCliente') }}';
    
    // Disparar el evento change para mostrar la info del cliente
    const event = new Event('change');
    clienteSelect.dispatchEvent(event);
    
    // Mostrar mensaje de éxito
    toastr.success('{{ session('success') }}');
});
@endif
</script>
@endpush
</script>  
@endpush
@endsection