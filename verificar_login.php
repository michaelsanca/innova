<?php
// Incluir conexión
require_once 'conexion.php';

if (isset($_GET['action']) && $_GET['action'] == 'upload' && isset($_FILES['ruta'])) {
    $archivo = $_FILES['ruta'];

    // Verificar si el archivo fue cargado sin errores
    if ($archivo['error'] == 0) {
        $directorio_destino = 'uploads/'; // Directorio donde guardar las imágenes
        $ruta_destino = $directorio_destino . basename($archivo['name']);
        
        // Verificar si el directorio de destino existe, si no lo crea
        if (!file_exists($directorio_destino)) {
            mkdir($directorio_destino, 0777, true);
        }

        // Mover el archivo al directorio de destino
        if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
            // Guardar la ruta en la base de datos
            $query = "INSERT INTO galeria (ruta) VALUES ('$ruta_destino')";
            $result = mysqli_query($conexion, $query);
            
            if ($result) {
                $mensaje = "Imagen subida con éxito!";
            } else {
                $mensaje = "Error al guardar la imagen en la base de datos.";
            }
        } else {
            $mensaje = "Hubo un error al subir la imagen.";
        }
    } else {
        $mensaje = "Error al cargar el archivo.";
    }
}

?>
