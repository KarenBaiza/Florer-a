<?php
session_start(); // Inicia la sesión

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'floreria');

// Verificar conexión
if ($conn->connect_error) 
{
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el registro si se hace clic en "Registrar"
if (isset($_POST['registrar'])) 
{
    // Recibir los datos del formulario de registro
    $nombre_usuario = $_POST['nombre'];
    $correo = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Cifrar la contraseña
    $tipo_usuario = $_POST['tipo_usuario'];


    // Consulta preparada para evitar inyecciones SQL
    $query = $conn->prepare("INSERT INTO usuarios (nombre, tipo_usuario, email, password) VALUES (?, ?, ?, ?)");
    $query->bind_param("ssss", $nombre_usuario, $tipo_usuario, $correo, $password);

    if ($query->execute()) 
    {
        echo "<div class='alert alert-success text-center'>Registro exitoso. Ahora puedes iniciar sesión.</div>";
    } 
    else 
    {
        echo "<div class='alert alert-danger text-center'>Error al registrar el usuario: " . $query->error . "</div>";
    }
}
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-beige 
        {
            background-color: #f5f5dc; 
            color: #000; 
            border: 1px solid #ccc; 
        }
        .btn-beige:hover 
        {
            background-color: #e8e8c8;
            color: #000;
        }
    </style>
</head>
<body>

<!-- Contenedor y formulario -->
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100">
        <div class="col-md-6 mx-auto">
            <div class="card shadow">
                <div class="card-header custom-bg-beige text-center">
                    <h4><i class="fas fa-user-plus"></i> Registro de Usuario </h4>
                </div>

                <div class="card-body">
                    <!-- Formulario de registro -->
                    <form action="registrar_usuarios.php" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre de usuario" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_usuario" class="form-label">Tipo de usuario</label>
                            <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                                <option value="usuario">usuario</option>
                                <option value="admin">admin</option>
                            </select>
                        </div>

                        <div class="mt-3 text-center">
                            <button type="submit" name="registrar" class="btn btn-beige w-100"> <i class="fas fa-user-plus"></i> Registrar </button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="login.php" class="btn btn-link">¿Ya tienes cuenta? Inicia sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
