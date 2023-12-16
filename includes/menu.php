    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usuariosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Usuarios
                    </a>
                    <div class="dropdown-menu" aria-labelledby="usuariosDropdown">
                        <a class="dropdown-item" href="users.php">Listar</a>
                        <a class="dropdown-item" href="edit_user.php">Agregar</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="incidenciasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Incidencias
                    </a>
                    <div class="dropdown-menu" aria-labelledby="incidenciasDropdown">
                        <a class="dropdown-item" href="listar_incidencias.php">Listar</a>
                        <a class="dropdown-item" href="agregar_incidencia.php">Agregar</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Productos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="productosDropdown">
                        <a class="dropdown-item" href="listado_productos.php">Listar</a>
                        <a class="dropdown-item" href="registro_producto.php">Agregar</a>
                    </div>
                </li>
            
                <li class="nav-item">
                    <a class="nav-link" href="cerrar_sesion.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>