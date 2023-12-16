<?php
session_start();
include('funciones.php');

verificarSesion();
// Verificar permisos antes de mostrar el contenido
verificarPermisosUsuario('usuarios', 'permiso_eliminar');
include_once 'db.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id > 0) {
    // Eliminar usuario
    $sql = "UPDATE usuario set status_usu='inactivo' WHERE control_usu = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: users.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Redirigir si no hay ID válido
    header("Location: users.php");
    exit();
}
?>