<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) 
{
    header("Location: panel_usuario.php");
    exit();
}

// Verificar si el carrito está vacío
if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0) {
    header("Location: panel_usuario.php"); // Redirige si el carrito está vacío
    exit();
}



// Procesar la finalización de la compra
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nombre'], $_POST['direccion'], $_POST['email'], $_POST['fechahora_entrega'], $_POST['metodo_pago'])) {
        $conn = new mysqli('localhost', 'root', '', 'floreria');

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $id_usuario = $_SESSION['id_usuario'] ?? null;
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $direccion = $conn->real_escape_string($_POST['direccion']);
        $email = $conn->real_escape_string($_POST['email']);
        $fechahora_entrega = $conn->real_escape_string($_POST['fechahora_entrega']);
        $metodo_pago = $conn->real_escape_string($_POST['metodo_pago']);
        $numero_tarjeta = $metodo_pago === 'tarjeta' ? $conn->real_escape_string($_POST['numero_tarjeta']) : null;
        $nombre_titular = $metodo_pago === 'tarjeta' ? $conn->real_escape_string($_POST['nombre_titular']) : null;
        $fecha_expiracion = $metodo_pago === 'tarjeta' ? $conn->real_escape_string($_POST['fecha_expiracion']) : null;
        $cvv = $metodo_pago === 'tarjeta' ? $conn->real_escape_string($_POST['cvv']) : null;

        // Insertar datos en la tabla de compras
        $query = "INSERT INTO compras (nombre, direccion, email, metodo_pago, id_usuario, fechahora_entrega, estado)
                  VALUES ('$nombre', '$direccion', '$email', '$metodo_pago', '$id_usuario', '$fechahora_entrega', 'pendiente')";

        if ($conn->query($query)) {
            $compra_id = $conn->insert_id;

            // Insertar los detalles del carrito en la tabla de detalle_compra
            foreach ($_SESSION['carrito'] as $producto) {
                $arreglo_id = $producto['id'];
                $cantidad = $producto['cantidad'];
                $precio = $producto['precio'];
                $subtotal = $precio * $cantidad;

                $query_detalle = "INSERT INTO detalle_compra (compra_id, arreglo_id, cantidad, precio, subtotal)
                                  VALUES ('$compra_id', '$arreglo_id', '$cantidad', '$precio', '$subtotal')";
                $conn->query($query_detalle);
            }

            // Vaciar el carrito y mostrar mensaje de éxito
            unset($_SESSION['carrito']);
            $mensaje = "¡Pago exitoso! Gracias por tu compra.";
        } else {
            $mensaje = "Error al procesar la compra. Por favor, inténtalo de nuevo.";
        }
        $conn->close();
    } else {
        $mensaje = "Completa todos los campos.";
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Florería KB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: white;
        }

        h1 {
            text-align: center;
            color: black;
            margin-top: 20px;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, textarea, select, button {
            width: 100%;
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            background: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: white;
        }

        #campos_tarjeta {
            display: none;
        }

        .mensaje {
            max-width: 600px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }

        .mensaje-exito {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .mensaje-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
    <script>
        function mostrarCamposTarjeta() {
            const metodoPago = document.getElementById('metodo_pago').value;
            const camposTarjeta = document.getElementById('campos_tarjeta');
            camposTarjeta.style.display = (metodoPago === 'tarjeta') ? 'block' : 'none';
        }
    </script>
</head>
<body>

<h1>Finalizar Compra</h1>

<?php
if (isset($_SESSION['mensaje'])) {
    $tipoMensaje = strpos($_SESSION['mensaje'], 'éxito') !== false ? 'mensaje-exito' : 'mensaje-error';
    echo '<div class="mensaje ' . $tipoMensaje . '">' . htmlspecialchars($_SESSION['mensaje']) . '</div>';
    unset($_SESSION['mensaje']);
}
?>

<form method="POST">
    <label for="nombre">Nombre Completo:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="direccion">Dirección de Envío:</label>
    <textarea id="direccion" name="direccion" rows="3" required></textarea>

    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>

    <label for="fechahora_entrega">Fecha y Hora de Entrega:</label>
    <input type="datetime-local" id="fechahora_entrega" name="fechahora_entrega" required>

    <label for="metodo_pago">Método de Pago:</label>
    <select id="metodo_pago" name="metodo_pago" onchange="mostrarCamposTarjeta()" required>
        <option value="tarjeta">Tarjeta de Crédito/Débito</option>
        <option value="paypal">PayPal</option>
        <option value="transferencia">Transferencia Bancaria</option>
    </select>

    <div id="campos_tarjeta">
        <label for="numero_tarjeta">Número de Tarjeta:</label>
        <input type="text" id="numero_tarjeta" name="numero_tarjeta" maxlength="19" placeholder="1234 5678 9012 3456">

        <label for="nombre_titular">Nombre del Titular:</label>
        <input type="text" id="nombre_titular" name="nombre_titular" placeholder="Como aparece en la tarjeta">

        <label for="fecha_expiracion">Fecha de Expiración (MM/AA):</label>
        <input type="text" id="fecha_expiracion" name="fecha_expiracion" maxlength="5" placeholder="MM/AA">

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" maxlength="3" placeholder="123">
    </div>

    <button type="submit"> Pagar </button>
</form>

</body>
</html>
