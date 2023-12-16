<?php
session_start();

if (isset($_SESSION['formulario_visible']) && $_SESSION['formulario_visible'] === true) {

    ?>
<div class="container mt-5">
    <h2>Seguimiento de Incidencia</h2>

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
        <input type="hidden" name="control_usu" value="<?php echo $_SESSION['id_usuario']; ?>">

        <button type="submit" class="btn btn-primary">Registrar Avance</button>
    </form>
</div>
<?php
} else {
    // Redireccionar o mostrar un mensaje de error
    //header("Location: error.php");
    //exit();
}
?>
