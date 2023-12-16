<?php
session_start();
include('funciones.php');

verificarSesion();
verificarPermisosUsuario('productos', "permiso_leer");

include 'includes/header.php';
include 'db.php';
?>
<div class="container mt-5">
<h2>Listado de productos</h2>

<?php
$sql = "SELECT p.control_pro, p.nombre, p.tipo, p.estatus, u.nombre as nombre_usu FROM productos p join usuario u on u.control_usu = p.control_usu";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nombre</th>';
    echo '<th>Tipo</th>';
    echo '<th>Estatus</th>';
    echo '<th>Registrado por</th>';
    echo '<th>Acciones</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['control_pro'] . '</td>';
        echo '<td>' . $row['nombre'] . '</td>';
        echo '<td>' . $row['tipo'] . '</td>';
        echo '<td>' . $row['estatus'] . '</td>';
        echo '<td>' . $row['nombre_usu'] . '</td>';
        echo '<td><a class="btn btn-primary" href="detalle_producto.php?id=' . $row['control_pro'] . '">Detalles</a></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo 'No hay productos registrados.';
}

$conn->close();

?>
</div>

<?php
include 'includes/footer.php';
?>
