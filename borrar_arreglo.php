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

    // Eliminar el arreglo de la base de datos
    $sql = "DELETE FROM arreglos WHERE id = $id";
    if ($conn->query($sql) === TRUE) 
    {
        echo "Arreglo eliminado correctamente.";
        header("Location: panel_admin.php"); // Redirigir al panel del administrador
        exit();
    } 
    else 
    {
        echo "Error al eliminar el arreglo: " . $conn->error;
    }
} 
else 
{
    die("No se proporcionó el ID del arreglo.");
}

$conn->close();
?>
