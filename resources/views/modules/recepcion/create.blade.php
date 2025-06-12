@extends('layouts.main')
@include('shared.aside')
@section('contenido')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Nueva Recepción de Equipo</h5>
        
        <form id="recepcionForm" method="POST" action="{{ route('recepciones.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Sección de Cliente -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="card-title mb-0">Datos del Cliente</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Seleccionar Cliente Existente <span class="text-danger">*</span></label>
                                        <select class="form-select select2" id="cliente_id" name="cliente_id" required>
                                            <option value="">Buscar cliente...</option>
                                            @foreach($clientes as $cliente)
                                                <option value="{{ $cliente->id }}">
                                                    {{ $cliente->nombre }} - {{ $cliente->documento }} ({{ $cliente->telefono }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button type="button" class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">
                                        <i class="bi bi-plus-circle"></i> Registrar Nuevo Cliente
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Info del cliente seleccionado -->
                            <div class="row mt-3" id="clienteInfo" style="display: none;">
                                <div class="col-md-4">
                                    <p><strong>Documento:</strong> <span id="clienteDocumento"></span></p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Teléfono:</strong> <span id="clienteTelefono"></span></p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Email:</strong> <span id="clienteEmail"></span></p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Dirección:</strong> <span id="clienteDireccion"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Datos de la Recepción -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="card-title mb-0">Datos de la Recepción</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="numero_recepcion" class="form-label">Número de Recepción <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="numero_recepcion" name="numero_recepcion" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="fecha_recepcion" class="form-label">Fecha de Recepción <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="fecha_recepcion" name="fecha_recepcion" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="hora_ingreso" class="form-label">Hora de Ingreso <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="hora_ingreso" name="hora_ingreso" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="encargado_id" class="form-label">Encargado <span class="text-danger">*</span></label>
                                        <select class="form-select" id="encargado_id" name="encargado_id" required>
                                            <option value="">Seleccione...</option>
                                            @foreach($usuarios as $usuario)
                                                <option value="{{ $usuario->id }}">{{ $usuario->rol }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="procedente" class="form-label">Procedente</label>
                                        <input type="text" class="form-control" id="procedente" name="procedente">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="presupuesto_inicial" class="form-label">Presupuesto Inicial (Bs)</label>
                                        <input type="number" step="0.01" class="form-control" id="presupuesto_inicial" name="presupuesto_inicial">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">Observaciones Generales</label>
                                <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="registro_fotografico" name="registro_fotografico" value="1">
                                <label class="form-check-label" for="registro_fotografico">
                                    Requiere registro fotográfico
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sección de Equipos -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">Equipo(s) a Recepcionar</h6>
                            <button type="button" class="btn btn-light btn-sm" id="addEquipo">
                                <i class="bi bi-plus-circle"></i> Agregar Equipo
                            </button>
                        </div>
                        <div class="card-body" id="equiposContainer">
                            <!-- Los equipos se agregarán dinámicamente aquí -->
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar Recepción
                </button>
                <a href="{{ route('recepciones.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Modal para nuevo cliente -->
<div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-labelledby="nuevoClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="nuevoClienteModalLabel">Registrar Nuevo Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="nuevoClienteForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre/Razón Social <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cliente_nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipo <span class="text-danger">*</span></label>
                                <select class="form-select" id="cliente_tipo" name="tipo" required>
                                    <option value="Persona">Persona</option>
                                    <option value="Empresa">Empresa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                                <select class="form-select" id="cliente_tipo_documento" name="tipo_documento" required>
                                    <option value="CI">Carnet de Identidad</option>
                                    <option value="NIT">NIT</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Número de Documento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cliente_documento" name="documento" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cliente_telefono" name="telefono" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="cliente_email" name="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="cliente_ciudad" name="ciudad" value="Santa Cruz">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea class="form-control" id="cliente_direccion" name="direccion" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardarCliente">Guardar Cliente</button>
            </div>
        </div>
    </div>
</div>

<!-- Plantilla para nuevos equipos (hidden) -->
<div id="equipoTemplate" class="d-none">
    <div class="card mb-3 equipo-item">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <h6 class="card-title mb-0">Equipo #<span class="equipo-count">1</span></h6>
            <button type="button" class="btn btn-danger btn-sm remove-equipo">
                <i class="bi bi-trash"></i> Eliminar
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Equipo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="equipos[__INDEX__][nombre]" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Número de Serie</label>
                        <input type="text" class="form-control" name="equipos[__INDEX__][serie]">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Equipo <span class="text-danger">*</span></label>
                        <select class="form-select" name="equipos[__INDEX__][tipo]" required>
                            <option value="">Seleccione...</option>
                            <option value="MOTOR_ELECTRICO">Motor Eléctrico</option>
                            <option value="MAQUINA_SOLDADORA">Máquina Soldadora</option>
                            <option value="GENERADOR_DINAMO">Generador/Dinamo</option>
                            <option value="OTROS">Otros</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" class="form-control" name="equipos[__INDEX__][marca]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Modelo</label>
                        <input type="text" class="form-control" name="equipos[__INDEX__][modelo]">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" class="form-control" name="equipos[__INDEX__][color]">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Voltaje</label>
                        <input type="text" class="form-control" name="equipos[__INDEX__][voltaje]">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">RPM</label>
                        <input type="text" class="form-control" name="equipos[__INDEX__][rpm]">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Potencia</label>
                        <input type="text" class="form-control" name="equipos[__INDEX__][potencia]">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Estado al recibir</label>
                        <input type="text" class="form-control" name="equipos[__INDEX__][estado]">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Costo Estimado (Bs)</label>
                        <input type="number" step="0.01" class="form-control" name="equipos[__INDEX__][costo_estimado]">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Partes Faltantes</label>
                <textarea class="form-control" name="equipos[__INDEX__][partes_faltantes]" rows="2"></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Trabajo a Realizar</label>
                <textarea class="form-control" name="equipos[__INDEX__][trabajo_realizar]" rows="2"></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Observaciones</label>
                <textarea class="form-control" name="equipos[__INDEX__][observaciones]" rows="2"></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Fotos del Equipo</label>
                <input type="file" class="form-control" name="equipos[__INDEX__][fotos][]" multiple accept="image/jpeg,image/png,image/jpg,image/gif">
                <div class="form-text">Puede seleccionar hasta 5 fotos (JPEG, PNG, JPG, GIF) - Máx. 2MB cada una</div>
                <div class="fotos-preview d-flex flex-wrap mt-2"></div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
    
    // Mostrar info del cliente seleccionado
    $('#cliente_id').change(function() {
        const clienteId = $(this).val();
        if (clienteId) {
            $.get(`/clientes/${clienteId}`, function(cliente) {
                $('#clienteInfo').show();
                $('#clienteDocumento').text(cliente.documento);
                $('#clienteTelefono').text(cliente.telefono);
                $('#clienteEmail').text(cliente.email || 'N/A');
                $('#clienteDireccion').text(cliente.direccion || 'N/A');
            }).fail(function() {
                toastr.error('Error al cargar información del cliente');
            });
        } else {
            $('#clienteInfo').hide();
        }
    });
    
    // Gestión dinámica de equipos
    let equipoCount = 0;

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

    // Vista previa de imágenes
    $(document).on('change', 'input[type="file"]', function(e) {
        const container = $(this).closest('.equipo-item').find('.fotos-preview');
        container.empty();
        
        // Validar cantidad máxima de fotos
        if (this.files.length > 5) {
            toastr.warning('Máximo 5 fotos por equipo');
            $(this).val('');
            return;
        }
        
        // Mostrar miniaturas
        Array.from(e.target.files).forEach(file => {
            if (!file.type.match('image.*')) {
                toastr.error(`El archivo ${file.name} no es una imagen válida`);
                return;
            }
            
            if (file.size > 4 * 1024 * 1024) {
                toastr.error(`La imagen ${file.name} supera el límite de 2MB`);
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                container.append(`
                    <div class="position-relative me-2 mb-2">
                        <img src="${e.target.result}" class="img-thumbnail" style="height: 80px; width: 80px; object-fit: cover;">
                        <button type="button" class="btn-close position-absolute top-0 end-0 bg-danger rounded-circle p-1" 
                                style="transform: translate(30%, -30%);" 
                                onclick="$(this).parent().remove();"></button>
                    </div>
                `);
            }
            reader.readAsDataURL(file);
        });
    });

    $('#addEquipo').click(function() {
        const template = $('#equipoTemplate').html();
        
        const newEquipo = $($('#equipoTemplate').html().replace(/__INDEX__/g, equipoCount));

        $('#equiposContainer').append(newEquipo);
        reindexEquipos();
    });

    $(document).on('click', '.remove-equipo', function() {
        $(this).closest('.equipo-item').remove();
        reindexEquipos();
    });
    
    // Guardar nuevo cliente
    $('#guardarCliente').click(function() {
        $.ajax({
            url: "{{ route('clientes.store') }}",
            method: 'POST',
            data: $('#nuevoClienteForm').serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    $('#nuevoClienteModal').modal('hide');
                    var newOption = new Option(
                        response.cliente.nombre + ' - ' + response.cliente.documento, 
                        response.cliente.id, 
                        true, 
                        true
                    );
                    $('#cliente_id').append(newOption).trigger('change');
                    toastr.success(response.message);
                    $('#nuevoClienteForm')[0].reset();
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Error al registrar el cliente');
                }
            }
        });
    });
    
    // Configurar fecha y hora actual por defecto
    const now = new Date();
    $('#fecha_recepcion').val(now.toISOString().split('T')[0]);
    $('#hora_ingreso').val(now.toTimeString().substring(0, 5));
    
    // Manejar el envío del formulario principal
    $('#recepcionForm').submit(function(e) {
        e.preventDefault();
        
        const submitBtn = $('button[type="submit"]');
        submitBtn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...'
        );

        // Validar campos requeridos
        let hasErrors = false;
        $('.equipo-item:visible').each(function(index) {

            const nombre = $(this).find('[name^="equipos["][name$="[nombre]"]').val();
            const tipo = $(this).find('[name^="equipos["][name$="[tipo]"]').val();
            
            if (!nombre || !tipo) {
                toastr.error(`Por favor complete todos los campos requeridos en el Equipo ${index + 1}`);
                hasErrors = true;
            }
            console.log(`Equipo ${index + 1}: nombre=${nombre}, tipo=${tipo}`);

        });

        if (hasErrors) {
            submitBtn.prop('disabled', false).html(
                '<i class="bi bi-save"></i> Guardar Recepción'
            );
            return;
        }

        // Crear FormData y limpiar datos previos de equipos
        let formData = new FormData(this);
        for (let key of formData.keys()) {
            if (key.startsWith('equipos[')) {
                formData.delete(key);
            }
        }

        // Agregar solo los equipos visibles
        $('.equipo-item:visible').each(function(index) {
            // Agregar campos normales
            $(this).find('input:not([type="file"]), select, textarea').each(function() {
                let name = $(this).attr('name');
                formData.append(name, $(this).val());
            });
            
            // Agregar archivos (fotos)
            $(this).find('input[type="file"]').each(function() {
                let name = $(this).attr('name');
                let files = $(this)[0].files;
                
                for (let i = 0; i < files.length; i++) {
                    formData.append(`${name}[${i}]`, files[i]);
                }
            });
        });

        // Enviar datos via AJAX
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toastr.success('Recepción guardada correctamente');
                window.location.href = "{{ route('recepciones.index') }}";
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(
                    '<i class="bi bi-save"></i> Guardar Recepción'
                );
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    
                    $.each(errors, function(field, messages) {
                        let fieldName = field.replace(/equipos\.\d+\./, 'Equipo ')
                                            .replace(/fotos\.\d+/, 'Foto ')
                                            .replace(/_/g, ' ');
                        errorMessages += `<b>${fieldName}:</b> ${messages[0]}<br>`;
                    });
                    
                    toastr.error(errorMessages, 'Errores de validación', {
                        timeOut: 10000,
                        closeButton: true,
                        progressBar: true
                    });
                } else {
                    toastr.error('Error al guardar la recepción: ' + (xhr.responseJSON?.message || xhr.statusText));
                }
            }
        });
    });
});
</script>  
@endpush
@endsection