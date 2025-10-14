<?php

// Este script recibe los datos del formulario de contact.html
// y muestra una confirmación simple para cumplir el requisito
// de procesamiento en PHP puro (sin base de datos todavía).

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Limpieza básica de variables
    $nombre   = htmlspecialchars($_POST['nombre'] ?? '');
    $telefono = htmlspecialchars($_POST['telefono'] ?? '');
    $correo   = htmlspecialchars($_POST['correo'] ?? '');
    $mensaje  = "Solicitud enviada correctamente.";

    // Validaciones simples del lado del servidor
    if (empty($nombre) || empty($telefono) || empty($correo)) {
        $mensaje = "⚠️ Faltan datos obligatorios.";
    }

    // Mostrar respuesta al usuario
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Confirmación de envío - KLAN</title>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css' rel='stylesheet'>
    </head>
    <body style='padding: 40px; background-color: #f8f9fa;'>
        <div class='container'>
            <h3 style='color:#4A90E2;'>Formulario procesado en PHP</h3>
            <p><b>Nombre:</b> {$nombre}</p>
            <p><b>Teléfono:</b> {$telefono}</p>
            <p><b>Correo:</b> {$correo}</p>
            <div class='card-panel blue lighten-4' style='margin-top:20px;'>
                <b>{$mensaje}</b>
            </div>
            <a href='contact.html' class='btn blue'>Regresar</a>
        </div>
    </body>
    </html>";
}
?>
