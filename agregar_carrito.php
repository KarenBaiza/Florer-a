<?php

session_start();

// Verifica que el ID del producto esté en la URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegúrate de que sea un entero

    // Verifica si ya existe el carrito en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verifica si el producto ya está en el carrito
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad']++;
    } else {
        // Conexión a la base de datos para obtener información del producto
        $conn = new mysqli('localhost', 'root', '', 'floreria');

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $query = "SELECT * FROM arreglos WHERE id = $id";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $producto = $result->fetch_assoc();

            // Agregar el producto al carrito
            $_SESSION['carrito'][$id] = [
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => 1
            ];

            // Establecer el mensaje de éxito
            $_SESSION['mensaje'] = "Se agregó el producto \"" . $producto['nombre'] . "\" al carrito.";
        }

        $conn->close();
    }

    // Redirige de nuevo a la página principal
    header("Location: panel_usuario.php");
    exit();
} else {
    // Si no hay un ID válido, redirige a la página principal
    header("Location: panel_usuario.php");
    exit();
}
