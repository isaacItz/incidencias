<?php

session_start();
include('funciones.php');

verificarSesion();


verificarPermisosUsuario("incidencias", "permiso_editar");
// Incluye tu archivo de conexión a la base de datos
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $avance = $_POST["avance"];
    $estatus = $_POST["estatus"];
    $id_incidencia = $_POST["id_incidencia"];
    $control_usu = $_POST["control_usu"];

    // Insertar datos en la tabla avance_incidencia
    $sql = "INSERT INTO avance_incidencia (id_incidencia, control_usu, avances, estatus, fecha)
            VALUES ('$id_incidencia', '$control_usu', '$avance', '$estatus', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Éxito al registrar el avance
        header("Location: detalles_incidencia.php?id=$id_incidencia&success=1");
        exit();
    } else {
        // Error al registrar el avance
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>