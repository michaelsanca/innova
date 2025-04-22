<?php
function conectarBD() {
    // Datos de conexión
    $host = "localhost";
    $user = "root"; // Usuario de la base de datos
    $pass = ""; // Contraseña del usuario
    $bd   = "academia"; // Nombre de la base de datos

    // Crear conexión
    $connect = mysqli_connect($host, $user, $pass, $bd);

    // Verificar conexión
    if (!$connect) {
        die("Error de conexión a la base de datos: " . mysqli_connect_error());
    }

    // Establecer codificación de caracteres
    if (!mysqli_set_charset($connect, "utf8mb4")) {
        die("Error al establecer la codificación UTF-8: " . mysqli_error($connect));
    }

    // Retornar conexión activa
    return $connect;
}
?>
