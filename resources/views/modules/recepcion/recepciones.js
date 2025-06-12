// assets/js/recepciones.js
$(document).ready(function() {
    // Inicializar Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
    
    // Contador de equipos
    let equipoCount = 0;
    
    // Agregar nuevo equipo
    $('#addEquipo').click(function() {
        const template = $('#equipoTemplate').html();
        const newEquipo = $(template.replace(/\[0\]/g, `[${equipoCount}]`));
        
        // Actualizar el número de equipo
        newEquipo.find('.equipo-count').text(equipoCount + 1);
        
        // Agregar al contenedor
        $('#equiposContainer').append(newEquipo);
        
        // Incrementar contador
        equipoCount++;
    });
    
    // Eliminar equipo
    $(document).on('click', '.remove-equipo', function() {
        $(this).closest('.equipo-item').remove();
        // Recalcular números de equipo si es necesario
        $('.equipo-item').each(function(index) {
            $(this).find('.equipo-count').text(index + 1);
        });
    });
    
    // Agregar el primer equipo automáticamente
    $('#addEquipo').trigger('click');
});

$('#guardarCliente').click(function() {
    // Obtener todos los datos del formulario
    let formData = {
        nombre: $('#cliente_nombre').val(),
        tipo: $('#cliente_tipo').val(),
        tipo_documento: $('#cliente_tipo_documento').val(),
        documento: $('#cliente_documento').val(),
        telefono: $('#cliente_telefono').val(),
        email: $('#cliente_email').val(),
        direccion: $('#cliente_direccion').val(),
        ciudad: $('#cliente_ciudad').val(),
        pais: 'Bolivia',
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        url: '/clientes',
        method: 'POST',
        data: formData,
        success: function(response) {
            // Agregar el nuevo cliente al select
            const newOption = new Option(
                response.nombre + ' - ' + response.documento + ' (' + response.telefono + ')', 
                response.id, 
                true, 
                true
            );
            $('#cliente_id').append(newOption).trigger('change');
            
            // Cerrar modal y limpiar formulario
            $('#nuevoClienteModal').modal('hide');
            $('#nuevoClienteForm')[0].reset();
            
            toastr.success('Cliente registrado exitosamente');
        },
        error: function(xhr) {
            let errorMessage = 'Error al registrar cliente';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage += ': ' + xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage += ': ' + Object.values(xhr.responseJSON.errors).join(', ');
            }
            toastr.error(errorMessage);
        }
    });
});