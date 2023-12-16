<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["correo"])) {
    // Si no ha iniciado sesión, redirigir al formulario de inicio de sesión
    header("Location: login.html");
    exit();
}

$nombreUsuario = $_SESSION['correo'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-5">
        <h2>Bienvenido, <?php echo $nombreUsuario; ?></h2>

        <div class="row mt-4">
            <div class="col-md-4">
                <h3>Módulo de Usuarios</h3>
                <ul>
                    <li><a href="users.php">Listado de Usuarios</a></li>
                    <li><a href="edit_user.php">Agregar Usuario</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Módulo de Incidencias</h3>
                <ul>
                    <li><a href="listar_incidencias.php">Listado de Incidencias</a></li>
                    <li><a href="agregar_incidencia.php">Agregar Incidencia</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Módulo de Productos</h3>
                <ul>
                    <li><a href="listado_productos.php">Listado de Productos</a></li>
                    <li><a href="registro_producto.php">Agregar Producto</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-4">
            <a href="cerrar_sesion.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>