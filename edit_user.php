<?php
session_start();
include('funciones.php');

verificarSesion();

$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id > 0) {
    $accion = "permiso_editar";
}else {
    $accion = "permiso_actualizar";
}

// Verificar permisos antes de mostrar el contenido
verificarPermisosUsuario('usuarios', $accion);

include_once 'db.php';
include_once 'includes/header.php';

$nombre = '';
$email = '';
$password = '';
$status = '';
$modulos = array("usuarios", "incidencias", "productos");
$permisos_usuario = array();

if ($id > 0) {
    // Obtener datos del usuario si estamos editando
    $sql = "SELECT * FROM usuario WHERE control_usu = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $email = $row['correo_usu'];
        $status = $row['status_usu'];
        
        $sql_permisos = "SELECT * FROM permiso_usuario WHERE control_usu = '$id'";
        $result_permisos = $conn->query($sql_permisos);

        while ($row_permisos = $result_permisos->fetch_assoc()) {
            $permisos_usuario[$row_permisos['modulo']] = $row_permisos;
        }
    
    } else {
        // Redirigir si el usuario no existe
        header("Location: users.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario cuando se envía
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    // Hash y salt de la contraseña
    $salt = bin2hex(random_bytes(16));
    $hashed_password = password_hash($salt . $password, PASSWORD_DEFAULT);

    // Actualizar la fecha de modificación
    $updated_at = date("Y-m-d H:i:s");

    if ($id > 0) {
        // Actualizar usuario existente
        $sql = "UPDATE usuario SET nombre='$nombre', correo_usu='$email', fi_usu='$updated_at', status_usu='$status'" . (!empty($_POST['password']) ? ", contrasena_usu='$hashed_password', salt='$salt'" : "") . "WHERE control_usu = $id";
    } else {
        // Insertar nuevo usuario
        $sql = "INSERT INTO usuario (nombre, correo_usu, contrasena_usu, salt, fi_usu) VALUES ('$nombre', '$email', '$hashed_password', '$salt', '$updated_at')";
        echo $sql;
    }

    if ($conn->query($sql) === TRUE) {
        // Después de insertar el nuevo usuario, obtén su ID
        $id_usuario = $id > 0? $id : $conn->insert_id;

        // Insertar permisos para el nuevo usuario en la tabla permiso_usuario
        foreach ($modulos as $modulo) {
            $leer = isset($_POST["permiso_leer_$modulo"]) ? 1 : 0;
            $eliminar = isset($_POST["permiso_eliminar_$modulo"]) ? 1 : 0;
            $editar = isset($_POST["permiso_editar_$modulo"]) ? 1 : 0;
            $actualizar = isset($_POST["permiso_actualizar_$modulo"]) ? 1 : 0;

            // Verificar si ya existe un registro para este usuario y módulo
            $sql_existencia = "SELECT id_permiso FROM permiso_usuario WHERE control_usu = '$id_usuario' AND modulo = '$modulo'";
            $result_existencia = $conn->query($sql_existencia);

            if ($result_existencia->num_rows > 0) {
                // Si existe, actualiza el registro
                $row = $result_existencia->fetch_assoc();
                $id_permiso = $row['id_permiso'];

                $sql_update_permisos = "UPDATE permiso_usuario SET permiso_leer = '$leer', permiso_eliminar = '$eliminar', permiso_editar = '$editar', permiso_actualizar = '$actualizar' WHERE id_permiso = '$id_permiso'";
                $conn->query($sql_update_permisos);
            } else {
                // Si no existe, inserta un nuevo registro
                $sql_insert_permisos = "INSERT INTO permiso_usuario (control_usu, modulo, permiso_leer, permiso_eliminar, permiso_editar, permiso_actualizar) VALUES ('$id_usuario', '$modulo', '$leer', '$eliminar', '$editar', '$actualizar')";
                $conn->query($sql_insert_permisos);
            }
        }

        header("Location: users.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container mt-3">
    <h2><?php echo ($id > 0) ? 'Editar Usuario' : 'Agregar Nuevo Usuario'; ?></h2>
    <form method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
         <div class="mb-3">
            <label for="status" class="form-label">Estado:</label>
            <select class="form-select" id="status" name="status" required>
                <option value="activo" <?php echo ($status == 'activo') ? 'selected' : ''; ?>>Activo</option>
                <option value="inactivo" <?php echo ($status == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" <?php echo ($id > 0) ? '' : 'required'; ?>>
        </div>

        <!-- Sección de Permisos por Módulo -->
        <?php foreach ($modulos as $modulo): ?>
            <div class="mb-3">
                <h3>Permisos para <?php echo ucfirst($modulo); ?>:</h3>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permiso_leer_<?php echo $modulo; ?>" value="1" <?php echo (isset($permisos_usuario[$modulo]) && $permisos_usuario[$modulo]['permiso_leer'] == 1) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="permiso_leer_<?php echo $modulo; ?>">
                        Leer en <?php echo $modulo; ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permiso_eliminar_<?php echo $modulo; ?>" value="1" <?php echo (isset($permisos_usuario[$modulo]) && $permisos_usuario[$modulo]['permiso_eliminar'] == 1) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="permiso_eliminar_<?php echo $modulo; ?>">
                        Eliminar en <?php echo $modulo; ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permiso_editar_<?php echo $modulo; ?>" value="1" <?php echo (isset($permisos_usuario[$modulo]) && $permisos_usuario[$modulo]['permiso_editar'] == 1) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="permiso_editar_<?php echo $modulo; ?>">
                        Editar en <?php echo $modulo; ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permiso_actualizar_<?php echo $modulo; ?>" value="1" <?php echo (isset($permisos_usuario[$modulo]) && $permisos_usuario[$modulo]['permiso_actualizar'] == 1) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="permiso_actualizar_<?php echo $modulo; ?>">
                        Agregar en <?php echo $modulo; ?>
                    </label>
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>