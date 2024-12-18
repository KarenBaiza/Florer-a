<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'floreria');

// Verificar conexión
if ($conn->connect_error) 
{
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_GET['id'])) 
{
    $id = $_GET['id'];

    // Consulta para obtener los datos del arreglo
    $sql = "SELECT * FROM arreglos WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        $arreglo = $result->fetch_assoc();
    } 
    else 
    {
        die("No se encontró el arreglo.");
    }
} 
else 
{
    die("No se proporcionó el ID del arreglo.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    // Obtener los nuevos datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen']; // Si no vas a cambiar la imagen, no es necesario

    // Actualizar el arreglo en la base de datos
    $sql = "UPDATE arreglos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', imagen='$imagen' WHERE id=$id";
    if ($conn->query($sql) === TRUE) 
    {
        echo "Arreglo actualizado correctamente.";
        header("Location: panel_admin.php"); // Redirigir después de la actualización
        exit();
    } 
    else 
    {
        echo "Error al actualizar el arreglo: " . $conn->error;
    }
}

?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Arreglo</title>

    <!-- Enlaza Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <style>
        body 
        {
            padding: 20px;
            background-color: #f4f6f9;
        }

        h2 
        {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container 
        {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        label 
        {
            font-weight: bold;
        }

        .btn-custom 
        {
            width: 100%;
        }

        .bg-beige 
        {
            background-color: #f5f5dc; /* Tono beige */
            color: #000; /* Texto negro */
        }
    </style>
    
</head>
<body>

    <h2>Editar Arreglo</h2>

    <div class="form-container">
        <form action="editar_arreglo.php?id=<?php echo $id; ?>" method="POST">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($arreglo['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea name="descripcion" class="form-control" required><?php echo htmlspecialchars($arreglo['descripcion']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" name="precio" class="form-control" value="<?php echo htmlspecialchars($arreglo['precio']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="text" name="imagen" class="form-control" value="<?php echo htmlspecialchars($arreglo['imagen']); ?>">
            </div>

            <button type="submit" class="btn bg-beige btn-custom">Actualizar</button>

        </form>
    </div>

</body>
</html>

<?php
$conn->close();
?>
