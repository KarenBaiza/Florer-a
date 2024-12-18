<?php
session_start(); // Inicia la sesión

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'floreria');

// Verificar conexión
if ($conn->connect_error)
{
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el inicio de sesión
if (isset($_POST['login'])) 
{
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consultar al usuario con el correo electrónico proporcionado
    $query = "SELECT * FROM usuarios WHERE email = '$usuario'";
    $result = mysqli_query($conn, $query);
    $usuario = mysqli_fetch_assoc($result);

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($usuario && password_verify($password, $usuario['password'])) 
    {
        $_SESSION['id'] = $usuario['id'];  // Guardar el ID del usuario en la sesión

        // Redirigir según el tipo de usuario
        if ($usuario['tipo_usuario'] == 'admin') 
        {
            header("Location: panel_admin.php"); // Redirigir al panel del administrador
        } 
        else 
        {
            header("Location: panel_usuario.php"); // Redirigir al panel del usuario normal
        }
        exit(); // Asegurarse de que no se ejecute código después de la redirección
    } 
    else 
    {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Contenedor y formulario -->
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100">
        <div class="col-md-6 mx-auto">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Inicio de sesión</h4>
                </div>

                <div class="card-body">
                    <!-- Mostrar error si el inicio de sesión falla -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <!-- Formulario de inicio de sesión -->
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingresa tu correo" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                        </div>

                        <div class="mt-3 text-center">
                            <button type="submit" name="login" class="btn btn-primary w-100">Iniciar sesión</button>
                        </div>
                    </form>

                    <!-- Enlace de registro para nuevos usuarios -->
                    <div class="mt-3 text-center">
                        <a href="registrar_usuarios.php" class="btn btn-link">¿No tienes cuenta? Regístrate</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
