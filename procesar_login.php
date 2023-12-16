<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las credenciales del formulario
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    $resultado_validacion = validarCredenciales($correo, $contrasena);
    if ( $resultado_validacion === true) {
        // Credenciales válidas, iniciar sesión
        $_SESSION["correo"] = $correo;
        $_SESSION["id_usuario"] = obtenerIdUsuario($correo);


        // Redirigir al panel principal o a la página deseada
        header("Location: index.php");
        exit();
    } else if ( $resultado_validacion === false) {
        // Credenciales inválidas, mostrar un mensaje de error
        echo "Credenciales inválidas. Inténtalo de nuevo.";
        header("Location: credenciales_incorrectas.php");
    } else {
        echo "Usuario Inactivo";
        header("Location: usuario_inactivo.php");
    }
}

function validarCredenciales($correo, $contrasena) {
    global $conn; // Asume que $conn es tu conexión a la base de datos

    // Escapa las variables para evitar inyección SQL
    $correo = $conn->real_escape_string($correo);

    $sql = "SELECT control_usu, contrasena_usu, salt, status_usu FROM usuario WHERE correo_usu = '$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El usuario existe, verifica la contraseña
        $row = $result->fetch_assoc();
        $contrasenaAlmacenada = $row["contrasena_usu"];
        $salt = $row["salt"];
        $status = $row["status_usu"];

        $contrasenaConSalt = $salt . $contrasena;
        if (password_verify($contrasenaConSalt, $contrasenaAlmacenada)) {
            if ($status == "inactivo"){
                return "inactivo";
            }else {
                return true;
            }
        }
    }

    return false;
}

function obtenerIdUsuario($correo) {
    global $conn; // Asume que $conn es tu conexión a la base de datos

    // Escapa la variable para evitar inyección SQL
    $correo = $conn->real_escape_string($correo);

    $sql = "SELECT control_usu FROM usuario WHERE correo_usu = '$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["control_usu"];
    }

    return null;
}
?>