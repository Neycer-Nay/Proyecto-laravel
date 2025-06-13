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
                                        <select class="form-select select2" id="cliente_id" name="cliente_id" required>
                                            <option value="">Buscar cliente...</option>
                                            @foreach($clientes as $cliente)
                                                <option value="{{ $cliente->id }}">
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
                                
                                <!-- Info del cliente seleccionado -->
                                <div class="row mt-3 g-2" id="clienteInfo" style="display: none;">
                                    <div class="col-md-3">
                                        <div class="bg-light p-2 rounded">
                                            <small class="text-muted d-block">Documento</small>
                                            <span id="clienteDocumento" class="fw-bold clienteM"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-light p-2 rounded">
                                            <small class="text-muted d-block">Teléfono</small>
                                            <span id="clienteTelefono" class="fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-light p-2 rounded">
                                            <small class="text-muted d-block">Email</small>
                                            <span id="clienteEmail" class="fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-light p-2 rounded">
                                            <small class="text-muted d-block">Dirección</small>
                                            <span id="clienteDireccion" class="fw-bold"></span>
                                        </div>
                                    </div>
                                </div>
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
                                        <input type="text" class="form-control" id="numero_recepcion" name="numero_recepcion" required>
                                        <div class="invalid-feedback">Ingrese el número de recepción</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="fecha_recepcion" class="form-label">Fecha <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="fecha_recepcion" name="fecha_recepcion" required>
                                        <div class="invalid-feedback">Seleccione la fecha</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="hora_ingreso" class="form-label">Hora <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="hora_ingreso" name="hora_ingreso" required>
                                        <div class="invalid-feedback">Ingrese la hora</div>
                                    </div>
                                </div>
                                
                                <div class="row g-3 mt-1">
                                    <div class="col-md-6">
                                        <label for="encargado_id" class="form-label">Encargado <span class="text-danger">*</span></label>
                                        <select class="form-select" id="encargado_id" name="encargado_id" required>
                                            <option value="">Seleccione...</option>
                                            @foreach($usuarios as $usuario)
                                                <option value="{{ $usuario->id }}">{{ $usuario->rol }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Seleccione un encargado</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="procedente" class="form-label">Procedente</label>
                                        <input type="text" class="form-control" id="procedente" name="procedente">
                                    </div>
                                </div>
                                
                                <div class="row g-3 mt-1">
                                    <div class="col-md-6">
                                        <label for="presupuesto_inicial" class="form-label">Presupuesto Inicial (Bs)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Bs.</span>
                                            <input type="number" step="0.01" class="form-control" id="presupuesto_inicial" name="presupuesto_inicial">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="registro_fotografico" name="registro_fotografico" value="1">
                                            <label class="form-check-label" for="registro_fotografico">
                                                Requiere registro fotográfico
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <label for="observaciones" class="form-label">Observaciones Generales</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
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
                                <!-- Los equipos se agregarán dinámicamente aquí -->
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
            <div class="modal-body">
                <form id="nuevoClienteForm" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre/Razón Social <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cliente_nombre" name="nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipo <span class="text-danger">*</span></label>
                        <select class="form-select" id="cliente_tipo" name="tipo" required>
                            <option value="Persona">Persona</option>
                            <option value="Empresa">Empresa</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                        <select class="form-select" id="cliente_tipo_documento" name="tipo_documento" required>
                            <option value="CI">Carnet de Identidad</option>
                            <option value="NIT">NIT</option>
                            <option value="Pasaporte">Pasaporte</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Número de Documento <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cliente_documento" name="documento" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cliente_telefono" name="telefono" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="cliente_email" name="email">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ciudad</label>
                        <input type="text" class="form-control" id="cliente_ciudad" name="ciudad" value="Santa Cruz">
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Dirección</label>
                        <textarea class="form-control" id="cliente_direccion" name="direccion" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardarCliente">
                    <i class="bi bi-save me-1"></i>Guardar Cliente
                </button>
            </div>
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
                
                <!-- Opción tradicional de subir archivos -->
                <input type="file" class="form-control" name="equipos[__INDEX__][fotos][]" multiple 
                       accept="image/jpeg,image/png,image/jpg,image/gif" id="file-upload-__INDEX__">
                <div class="form-text">Puede seleccionar hasta 5 fotos (JPEG, PNG, JPG, GIF) - Máx. 8MB cada una</div>
                
                <!-- Opción para capturar desde cámara -->
                <div class="mt-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="start-camera-__INDEX__">
                        <i class="bi bi-camera me-1"></i> Tomar Foto con Cámara
                    </button>
                    
                    <div class="camera-container mt-2" id="camera-container-__INDEX__" style="display:none;">
                        <div class="d-flex gap-2">
                            <video id="video-__INDEX__" width="320" height="240" autoplay class="rounded"></video>
                            <canvas id="canvas-__INDEX__" width="320" height="240" style="display:none;"></canvas>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary btn-sm" id="take-photo-__INDEX__">
                                <i class="bi bi-camera-fill me-1"></i> Capturar
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" id="retake-photo-__INDEX__" style="display:none;">
                                <i class="bi bi-arrow-repeat me-1"></i> Volver a Tomar
                            </button>
                            <button type="button" class="btn btn-success btn-sm" id="add-photo-__INDEX__" style="display:none;">
                                <i class="bi bi-plus-circle me-1"></i> Agregar Foto
                            </button>
                        </div>
                    </div>
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
    .form-control, .form-select, .select2-selection {
        border-radius: 0.375rem;
    }
    .select2-container--bootstrap-5 .select2-selection {
        padding: 0.375rem 0.75rem;
        min-height: calc(1.5em + 0.75rem + 2px);
    }
    .equipo-item {
        transition: all 0.2s ease;
    }
    .equipo-item:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .fotos-preview img {
        object-fit: cover;
        border: 1px solid #dee2e6;
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
    // Inicializar Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Buscar cliente...',
        allowClear: true
    });
    
    // Mostrar info del cliente seleccionado
    $('#cliente_id').change(function() {
        const clienteId = $(this).val();
        if (clienteId) {
            $.get(`/clientes/${clienteId}`, function(cliente) {
                $('#clienteInfo').show();
                $('#clienteDocumento').html(cliente.documento || 'N/A');
                $('#clienteTelefono').html(cliente.telefono || 'N/A');
                $('#clienteEmail').html(cliente.email || 'N/A');
                $('#clienteDireccion').html(cliente.direccion || 'N/A');
            }).fail(function(xhr, status, error) {
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
                $(this).attr('id', newName.replace(/\[|\]/g, '_'));
            });
            
            // Actualizar IDs de elementos de cámara
            $(this).find('[id^="video-"], [id^="canvas-"], [id^="start-camera-"], [id^="take-photo-"], [id^="retake-photo-"], [id^="add-photo-"], [id^="camera-container-"], [id^="file-upload-"]').each(function() {
                const currentId = $(this).attr('id');
                const newId = currentId.replace(/-(\d+)$/, `-${index}`);
                $(this).attr('id', newId);
            });
        });
        equipoCount = $('.equipo-item').length;
    }

    // Función para configurar la cámara para un equipo específico
    function setupCamera(index) {
        const video = $(`#video-${index}`)[0];
        const canvas = $(`#canvas-${index}`)[0];
        const startCamera = $(`#start-camera-${index}`)[0];
        const takePhoto = $(`#take-photo-${index}`)[0];
        const retakePhoto = $(`#retake-photo-${index}`)[0];
        const addPhoto = $(`#add-photo-${index}`)[0];
        const cameraContainer = $(`#camera-container-${index}`)[0];
        const fileUpload = $(`#file-upload-${index}`)[0];
        const previewContainer = $(`#file-upload-${index}`).closest('.col-md-12').find('.fotos-preview');
        
        let stream = null;
        let capturedPhotos = [];
        
        // Evento para iniciar cámara
        $(startCamera).on('click', function() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: { ideal: 1280 },
                        height: { ideal: 720 },
                        facingMode: 'environment' 
                    } 
                }).then(function(mediaStream) {
                    stream = mediaStream;
                    video.srcObject = stream;
                    $(cameraContainer).show();
                    $(startCamera).hide();
                    $(takePhoto).show();
                }).catch(function(error) {
                    console.error("Error al acceder a la cámara: ", error);
                    toastr.error('No se pudo acceder a la cámara. Asegúrate de permitir el acceso.');
                });
            } else {
                toastr.error('Tu navegador no soporta la API de medios o no tiene cámara.');
            }
        });
        
        // Evento para tomar foto (VERSIÓN CORREGIDA)
        $(takePhoto).on('click', function() {
            // Asegurarse que el video está listo
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                
                // Dibujar la imagen del video en el canvas
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                
                $(video).hide();
                $(canvas).show();
                $(takePhoto).hide();
                $(retakePhoto).show();
                $(addPhoto).show();
                
                // Pausar el stream de video
                if (stream) {
                    stream.getVideoTracks()[0].pause();
                }
            } else {
                toastr.error('El video no está listo para capturar. Espera un momento.');
            }
        });
        
        // Evento para volver a tomar
        $(retakePhoto).on('click', function() {
            $(canvas).hide();
            $(video).show();
            $(retakePhoto).hide();
            $(addPhoto).hide();
            $(takePhoto).show();
            
            // Reanudar el stream de video
            if (stream) {
                stream.getVideoTracks()[0].resume();
            }
        });
        
        // Evento para agregar foto
        $(addPhoto).on('click', function() {
            if (capturedPhotos.length >= 5) {
                toastr.warning('Máximo 5 fotos por equipo');
                return;
            }
            
            // Reducir calidad para no exceder límites de tamaño
            const imageData = canvas.toDataURL('image/jpeg', 0.7);
            capturedPhotos.push(imageData);
            
            // Mostrar vista previa
            const photoId = `photo-${index}-${Date.now()}`;
            previewContainer.append(`
                <div class="position-relative" style="width: 80px; height: 80px;" data-photo-id="${photoId}">
                    <img src="${imageData}" class="img-thumbnail h-100 w-100">
                    <button type="button" class="btn-close position-absolute top-0 end-0 bg-danger rounded-circle p-1" 
                            style="transform: translate(30%, -30%);" 
                            onclick="removePhoto('${photoId}', ${index})"></button>
                </div>
            `);
            
            // Resetear para nueva captura
            $(retakePhoto).trigger('click');
            
            // Actualizar input hidden
            updateCapturedPhotosInput(index);
        });
        
        // Función para actualizar input hidden
        function updateCapturedPhotosInput(index) {
            $(`input[name="equipos[${index}][captured_photos]"]`).remove();
            if (capturedPhotos.length > 0) {
                $('<input>').attr({
                    type: 'hidden',
                    name: `equipos[${index}][captured_photos]`,
                    value: JSON.stringify(capturedPhotos)
                }).appendTo($(fileUpload).parent());
            }
        }
        
        // Limpiar al cambiar archivo
        $(fileUpload).on('change', function() {
            if (this.files && this.files.length > 0) {
                capturedPhotos = [];
                updateCapturedPhotosInput(index);
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
                $(cameraContainer).hide();
                $(startCamera).show();
                $(takePhoto).hide();
                $(retakePhoto).hide();
                $(addPhoto).hide();
                $(canvas).hide();
                $(video).show();
            }
        });
    }
    // Vista previa de imágenes para archivos subidos
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
            
            if (file.size > 8 * 1024 * 1024) {
                toastr.error(`La imagen ${file.name} supera el límite de 8MB`);
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                container.append(`
                    <div class="position-relative" style="width: 80px; height: 80px;">
                        <img src="${e.target.result}" class="img-thumbnail h-100 w-100">
                        <button type="button" class="btn-close position-absolute top-0 end-0 bg-danger rounded-circle p-1" 
                                style="transform: translate(30%, -30%);" 
                                onclick="$(this).parent().remove();"></button>
                    </div>
                `);
            }
            reader.readAsDataURL(file);
        });
    });

    // Función global para eliminar fotos capturadas
    window.removePhoto = function(photoId, index) {
        $(`[data-photo-id="${photoId}"]`).remove();
        
        // Encontrar el contenedor del equipo correspondiente
        const container = $(`#file-upload-${index}`).closest('.col-md-12');
        const capturedPhotosInput = container.find(`input[name="equipos[${index}][captured_photos]"]`);
        
        if (capturedPhotosInput.length) {
            let photos = JSON.parse(capturedPhotosInput.val());
            const photoSrc = $(`[data-photo-id="${photoId}"] img`).attr('src');
            photos = photos.filter(p => p !== photoSrc);
            
            if (photos.length > 0) {
                capturedPhotosInput.val(JSON.stringify(photos));
            } else {
                capturedPhotosInput.remove();
            }
        }
    }

    // Función para convertir base64 a Blob
    window.dataURLtoBlob = function(dataURL) {
        const parts = dataURL.split(',');
        const mime = parts[0].match(/:(.*?);/)[1];
        const byteString = atob(parts[1]);
        const ab = new ArrayBuffer(byteString.length);
        const ia = new Uint8Array(ab);
        
        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        
        return new Blob([ab], { type: mime });
    }

    // Agregar nuevo equipo
    $('#addEquipo').click(function() {
        const newEquipo = $($('#equipoTemplate').html().replace(/__INDEX__/g, equipoCount));
        $('#equiposContainer').append(newEquipo);
        reindexEquipos();
        
        // Configurar cámara para este nuevo equipo
        setupCamera(equipoCount - 1);
        
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
    
    // Guardar nuevo cliente
    $('#guardarCliente').click(function() {
        const btn = $(this);
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...');
        
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
                btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i>Guardar Cliente');
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i>Guardar Cliente');
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
    
    // Validación del formulario
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
    
    // Manejar el envío del formulario principal
    $('#recepcionForm').submit(function(e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            e.stopPropagation();
            return;
        }
        
        const submitBtn = $('button[type="submit"]');
        submitBtn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...'
        );

        // Validar campos requeridos de equipos
        let hasErrors = false;
        $('.equipo-item:visible').each(function(index) {
            const nombre = $(this).find('[name^="equipos["][name$="[nombre]"]').val();
            const tipo = $(this).find('[name^="equipos["][name$="[tipo]"]').val();
            
            if (!nombre || !tipo) {
                toastr.error(`Por favor complete todos los campos requeridos en el Equipo ${index + 1}`);
                hasErrors = true;
            }
        });

        if (hasErrors) {
            submitBtn.prop('disabled', false).html(
                '<i class="bi bi-save me-2"></i> Guardar Recepción'
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
            $(this).find('input:not([type="file"]):not([type="hidden"]), select, textarea').each(function() {
                let name = $(this).attr('name');
                formData.append(name, $(this).val());
            });
            
            // Agregar archivos subidos
            $(this).find('input[type="file"]').each(function() {
                const files = this.files;
                const inputName = $(this).attr('name').replace('__INDEX__', index);
                
                // Eliminar el nombre original del array vacío
                formData.delete(inputName);
                
                // Agregar cada archivo con índice explícito
                Array.from(files).forEach((file, i) => {
                    formData.append(inputName.replace('[]', `[${i}]`), file);
                });
            });
            
            // Agregar fotos capturadas
            const capturedPhotosInput = $(this).find('[name^="equipos["][name$="[captured_photos]"]');
            if (capturedPhotosInput.length) {
                const photos = JSON.parse(capturedPhotosInput.val());
                photos.forEach((photo, i) => {
                    const blob = dataURLtoBlob(photo);
                    formData.append(`equipos[${index}][captured_photos][${i}]`, blob, `photo_${index}_${i}.jpg`);
                });
            }
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
                    '<i class="bi bi-save me-2"></i> Guardar Recepción'
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
                        progressBar: true,
                        escapeHtml: false
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