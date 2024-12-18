<?php

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'floreria');

// Verificar conexión
if ($conn->connect_error) 
{
    die("Error de conexión: " . $conn->connect_error);
}

session_destroy();

header('Location: index.php');

exit;

?>
