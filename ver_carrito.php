<?php
session_start();

// Función para manejar la eliminación de productos del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
    $id = intval($_POST['eliminar_id']); // Obtiene el ID del producto a eliminar

    if (isset($_SESSION['carrito'][$id])) {
        unset($_SESSION['carrito'][$id]); // Elimina el producto del carrito
        $_SESSION['mensaje'] = "El producto fue eliminado del carrito."; // Mensaje de confirmación
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Florería KB</title>
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
        .total {
            font-weight: bold;
            font-size: 1.2em;
        }
        .acciones button {
            padding: 5px 10px;
            border: none;
            background-color: #dc3545;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }
        .acciones button:hover {
            background-color: #c82333;
        }
        .mensaje {
            text-align: center;
            margin: 10px auto;
            padding: 10px;
            max-width: 80%;
            border-radius: 5px;
        }
        .mensaje-exito {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        

    </style>
</head>
<body>

<h1 style="text-align: center;">Carrito de Compras</h1>

<!-- Mostrar mensajes -->
<?php
if (isset($_SESSION['mensaje'])) {
    echo '<div class="mensaje mensaje-exito">' . htmlspecialchars($_SESSION['mensaje']) . '</div>';
    unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
}
?>

<?php
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    echo '<table>';
    echo '<tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Acciones</th></tr>';

    $total = 0;

    foreach ($_SESSION['carrito'] as $id => $producto) {
        $subtotal = $producto['precio'] * $producto['cantidad'];
        $total += $subtotal;

        echo '<tr>';
        echo '<td>' . htmlspecialchars($producto['nombre']) . '</td>';
        echo '<td>$' . number_format($producto['precio'], 2) . '</td>';
        echo '<td>' . $producto['cantidad'] . '</td>';
        echo '<td>$' . number_format($subtotal, 2) . '</td>';
        echo '<td class="acciones">
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="eliminar_id" value="' . $id . '">
                    <button type="submit">Eliminar</button>
                </form>
              </td>';
        echo '</tr>';
    }

    echo '<tr>';
    echo '<td colspan="3" class="total">Total</td>';
    echo '<td class="total">$' . number_format($total, 2) . '</td>';
    echo '<td></td>';
    echo '</tr>';
    echo '</table>';
    echo '<div style="text-align: center; margin: 20px;">
            <a href="panel_usuario.php" style="padding: 10px 20px; text-decoration: none; background-color: beige; color: black; border-radius: 5px;">Seguir comprando</a>
            <a href="finalizar_compra.php" style="padding: 10px 20px; text-decoration: none; background-color: #007bff; color: white; border-radius: 5px;">Finalizar Compra</a>
          </div>';
} else {
    echo '<p style="text-align: center;">El carrito está vacío.</p>';
    echo '<div style="text-align: center;">
            <a href="panel_usuario.php" style="padding: 10px 20px; text-decoration: none; background-color: #28a745; color: white; border-radius: 5px;">Volver a la tienda</a>
          </div>';
}
?>

</body>
</html>
