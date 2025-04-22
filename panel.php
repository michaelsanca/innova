<?php
require_once 'conexion.php';

$conexion = conectarBD();

// Función para obtener las imágenes
function obtenerImagenes($conexion) {
    $query = "SELECT * FROM galeria"; // Asegúrate de que el nombre de la tabla sea correcto
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Manejar la carga de la imagen
if (isset($_GET['action']) && $_GET['action'] == 'upload' && isset($_FILES['imagen'])) {
    $archivo = $_FILES['imagen'];
    
    // Verificar si el archivo fue cargado sin errores
    if ($archivo['error'] == 0) {
        // Definir el directorio donde se almacenarán las imágenes
        $directorio_destino = 'uploads/'; 
        $ruta_destino = $directorio_destino . basename($archivo['name']);
        
        // Verificar si el directorio de destino existe, si no lo crea
        if (!file_exists($directorio_destino)) {
            mkdir($directorio_destino, 0777, true); // Crear directorio con permisos 0777
        }

        // Mover el archivo al directorio de destino
        if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
            // Guardar la ruta en la base de datos
            $query = "INSERT INTO galeria (ruta) VALUES ('$ruta_destino')";
            $result = mysqli_query($conexion, $query);

            // Verificar si la consulta fue exitosa
            if ($result) {
                $mensaje = "Imagen subida con éxito!";
                // Redirigir a la misma página para evitar que la imagen se suba nuevamente al recargar
                header("Location: panel.php"); 
                exit();  // Importante para evitar que se siga ejecutando el código
            } else {
                $mensaje = "Error al guardar la imagen en la base de datos: " . mysqli_error($conexion);
            }
        } else {
            $mensaje = "Hubo un error al subir la imagen.";
        }
    } else {
        $mensaje = "Error al cargar el archivo.";
    }
}

// Eliminar una imagen
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_imagen = $_GET['id'];
    
    // Consultar la ruta de la imagen antes de eliminarla
    $query = "SELECT ruta FROM galeria WHERE id = $id_imagen";
    $resultado = mysqli_query($conexion, $query);
    
    if ($resultado) {
        $imagen = mysqli_fetch_assoc($resultado);
        
        // Verificar si la imagen existe
        if ($imagen) {
            $ruta_imagen = $imagen['ruta'];
            
            // Verificar si el archivo existe antes de intentar eliminarlo
            if (file_exists($ruta_imagen)) {
                // Eliminar el archivo físico del servidor
                if (unlink($ruta_imagen)) {
                    // Eliminar la entrada de la base de datos
                    $query_delete = "DELETE FROM galeria WHERE id = $id_imagen";
                    mysqli_query($conexion, $query_delete);
                    $mensaje = "Imagen eliminada correctamente.";
                } else {
                    $mensaje = "Error al eliminar el archivo.";
                }
            } else {
                $mensaje = "El archivo no existe.";
            }
        } else {
            $mensaje = "No se encontró la imagen en la base de datos.";
        }
    } else {
        $mensaje = "Error al obtener la imagen: " . mysqli_error($conexion);
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
  <style>
    body {
      font-family: 'Rockwell', sans-serif;
      background-color: rgb(110, 15, 12);
      padding: 0;
      margin: 0;
    }

    #seccion4 {
      max-width: 100%;
      overflow-y: auto;
      padding: 20px;
      border-radius: 15px;
      background-color: #f8f9fa;
      max-height: 80vh;
    }

    #seccion4 .card {
      width: 100%;
      height: 250px;
      overflow: hidden;
      border: 1px solid #ddd;
      border-radius: 10px;
    }

    #seccion4 .card-img-top {
      object-fit: cover;
      height: 150px;
      border-radius: 10px 10px 0 0;
    }

    #seccion4 .alert {
      margin-bottom: 20px;
    }

    .btn-success {
      background-color: #28a745; /* Color verde */
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      color: white;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 0.3s ease;
      margin-right: 15% !important;
    }

    .btn-success:hover {
      background-color: #218838; /* Color verde más oscuro al pasar el ratón */
    }
  </style>
</head>
<!-- Botón Salir -->
<div class="container">
    <div class="row">
        <div class="col-12 text-right mt-3">
            <a href="index.php" class="btn btn-success">Salir</a>
        </div>
    </div>
</div>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 p-4">
        <section id="seccion4" class="container mt-5">
            <h2 class="text-center mb-4">GALERIA</h2>
            <!-- Mostrar mensaje -->
            <?php if (isset($mensaje)): ?>
                <div class="alert alert-info text-center"><?= htmlspecialchars($mensaje) ?></div>
            <?php endif; ?>

            <form method="POST" action="panel.php?action=upload#seccion4" enctype="multipart/form-data" class="mb-5">
                <div class="mb-3">
                    <label for="imagen" class="form-label">Seleccionar Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Subir Imagen</button>
            </form>

            <!-- Mostrar imágenes en una galería -->
            <div class="row">
                <?php
                // Obtener imágenes desde la base de datos
                $imagenes = obtenerImagenes($conexion); 
                foreach ($imagenes as $img): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card" style="width: 100%; height: 250px; overflow: hidden;">
                            <img src="<?= htmlspecialchars($img['ruta']) ?>" 
                                class="card-img-top" 
                                alt="Imagen" 
                                style="object-fit: cover; height: 150px;">
                            <div class="card-body text-center">
                                <form method="GET" action="" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta imagen?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($img['id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cierra la conexión a la base de datos al final
mysqli_close($conexion);
?>
