<?php
session_start();
include('funciones.php');

verificarSesion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $avance = $_POST["avance"];
    $estatus = $_POST["estatus"];
    $id_incidencia = $_POST["id_incidencia"];
    $control_usu = $_POST["control_usu"];

    // Realiza la inserción en la tabla avance_incidencia con los datos proporcionados
    // Puedes usar una consulta SQL para insertar estos datos en la base de datos

    // Después de realizar la inserción, puedes redirigir al usuario a la página de seguimiento
    header("Location: seguimiento_incidencia.php?id_incidencia=$id_incidencia&control_usu=$control_usu");
    exit();
}

?>
<div class="container mt-5">
    <h2>Seguimiento de Incidencia</h2>

    <!-- Aquí van los detalles de la incidencia -->

    <!-- Formulario para registrar avances -->
    <form method="POST" action="procesar_avance_incidencia.php" class="mt-4">
        <div class="form-group">
            <label for="avance">Avance:</label>
            <textarea class="form-control" name="avance" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="estatus">Estatus:</label>
            <select class="form-control" name="estatus" required>
                <option value="atendiendo">Atendiendo</option>
                <option value="atendido">Atendido</option>
            </select>
        </div>

        <input type="hidden" name="id_incidencia" value="<?php echo $id_incidencia; ?>">
        <input type="hidden" name="control_usu" value="<?php echo $control_usu; ?>">

        <button type="submit" class="btn btn-primary">Registrar Avance</button>
    </form>
</div>
