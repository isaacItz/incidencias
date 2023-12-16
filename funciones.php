<?php
include_once 'db.php';

function verificarSesion() {
    error_log("hola");
    if (!isset($_SESSION["correo"])) {
    // Si no ha iniciado sesión, redirigir al formulario de inicio de sesión
    header("Location: login.html");
    exit();
    }
}
function verificarPermisosUsuario($modulo, $accion) {
    // Verifica si el usuario tiene permisos
    // Puedes personalizar esta lógica según tu implementación de permisos
    
    // Por ejemplo, si estás utilizando una tabla de permisos en la base de datos:
    if (!tienePermiso($_SESSION['id_usuario'], $modulo, $accion)) {
        header("Location: acceso_denegado.php"); // Redirige a una página de acceso denegado
        exit();
    }
}

function tienePermisosUsuario($modulo, $accion) {
    //var_dump(tienePermiso($_SESSION['id_usuario'], $modulo, $accion));
    return tienePermiso($_SESSION['id_usuario'], $modulo, $accion);
}

function tienePermiso($idUsuario, $modulo, $accion) {
    global $conn;
    $control_usu = $_SESSION['id_usuario'];
    $sql_permisos = "SELECT $accion FROM permiso_usuario WHERE control_usu = $control_usu AND modulo = '$modulo'";
    error_log($sql_permisos);
    error_log($idUsuario);
    error_log($modulo);
    error_log("accion: " . $accion);
    $result_permisos = $conn->query($sql_permisos);

    //error_log(var_dump($result_permisos));
    if ($result_permisos->num_rows > 0) {
        $row_permisos = $result_permisos->fetch_assoc();
        $permiso = $row_permisos[$accion];

        // Verificar el permiso específico (en este caso, permiso de leer)
        if ($permiso == 1) {
            // El usuario tiene permiso de leer en el módulo actual
            //echo "El usuario tiene permiso en el módulo '$modulo'";
            return true;
        } else {
            // El usuario NO tiene permiso de leer en el módulo actual
            //echo "El usuario NO tiene permiso en el módulo '$modulo'";
            return false;
        }
    } else {
        // No se encontraron permisos para el usuario y el módulo
        //echo "No se encontraron permisos para el usuario y el módulo '$modulo'";
        return false;
    }

    return true; // Cambia esto según tu implementación real
}

function imprimir($text) {
    echo "<pre>";
    echo var_dump($text);
    echo "</pre>";
}
?>
