<?php
//
//   Este script recibe la información enviada desde el formulario
//   de la página preguntas.html (nombre, correo y pregunta),
//   valida y muestra en pantalla los datos ingresados por el
//   usuario como confirmación.

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    
    // 1. Recepción y sanitización de los datos enviados
    // htmlspecialchars() evita la ejecución de código malicioso
    $nombre   = htmlspecialchars($_POST['nombre'] ?? '');
    $correo   = htmlspecialchars($_POST['correo'] ?? '');
    $pregunta = htmlspecialchars($_POST['pregunta'] ?? '');

    // 2. Validaciones básicas del lado del servidor
    $errores = [];

    if (empty($nombre))   $errores[] = "El campo 'nombre' es obligatorio.";
    if (empty($correo))   $errores[] = "El campo 'correo electrónico' es obligatorio.";
    if (empty($pregunta)) $errores[] = "Debes escribir una pregunta.";

    // 3. Construcción de la respuesta HTML dinámica
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Confirmación - Pregunta enviada</title>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css' rel='stylesheet'>
        <style>
            body {
                background-color: #f8f9fa;
                padding: 40px;
                font-family: Arial, sans-serif;
            }
            .container {
                max-width: 700px;
            }
        </style>
    </head>
    <body>
        <div class='container'>";

    // 4. Si hay errores, los muestra dentro de un panel rojo
    if (!empty($errores)) {
        echo "<div class='card-panel red lighten-4'>
                <h5 style='color:#c62828;'>Ocurrieron los siguientes errores:</h5>
                <ul>";
        foreach ($errores as $e) {
            echo "<li style='color:#c62828;'>• $e</li>";
        }
        echo "  </ul>
               <a href='preguntas.html' class='btn red darken-1'>Regresar</a>
              </div>";
    } else {
        // 5. Si todo está correcto, muestra los datos enviados
        echo "<h4 style='color:#4A90E2;'>¡Gracias por tu mensaje!</h4>
              <p>Hemos recibido tu pregunta correctamente. Estos son los datos registrados:</p>

              <div class='card-panel blue lighten-5'>
                <p><b>Nombre:</b> {$nombre}</p>
                <p><b>Correo electrónico:</b> {$correo}</p>
                <p><b>Pregunta:</b></p>
                <div style='background:#fff; padding:10px; border-radius:8px; border:1px solid #ddd;'>{$pregunta}</div>
              </div>

              <div class='center'>
                <a href='preguntas.html' class='btn blue'>Regresar</a>
              </div>";
    }

    echo "  </div>
    </body>
    </html>";
}
?>
