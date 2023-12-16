<?php
session_start();
include('funciones.php');

verificarSesion();

// Verificar permisos antes de mostrar el contenido
verificarPermisosUsuario('usuarios', 'permiso_leer');
include_once 'db.php';
include_once 'includes/header.php';
?>

<div class="container mt-3">
  <h2>Lista de Usuarios</h2>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Status</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM usuario";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['control_usu'] . "</td>";
              echo "<td>" . $row['nombre'] . "</td>";
              echo "<td>" . $row['correo_usu'] . "</td>";
              echo "<td>" . $row['status_usu'] . "</td>";
              echo "<td>
                      <a href='edit_user.php?id=" . $row['control_usu'] . "' class='btn btn-primary btn-sm'>Editar</a>
                      <a href='delete_user.php?id=" . $row['control_usu'] . "' class='btn btn-danger btn-sm'>Eliminar</a>
                    </td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No hay usuarios</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php include_once 'includes/footer.php'; ?>
