<?php
session_start();
include('funciones.php');

verificarSesion();
verificarPermisosUsuario("incidencias", "permiso_actualizar");
include 'db.php';
include 'includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_producto = $_POST["id_producto"];
    $detalles = $_POST["detalles"];
    $fecha = date("Y-m-d H:i:s"); // Fecha actual
    $control_usu = $_SESSION["id_usuario"]; // Obtener el control_usu de la sesión

    // Validar el ID del Producto (puedes agregar más validaciones)
    // ...

    // Insertar la incidencia en la base de datos
    $sql = "INSERT INTO incidencia (detalles, fecha, control_usu, control_pro) VALUES ('$detalles', '$fecha', $control_usu, $id_producto)";
    if ($conn->query($sql) === TRUE) {
        echo "Incidencia registrada con éxito";
    } else {
        echo "Error al registrar la incidencia: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>

<div class="container mt-5">
  <h2>Registro de Incidencia</h2>
  <form id="formIncidencia" action="agregar_incidencia.php" method="post">
    <div class="form-group">
      <label for="id_producto">ID del Producto</label>
      <input type="text" class="form-control" id="id_producto" name="id_producto" required>
      <small id="productoInfo" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
      <label for="detalles">Detalles de la Incidencia</label>
      <textarea class="form-control" id="detalles" name="detalles" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Registrar Incidencia</button>
  </form>
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $('#id_producto').on('input', function() {
        var idProducto = $(this).val();
        if (idProducto !== "") {
            $.ajax({
                type: 'GET',
                url: 'obtener_producto.php',
                data: { id_producto: idProducto },
                success: function(response) {
                    $('#productoInfo').html(response);
                }
            });
        } else {
            $('#productoInfo').html('');
        }
    });
});
</script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>