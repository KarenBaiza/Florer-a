<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'floreria');

// Verificar conexión
if ($conn->connect_error) 
{
    die("Error de conexión: " . $conn->connect_error);
}

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Recoge los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Manejo del archivo de imagen
    $imagen = $_FILES['imagen']['name'];
    $target_dir = "imagenes/"; // Directorio donde se guardarán las imágenes
    $target_file = $target_dir . basename($imagen);

    // Mueve la imagen al directorio de destino
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) 
    {
        // Prepara la consulta SQL
        $sql = "INSERT INTO arreglos (nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $nombre, $descripcion, $precio, $imagen);

        if ($stmt->execute()) 
        {
            $_SESSION['mensaje'] = "Arreglo agregado exitosamente.";
            header("Location: agregar_arreglo.php"); // Redirige al formulario después de agregar
            exit();
        } 
        else 
        {
            echo "Error al guardar el arreglo: " . $stmt->error;
        }

        $stmt->close();
    } 
    else 
    {
        echo "Error al subir la imagen.";
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Arreglo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-beige 
        {
            background-color: #f5f5dc; /* Tono beige */
            color: #000; /* Texto negro */
        }
    </style>


</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <!-- Encabezado con fondo beige -->
            <div class="card-header text-center bg-beige">
                <h3>Agregar Nuevo Arreglo</h3>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['mensaje'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario -->
                <form action="agregar_arreglo.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Arreglo:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ejemplo: Rosas Rojas" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="4" placeholder="Describe el arreglo" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio (MXN):</label>
                        <input type="number" class="form-control" name="precio" id="precio" min="0" placeholder="Ejemplo: 500" required>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen del Arreglo:</label>
                        <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-beige">Agregar Arreglo</button>
                        <a href="panel_admin.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
