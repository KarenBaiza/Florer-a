<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'floreria');

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los arreglos
$sql = "SELECT * FROM arreglos ORDER BY id ASC"; // Ordena por ID de manera ascendente
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Florería KB</title>

    <!-- Código del tipo de letra que usaré en el título -->
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">

    <!-- Enlaza las páginas a esta -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

    <header class="header">
        <h1>Floreria KB</h1>
        <a href="index.html">
            <img class="header-logo" src="Imagenes/logo1.png" alt="logo">
        </a>
    </header>

    <!-- Opciones de la barra de menú -->
    <nav class="barraMenu">
        <a class="barraMenu-enlace barraMenu-enlace-activo" href="index.php">Inicio</a>
        <a class="barraMenu-enlace" href="sobre_mi.php">Sobre mí</a>
        <a class="barraMenu-enlace" href="login.php">Iniciar sesión</a>
    </nav>

    <!-- Imagen principal -->
    <section class="imagen-principal">
        <div class="contenido-imagen-principal">
            <h2>"La belleza florece en cada detalle"</h2>
            <div class="ubicacion">
                <!-- Icono de ubicación -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin-down" width="72" height="72" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    <path d="M12.736 21.345a2 2 0 0 1 -2.149 -.445l-4.244 -4.243a8 8 0 1 1 13.59 -4.624" />
                    <path d="M19 16v6" />
                    <path d="M22 19l-3 3l-3 -3" />
                </svg>
                <p>Culiacán, Sinaloa</p>
            </div>
            <a class="boton" href="https://wa.me/526677852219?text=¡Hola!%20Estoy%20interesado%20en%20sus%20arreglos%20florales." target="_blank">Contactar</a>
        </div>
    </section>

    <main class="contenedor">
        <h2>Arreglos</h2>

        <!-- GRID contiene todas las imágenes de las flores -->
        <div class="grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="producto">
                        <a href="producto-html">
                            <img class="producto-imagen" src="imagenes/' . htmlspecialchars($row['imagen']) . '" alt="' . htmlspecialchars($row['nombre']) . '">
                            <div class="producto-informacion">
                                <p class="producto-descripcion">' . htmlspecialchars($row['descripcion']) . '</p>
                                <p class="producto-precio">$' . number_format($row['precio'], 2) . '</p>
                            </div>
                        </a>
                    </div>';
                }
            } else {
                echo '<p class="text-center">No hay arreglos disponibles por ahora.</p>';
            }
            ?>
        </div>
    </main>

    <footer>
        <p class="footer-texto">Frontend - Todos los derechos reservados. Karen Baiza</p>
    </footer>

</body>
</html>

<?php
$conn->close();
?>
