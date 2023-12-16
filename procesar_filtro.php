<?php
session_start();
include('funciones.php');

verificarSesion();
include 'db.php';
include 'includes/header.php';

// Recibir datos del formulario
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$estatus_incidencia = $_POST['estatus_incidencia'];
$filtro_producto = $_POST['filtro_producto'];
$usuario = $_POST['usuario'];
$tipo_producto = $_POST['tipo_producto'];

// Construir la consulta SQL
$sql = "SELECT i.id, i.detalles, i.fecha, p.nombre as producto, u.nombre as usuario, ai.estatus
        FROM incidencia i
        JOIN productos p ON i.control_pro = p.control_pro
        JOIN usuario u ON i.control_usu = u.control_usu
        LEFT JOIN
 (select 
 estatus, 
 id_incidencia 
	from avance_incidencia ai1 
		where ai1.id in 
			(select max(ai2.id) 
				from avance_incidencia ai2 
					group by id_incidencia))
                    ai on ai.id_incidencia = i.id
        WHERE 1";

// Agregar condiciones de filtro según los valores recibidos
if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $sql .= " AND i.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
}

if (!empty($estatus_incidencia)) {
    $sql .= " AND ai.estatus = '$estatus_incidencia'";
}

if (!empty($filtro_producto)) {
    $sql .= " AND p.nombre LIKE '%$filtro_producto%'";
}

if (!empty($usuario)) {
    $sql .= " AND u.nombre LIKE '%$usuario%'";
}

if (!empty($tipo_producto)) {
    $sql .= " AND p.tipo = '$tipo_producto'";
}

// Ejecutar la consulta SQL y mostrar resultados (puedes adaptarlo según tus necesidades)
$result = $conn->query($sql);
echo $sql;

// Muestra los resultados en una tabla
if ($result->num_rows > 0) {
    echo '<table class="table table-striped">';
    echo '<tr><th>ID</th><th>Detalles</th><th>Fecha</th><th>Producto</th><th>Usuario</th><th>Estatus</th><th>Acciones</th></tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['detalles'] . '</td>';
        echo '<td>' . $row['fecha'] . '</td>';
        echo '<td>' . $row['producto'] . '</td>';
        echo '<td>' . $row['usuario'] . '</td>';
        echo '<td>' . $row['estatus'] . '</td>';
        echo '<td>
        <a href="detalles_incidencia.php?id=' . $row['id'] . '" class="btn btn-primary">Detalles</a>
        </td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No hay incidencias registradas.';
}
$conn->close();
// ... mostrar resultados o realizar otras acciones ...
?>

<?php
include 'includes/footer.php';
?>