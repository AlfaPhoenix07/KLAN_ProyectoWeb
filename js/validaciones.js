$(document).ready(function() {
    
    // Validar que un campo no esté vacío
    function validarCampoVacio(valor) {
        return valor.trim().length > 0;
    }
    
    // Validar formato de email
    function validarEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    
    // Validar teléfono (10 dígitos, acepta espacios y guiones)
    function validarTelefono(telefono) {
        const regex = /^[\d\s\-()]{10,10}$/;
        return regex.test(telefono);
    }
    
    // Validar que el archivo sea PDF o DOC/DOCX
    function validarArchivo(nombreArchivo) {
        if (!nombreArchivo) return false;
        const extensionesValidas = ['pdf', 'doc', 'docx'];
        const extension = nombreArchivo.split('.').pop().toLowerCase();
        return extensionesValidas.includes(extension);
    }
    
    // Validar nombre (solo letras y espacios)
    function validarNombre(nombre) {
        const regex = /^[a-záéíóúñÁÉÍÓÚÑ\s]+$/i;
        return regex.test(nombre) && nombre.trim().length >= 3;
    }
    
    
    function mostrarError(campo, mensaje) {
        // Remover error previo si existe
        campo.removeClass('valid').addClass('invalid');
        campo.siblings('.helper-text').remove();
        
        // Agregar nuevo mensaje de error
        campo.after(`<span class="helper-text" data-error="${mensaje}" style="color:#f44336;">${mensaje}</span>`);
    }
    
    function ocultarError(campo) {
        campo.removeClass('invalid').addClass('valid');
        campo.siblings('.helper-text').remove();
    }
    
    
    // Validar nombre en tiempo real
    $('input[name="nombre"]').on('blur', function() {
        const valor = $(this).val();
        
        if (!validarCampoVacio(valor)) {
            mostrarError($(this), 'El nombre es obligatorio');
        } else if (!validarNombre(valor)) {
            mostrarError($(this), 'El nombre debe contener solo letras (mínimo 3 caracteres)');
        } else {
            ocultarError($(this));
        }
    });
    
    // Validar email en tiempo real
    $('input[name="correo"]').on('blur', function() {
        const valor = $(this).val();
        
        if (!validarCampoVacio(valor)) {
            mostrarError($(this), 'El correo electrónico es obligatorio');
        } else if (!validarEmail(valor)) {
            mostrarError($(this), 'Por favor ingresa un correo electrónico válido');
        } else {
            ocultarError($(this));
        }
    });
    
    // Validar teléfono en tiempo real (solo en contact.html)
    $('input[name="telefono"]').on('blur', function() {
        const valor = $(this).val();
        
        if (!validarCampoVacio(valor)) {
            mostrarError($(this), 'El teléfono es obligatorio');
        } else if (!validarTelefono(valor)) {
            mostrarError($(this), 'Por favor ingresa un teléfono válido (mínimo 10 dígitos)');
        } else {
            ocultarError($(this));
        }
    });
    
    // Validar textarea pregunta (solo en preguntas.html)
    $('textarea[name="pregunta"]').on('blur', function() {
        const valor = $(this).val();
        
        if (!validarCampoVacio(valor)) {
            mostrarError($(this), 'Por favor escribe tu pregunta');
        } else if (valor.trim().length < 10) {
            mostrarError($(this), 'La pregunta debe tener al menos 10 caracteres');
        } else {
            ocultarError($(this));
        }
    });
    
    // Validar archivo CV (solo en contact.html)
    $('input[name="cv"]').on('change', function() {
        const archivo = this.files[0];
        
        if (!archivo) {
            mostrarError($(this).closest('.file-field').find('.file-path'), 'Por favor selecciona tu CV');
        } else if (!validarArchivo(archivo.name)) {
            mostrarError($(this).closest('.file-field').find('.file-path'), 'Solo se permiten archivos PDF, DOC o DOCX');
        } else if (archivo.size > 5242880) { // 5MB
            mostrarError($(this).closest('.file-field').find('.file-path'), 'El archivo no debe superar los 5MB');
        } else {
            ocultarError($(this).closest('.file-field').find('.file-path'));
        }
    });
    
    //  -- VALIDACIÓN AL ENVIAR FORMULARIO DE PREGUNTAS -- 
    $('#nueva-pregunta .formulario').on('submit', function(e) {
        e.preventDefault();
        
        let formularioValido = true;
        
        // Validar nombre
        const nombre = $(this).find('input[name="nombre"]');
        if (!validarCampoVacio(nombre.val())) {
            mostrarError(nombre, 'El nombre es obligatorio');
            formularioValido = false;
        } else if (!validarNombre(nombre.val())) {
            mostrarError(nombre, 'El nombre debe contener solo letras (mínimo 3 caracteres)');
            formularioValido = false;
        } else {
            ocultarError(nombre);
        }
        
        // Validar correo
        const correo = $(this).find('input[name="correo"]');
        if (!validarCampoVacio(correo.val())) {
            mostrarError(correo, 'El correo electrónico es obligatorio');
            formularioValido = false;
        } else if (!validarEmail(correo.val())) {
            mostrarError(correo, 'Por favor ingresa un correo electrónico válido');
            formularioValido = false;
        } else {
            ocultarError(correo);
        }
        
        // Validar pregunta
        const pregunta = $(this).find('textarea[name="pregunta"]');
        if (!validarCampoVacio(pregunta.val())) {
            mostrarError(pregunta, 'Por favor escribe tu pregunta');
            formularioValido = false;
        } else if (pregunta.val().trim().length < 10) {
            mostrarError(pregunta, 'La pregunta debe tener al menos 10 caracteres');
            formularioValido = false;
        } else {
            ocultarError(pregunta);
        }
        
        // Si todo es válido, mostrar mensaje y enviar al PHP
        if (formularioValido) {
            M.toast({
                html: '¡Pregunta enviada con éxito! Procesando en servidor...',
                classes: 'rounded green',
                displayLength: 1500
            });
            setTimeout(() => {
                e.currentTarget.submit(); // envío real al PHP
            }, 1500);
        }
    });
    
    // ========== VALIDACIÓN AL ENVIAR FORMULARIO DE CONTACTO ==========
    $('#form-contacto').on('submit', function(e) {
        e.preventDefault();
        
        let formularioValido = true;
        
        // Validar nombre
        const nombre = $(this).find('input[name="nombre"]');
        if (!validarCampoVacio(nombre.val())) {
            mostrarError(nombre, 'El nombre es obligatorio');
            formularioValido = false;
        } else if (!validarNombre(nombre.val())) {
            mostrarError(nombre, 'El nombre debe contener solo letras (mínimo 3 caracteres)');
            formularioValido = false;
        } else {
            ocultarError(nombre);
        }
        
        // Validar teléfono
        const telefono = $(this).find('input[name="telefono"]');
        if (!validarCampoVacio(telefono.val())) {
            mostrarError(telefono, 'El teléfono es obligatorio');
            formularioValido = false;
        } else if (!validarTelefono(telefono.val())) {
            mostrarError(telefono, 'Por favor ingresa un teléfono válido (10 dígitos)');
            formularioValido = false;
        } else {
            ocultarError(telefono);
        }
        
        // Validar correo
        const correo = $(this).find('input[name="correo"]');
        if (!validarCampoVacio(correo.val())) {
            mostrarError(correo, 'El correo electrónico es obligatorio');
            formularioValido = false;
        } else if (!validarEmail(correo.val())) {
            mostrarError(correo, 'Por favor ingresa un correo electrónico válido');
            formularioValido = false;
        } else {
            ocultarError(correo);
        }
        
        // Validar archivo CV
        const archivoInput = $(this).find('input[name="cv"]')[0];
        const archivo = archivoInput.files[0];
        
        if (!archivo) {
            mostrarError($(this).find('.file-path'), 'Por favor selecciona tu CV');
            formularioValido = false;
        } else if (!validarArchivo(archivo.name)) {
            mostrarError($(this).find('.file-path'), 'Solo se permiten archivos PDF, DOC o DOCX');
            formularioValido = false;
        } else if (archivo.size > 5242880) { // 5MB
            mostrarError($(this).find('.file-path'), 'El archivo no debe superar los 5MB');
            formularioValido = false;
        } else {
            ocultarError($(this).find('.file-path'));
        }
        
        // Si todo es válido, mostrar modal y enviar al PHP
        if (formularioValido) {
            M.toast({
                html: '¡Formulario enviado! Procesando en servidor...',
                classes: 'rounded green',
                displayLength: 1500
            });
            setTimeout(() => {
                e.currentTarget.submit(); // envío real al PHP
            }, 1500);
        }
    });
});
