<?php
session_start(); // Inicia la sesión

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'floreria');

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Si el usuario ya está logueado, redirigir al panel de administración
if (isset($_SESSION['admin'])) {
    header("Location: panel_admin.php"); // Redirigir al panel si ya está logueado
    exit();
}

// Procesar el inicio de sesión
if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consultar al administrador
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' OR correo = '$usuario'"; // Usamos correo o nombre de usuario
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin['id'];
        header("Location: panel_admin.php"); // Redirigir a la página principal del administrador si si se puedo iniciar sesion
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}

// Procesar el registro si se hace clic en "Registrar"
if (isset($_POST['registrar'])) {
    // Recibir los datos del formulario de registro
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Cifrar la contraseña
    $tipo_usuario = $_POST['tipo_usuario'];
    $direccion = $_POST['direccion'];
    $fecha_necesita = $_POST['fecha_necesita'];

    // Insertar el nuevo usuario en la base de datos
    $query = "INSERT INTO usuarios (nombre, tipo_usuario, email, password)
              VALUES ('$nombre_usuario', '$tipo_usuario' '$correo', '$password')";
    
    if (mysqli_query($conn, $query)) {
        echo "Registro exitoso. Ahora puedes iniciar sesión.";
    } else {
        echo "Error al registrar el usuario: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-beige {
            background-color: #f5f5dc; 
            color: #000; 
            border: 1px solid #ccc; 
        }
        .btn-beige:hover {
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
                    <h4><i class="fas fa-user-lock"></i> Inicio de sesión </h4>
                </div>

                <div class="card-body">
                    <!-- Mostrar error si el inicio de sesión falla -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center"> <?php echo $error; ?> </div>
                    <?php endif; ?>

                    <!-- Formulario de inicio de sesión -->
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="usuario" class="form-label"> <i class="fas fa-user"></i> Correo </label>
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingresa tu usuario o correo" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"> <i class="fas fa-key"></i> Contraseña </label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                        </div>

                        <div class="mt-3 text-center">
                            <button type="submit" name="login" class="btn btn-beige w-100"> <i class="fas fa-sign-in-alt"></i> Iniciar sesión  </button>
                        </div>
                    </form>

                    <!-- Enlace de registro para nuevos usuarios -->
                    <div class="mt-3 text-center">
                        <a href="registar_usuario.php" class="btn btn-link">¿No tienes cuenta? Regístrate</a>
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
