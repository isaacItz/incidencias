<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Menú de Módulos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="modulo_usuarios.php">Usuarios</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="listar_usuarios.php">Listar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="agregar_usuario.php">Agregar</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="modulo_incidencias.php">Incidencias</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="listar_incidencias.php">Listar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="agregar_incidencia.php">Agregar</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="modulo_productos.php">Productos</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="listar_productos.php">Listar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="agregar_producto.php">Agregar</a>
                        </li>
                    </ul>
                </li>
                <!-- Agrega más módulos según sea necesario -->
            </ul>
        </div>
    </nav>

    <!-- Contenido de la página -->
    <div class="container mt-5">
        <h1>Página Actual</h1>
        <!-- Contenido específico de la página actual -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
