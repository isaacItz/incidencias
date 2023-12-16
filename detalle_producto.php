<?php

session_start();
include('funciones.php');

verificarSesion();

$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Verificar permisos antes de mostrar el contenido
verificarPermisosUsuario('productos', "permiso_leer");

include 'db.php';
include 'includes/header.php';

$id_producto = $_GET['id'];

$sql = "SELECT * FROM productos WHERE control_pro = $id_producto";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $producto = $result->fetch_assoc();

    echo '<div class="container mt-5">';
    echo '<h2>Detalles del Producto</h2>';
    
    echo '<dl class="row">';
    echo '<dt class="col-sm-3">ID</dt><dd class="col-sm-9">' . $producto['control_pro'] . '</dd>';
    echo '<dt class="col-sm-3">Nombre</dt><dd class="col-sm-9">' . $producto['nombre'] . '</dd>';
    echo '<dt class="col-sm-3">Tipo</dt><dd class="col-sm-9">' . $producto['tipo'] . '</dd>';
    echo '<dt class="col-sm-3">Estatus</dt><dd class="col-sm-9">' . $producto['estatus'] . '</dd>';
    echo '<dt class="col-sm-3">Registrado el</dt><dd class="col-sm-9">' . $producto['fechaentrada_pro'] . '</dd>';
    echo '<dt class="col-sm-3">Registrado por</dt><dd class="col-sm-9">' . $producto['control_usu'] . '</dd>';
    // Agregar más detalles si es necesario

    echo '</dl>';
    // Mostrar las características
    echo '<dt class="col-sm-3">Características</dt>';
    echo '<dd class="col-sm-9">';
    echo '<ul>';
    
    $caracteristicas = json_decode($producto['caracteristicas'], true);

    foreach ($caracteristicas as $clave => $valor) {
        echo '<li><strong>' . $clave . ':</strong> ' . $valor . '</li>';
    }

    echo '</ul>';
    echo '</dd>';

    // Agregar más detalles si es necesario
    echo '</dl>';

    // Enlace para ver las incidencias asociadas a este producto
    //echo '<a href="incidencias_producto.php?id=' . $producto['control_pro'] . '" class="btn btn-primary">Ver Incidencias</a>';
    if (tienePermisosUsuario("incidencias", "permiso_leer")){

        echo '<div class="mt-4">';
        echo '<h3>Incidencias Relacionadas</h3>';
        // Obtener y mostrar incidencias relacionadas
        $sqlIncidencias = "SELECT * FROM incidencia WHERE control_pro = " . $producto['control_pro'];
        $resultIncidencias = $conn->query($sqlIncidencias);

        if ($resultIncidencias->num_rows > 0) {
            echo '<ul>';
            while ($incidencia = $resultIncidencias->fetch_assoc()) {
                echo '<li><a href="detalles_incidencia.php?id=' . $incidencia['id'] . '">' . $incidencia['detalles'] . '</a></li>';
            }
            echo '</ul>';
        } else {
            echo 'No hay incidencias relacionadas.';
        }
    }

    echo '<div class="mt-4">';
    echo '<h3>Acciones</h3>';

    if (tienePermisosUsuario("productos", "permiso_editar")){
    // Botón de Editar
    echo '<a href="registro_producto.php?id=' . $producto['control_pro'] . '" class="btn btn-primary mr-2">Editar</a>';
    }

    if (tienePermisosUsuario("productos", "permiso_eliminar")){
    // Botón de Eliminar (puedes agregar un modal de confirmación)
    echo '<button class="btn btn-danger" data-toggle="modal" data-target="#eliminarProductoModal">Eliminar</button>';
    }

    echo '</div>';

    echo '
    <div class="modal fade" id="eliminarProductoModal" tabindex="-1" role="dialog" aria-labelledby="eliminarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="eliminarProductoModalLabel">Eliminar Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ¿Estás seguro de que deseas eliminar este producto?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <a href="eliminar_producto.php?id=' . $producto['control_pro'] . '" class="btn btn-danger">Eliminar</a>
        </div>
        </div>
    </div>
    </div>';

    echo '</div>';

    echo '</div>';
} else {
    echo 'Producto no encontrado.';
}

// Cierre de la conexión y otros códigos necesarios
// ...
include 'includes/footer.php';
?>
