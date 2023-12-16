<?php

session_start();
include('funciones.php');

verificarSesion();

verificarPermisosUsuario("incidencias", "permiso_leer");
include_once 'db.php';
include 'includes/header.php';

global $conn;

?>
<div class="container mt-5">
<h2>Listado de Incidencias</h2>
<!-- Agrega un botón con una flecha hacia abajo para mostrar/ocultar el formulario -->
<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#formularioFiltros" aria-expanded="false" aria-controls="formularioFiltros">
    Mostrar Filtros <i class="fa fa-chevron-down"></i>
</button>

<!-- Agrega un contenedor colapsable (collapse) para el formulario de filtros -->
<div class="collapse" id="formularioFiltros">
<form action="procesar_filtro.php" method="post">

    <!-- Otros campos de filtrado ... -->

    <div class="form-row">
        <!-- Campo de filtro por fecha de inicio -->
        <div class="form-group col-md-6">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio">
        </div>

        <!-- Campo de filtro por fecha fin -->
        <div class="form-group col-md-6">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
        </div>
    </div>

    <div class="form-row">
        <!-- Campo de filtro por estatus de incidencia -->
        <div class="form-group col-md-6">
            <label for="estatus_incidencia">Estatus Incidencia:</label>
            <select class="form-control" name="estatus_incidencia" id="estatus_incidencia">
                <option value="">Selecciona un estatus</option>
                <option value="atendiendo">Atendiendo</option>
                <option value="atendido">Atendido</option>
            </select>
        </div>

        <!-- Campo de filtro por producto -->
        <div class="form-group col-md-6">
            <label for="filtro_producto">Filtrar por Producto:</label>
            <input type="text" class="form-control" name="filtro_producto" id="filtro_producto" placeholder="Nombre del Producto">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="usuario">Nombre de Usuario:</label>
            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Nombre de Usuario">
        </div>
        <div class="form-group col-md-6">
            <label for="tipo">Tipo de producto:</label>
            <?php
                // ... tu código existente ...

                // Realiza una consulta para obtener los tipos de productos
                $query = "SELECT DISTINCT tipo FROM productos";
                $result = $conn->query($query);

                // Verifica si hay resultados
                if ($result->num_rows > 0) {
                    // Inicia el menú desplegable
                    echo '<select class="form-control" name="tipo_producto" id="tipo_producto">';
                    echo '<option value="">Selecciona un tipo</option>';

                    // Agrega las opciones al menú desplegable
                    while ($row = $result->fetch_assoc()) {
                        $tipo = $row['tipo'];
                        echo "<option value=\"$tipo\">$tipo</option>";
                    }

                    // Cierra el menú desplegable
                    echo '</select>';
                } else {
                    // No se encontraron tipos de productos
                    echo '<div class="alert alert-warning">No hay tipos de productos disponibles.</div>';
                }

                // ... tu código existente ...
            ?>

        </div>
    </div>

    <!-- Otros campos de filtrado ... -->

    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
</form>

</div>


<?php

$sql = "SELECT
    i.id,
    i.detalles,
    i.fecha,
    p.nombre as producto,
    u.nombre as usuario,
    ai.estatus as ultimo_status
 from incidencia i 
 join productos p on i.control_pro = p.control_pro 
 join usuario u on u.control_usu = i.control_usu
 left join 
 (select estatus, id_incidencia 
	from avance_incidencia ai1 
		where ai1.id in 
			(select max(ai2.id) 
				from avance_incidencia ai2 
					group by id_incidencia))
                    ai on ai.id_incidencia = i.id
        ORDER BY i.fecha DESC";

$result = $conn->query($sql);
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
        echo '<td>' . $row['ultimo_status'] . '</td>';
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
?>
</div>

<?php
/*
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
        LEFT JOIN avance_incidencia ai ON i.id = ai.id_incidencia
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

var_dump($result);
*/
// ... mostrar resultados o realizar otras acciones ...
?>

<?php
include 'includes/footer.php';
?>
