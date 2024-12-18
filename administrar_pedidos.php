<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'floreria');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar cambios de estado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id'], $_POST['estado'])) {
    $pedido_id = intval($_POST['pedido_id']);
    $nuevo_estado = $conn->real_escape_string($_POST['estado']);

    $update_query = "UPDATE compras SET estado='$nuevo_estado' WHERE id=$pedido_id";
    if ($conn->query($update_query)) {
        $_SESSION['mensaje'] = "Estado actualizado correctamente para el pedido ID $pedido_id.";
    } else {
        $_SESSION['error'] = "Error al actualizar el estado: " . $conn->error;
    }
}

// Obtener los pedidos
$query = "SELECT * FROM compras";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Pedidos - Florería KB</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            text-align: center;
        }
        th, td {
            padding: 10px;
        }
        select {
            padding: 5px;
        }
        button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .mensaje {
            text-align: center;
            color: green;
            margin-bottom: 20px;
        }
        .error {
            text-align: center;
            color: red;
            margin-bottom: 20px;
        }
        .btn-regresar {
            display: block;
            width: 200px;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-regresar:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<h1 style="text-align: center;">Administrar Pedidos</h1>

<?php
if (isset($_SESSION['mensaje'])) {
    echo '<p class="mensaje">' . htmlspecialchars($_SESSION['mensaje']) . '</p>';
    unset($_SESSION['mensaje']);
}

if (isset($_SESSION['error'])) {
    echo '<p class="error">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}

if ($result->num_rows > 0) {
    echo '<form method="POST">';
    echo '<table>';
    echo '<tr><th>ID Pedido</th><th>Nombre Cliente</th><th>Correo</th><th>Dirección</th><th>Fecha</th><th>Estado</th><th>Acción</th></tr>';

    while ($pedido = $result->fetch_assoc()) {
        $pedido_id = $pedido['id'];
        $nombre_cliente = htmlspecialchars($pedido['nombre']);
        $correo = htmlspecialchars($pedido['email']);
        $direccion = htmlspecialchars($pedido['direccion']);
        $fecha = $pedido['fechahora_entrega'];
        $estado_actual = htmlspecialchars($pedido['estado']); // Recuperar el estado actual

        echo '<tr>';
        echo "<td>$pedido_id</td>";
        echo "<td>$nombre_cliente</td>";
        echo "<td>$correo</td>";
        echo "<td>$direccion</td>";
        echo "<td>$fecha</td>";
        echo "<td>
                <select name='estado'>
                    <option value='pendiente'" . ($estado_actual === 'pendiente' ? ' selected' : '') . ">Pendiente</option>
                    <option value='aceptado'" . ($estado_actual === 'aceptado' ? ' selected' : '') . ">Aceptado</option>
                    <option value='rechazado'" . ($estado_actual === 'rechazado' ? ' selected' : '') . ">Rechazado</option>
                </select>
              </td>";
        echo "<td>
                <button type='submit' name='pedido_id' value='$pedido_id'>Guardar</button>
              </td>";
        echo '</tr>';
    }

    echo '</table>';
    echo '</form>';
} else {
    echo '<p style="text-align: center;">No hay pedidos disponibles.</p>';
}

// Botón para regresar al panel de administración
echo '<a href="panel_admin.php" class="btn-regresar">Regresar al Panel</a>';

$conn->close();
?>

</body>
</html>
