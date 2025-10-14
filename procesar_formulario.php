<?php
// =============================================
// procesar_formulario.php
// Archivo PHP que recibe los datos del formulario de contacto
// =============================================

// Verificar si se envió el formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibir los datos del formulario
    $nombre  = htmlspecialchars($_POST['nombre'] ?? '');
    $correo  = htmlspecialchars($_POST['correo'] ?? '');
    $telefono = htmlspecialchars($_POST['telefono'] ?? '');
    
    // Verificar si se subió un archivo
    $archivoNombre = '';
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
        $archivoNombre = $_FILES['cv']['name'];
        $rutaDestino = 'uploads/' . basename($archivoNombre);

        // Crear carpeta si no existe
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Mover archivo temporal a la carpeta destino
        move_uploaded_file($_FILES['cv']['tmp_name'], $rutaDestino);
    }

    // Mostrar los datos enviados
    echo "<h2>¡Solicitud enviada correctamente!</h2>";
    echo "<p><b>Nombre:</b> $nombre</p>";
    echo "<p><b>Correo:</b> $correo</p>";
    echo "<p><b>Teléfono:</b> $telefono</p>";
    
    if ($archivoNombre) {
        echo "<p><b>Archivo recibido:</b> $archivoNombre</p>";
    } else {
        echo "<p><b>Archivo:</b> No se adjuntó archivo.</p>";
    }

} else {
    echo "<h3>No se recibieron datos del formulario.</h3>";
}
?>
