<?php

session_start();
include('funciones.php');

verificarSesion();
verificarPermisosUsuario("incidencias", "permiso_leer");

include 'db.php';
include 'includes/header.php';

?>

<div class="container mt-5">
    <?php
    // Obtén el id de la incidencia de los parámetros de la URL
    $id_incidencia = $_GET['id'] ?? null;

    // Realiza la consulta para obtener los detalles de la incidencia
    // (Asegúrate de escapar y validar los datos antes de usarlos en la consulta real)
    $detalles_incidencia = obtenerDetallesIncidencia($id_incidencia);

    if ($detalles_incidencia) {
        echo '<h2>Detalles de la Incidencia</h2>';
        echo '<p><strong>ID:</strong> ' . $detalles_incidencia['id'] . '</p>';
        echo '<p><strong>Detalles:</strong> ' . $detalles_incidencia['detalles'] . '</p>';
        echo '<p><strong>Fecha:</strong> ' . $detalles_incidencia['fecha'] . '</p>';
        echo '<p><strong>Producto:</strong> ' . $detalles_incidencia['producto'] . '</p>';
        echo '<p><strong>Usuario:</strong> ' . $detalles_incidencia['usuario'] . '</p>';

        // Obtén y muestra los registros de seguimiento de la incidencia
        $seguimiento_incidencia = obtenerSeguimientoIncidencia($id_incidencia);

        if ($seguimiento_incidencia) {
            echo '<h3>Seguimiento de la Incidencia</h3>';
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>ID</th><th>Avances</th><th>Estatus</th><th>Fecha</th></tr></thead>';
            echo '<tbody>';

            foreach ($seguimiento_incidencia as $registro) {
                echo '<tr>';
                echo '<td>' . $registro['id'] . '</td>';
                echo '<td>' . $registro['avances'] . '</td>';
                echo '<td>' . $registro['estatus'] . '</td>';
                echo '<td>' . $registro['fecha'] . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No hay registros de seguimiento para esta incidencia.</p>';
        }
    } else {
        echo '<p>No se encontró la incidencia.</p>';
    }
    ?>

    <a href="listar_incidencias.php" class="btn btn-secondary">Volver al Listado de Incidencias</a>
</div>

<?php
    if (tienePermisosUsuario("incidencias", "permiso_editar")) {
        //$_SESSION['formulario_visible'] = true;
        include 'formulario_avance_incidencia.php';
    }
    ?>

<?php
include 'includes/footer.php';
?>

<?php
function obtenerDetallesIncidencia($id_incidencia) {
    global $conn;  
    $id_incidencia = $conn->real_escape_string($id_incidencia);

    $sql = "SELECT i.id, i.detalles, i.fecha, p.nombre as producto, u.nombre as usuario
            FROM incidencia i
            INNER JOIN productos p ON i.control_pro = p.control_pro
            INNER JOIN usuario u ON i.control_usu = u.control_usu
            WHERE i.id = $id_incidencia";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
?>

<?php
function obtenerSeguimientoIncidencia($id_incidencia) {
    global $conn;  
    $id_incidencia = $conn->real_escape_string($id_incidencia);

    $sql = "SELECT a.id, a.avances, a.estatus, a.fecha, u.nombre as usuario
            FROM avance_incidencia a
            INNER JOIN usuario u ON a.control_usu = u.control_usu
            WHERE a.id_incidencia = $id_incidencia";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return null;
    }
}
?>


