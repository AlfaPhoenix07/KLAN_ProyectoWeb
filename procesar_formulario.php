<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre  = htmlspecialchars($_POST['nombre'] ?? '');
    $correo  = htmlspecialchars($_POST['correo'] ?? '');
    $telefono = htmlspecialchars($_POST['telefono'] ?? '');

    // Procesar archivo si fue subido
    $archivoNombre = '';
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
        $archivoNombre = $_FILES['cv']['name'];
        $rutaDestino = 'uploads/' . basename($archivoNombre);

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }
        move_uploaded_file($_FILES['cv']['tmp_name'], $rutaDestino);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud Enviada - KLAN</title>

    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">

    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f8;
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background-color: #fff;
            max-width: 550px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            text-align: center;
        }
        h3 {
            color: #4A90E2;
            font-weight: 600;
        }
        .info {
            text-align: left;
            margin-top: 25px;
            font-size: 1.1em;
        }
        .info p b {
            color: #333;
        }
        .btn-volver {
            margin-top: 25px;
            background-color: #4A90E2;
            border-radius: 25px;
        }
        .btn-volver:hover {
            background-color: #357ABD;
        }
        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: #888;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

    <div class="card z-depth-3">
        <i class="material-icons large green-text">check_circle</i>
        <h3>¡Solicitud enviada correctamente!</h3>
        <p>Gracias por tu interés en formar parte del equipo de <b>KLAN</b>.</p>

        <div class="info">
            <p><b>Nombre:</b> <?= $nombre ?></p>
            <p><b>Correo:</b> <?= $correo ?></p>
            <p><b>Teléfono:</b> <?= $telefono ?></p>
            <?php if ($archivoNombre): ?>
                <p><b>Archivo recibido:</b> <?= $archivoNombre ?></p>
            <?php else: ?>
                <p><b>Archivo:</b> No se adjuntó archivo.</p>
            <?php endif; ?>
        </div>

        <a href="contact.html" class="btn btn-volver waves-effect waves-light">
            <i class="material-icons left">arrow_back</i> Volver al formulario
        </a>
    </div>

    <footer>&copy; 2025 KLAN - Todos los derechos reservados.</footer>

</body>
</html>
<?php
} else {
    echo "<h3>No se recibieron datos del formulario.</h3>";
}
?>
