<?php
session_start();
include('funciones.php');

verificarSesion();
include 'db.php';

// Verificar si el formulario fue enviado
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id > 1) {
    $accion = "permiso_editar";
}else { 
    $accion = "permiso_actualizar";
}
verificarPermisosUsuario('productos', $accion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $estatus = 'activo';

    $claves = $_POST['clave'];
    $valores = $_POST['valor'];

    // Combina las claves y valores en un solo arreglo asociativo
    $caracteristicas = array_combine($claves, $valores);
    $caracteristicas = json_encode($caracteristicas);

    // Obtener el ID de usuario desde la sesión
    session_start();
    $control_usu = $_SESSION['id_usuario'];

    // Obtener la fecha actual
    $fechaentrada_pro = date("Y-m-d H:i:s");


    // Preparar la consulta SQL para la actualización

    if ($id > 0) {
        // Actualizar usuario existente
        $sql = "UPDATE productos SET nombre = ?, tipo = ?, fechaentrada_pro = ?, control_usu = ?, caracteristicas = ?, estatus = ? WHERE control_pro = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissi", $nombre, $tipo, $fechaentrada_pro, $control_usu, $caracteristicas, $estatus, $id);
    } else {
        // Insertar nuevo producto
        $sql = "INSERT INTO productos (nombre, tipo, fechaentrada_pro, control_usu, caracteristicas, estatus) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiss", $nombre, $tipo, $fechaentrada_pro, $control_usu, $caracteristicas, $estatus);
    }

    // Preparar la declaración y vincular parámetros

    // Ejecutar la consulta y verificar
    if ($stmt->execute()) {
        if ($id > 0) {
            echo "Producto actualizado correctamente.";
        }else {
            echo "Producto registrado correctamente.";
        }
        header("Location: listado_productos.php");
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else if (isset($_GET['id'])){
    // Obtener el ID del producto a editar desde la URL
    $id_producto = $_GET['id'];

    // Obtener los datos actuales del producto
    $sql = "SELECT * FROM productos WHERE control_pro = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el producto
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit();
    }

    // Cerrar la declaración
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Producto</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
</head>
<body>

<?php
include 'includes/menu.php'
?>

<div class="container mt-5">
  <h2><?php echo (isset($_GET['id'])? 'Actualizar': 'Registrar') ?> Producto</h2>
  <form method="post">

    <div class="form-group">
      <label for="nombre">Nombre del Producto:</label>
      <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>" required>
    </div>

    <div class="form-group">
      <label for="tipo">Tipo de Producto:</label>
      <input type="text" class="form-control typeahead" name="tipo" id="tipo" value="<?php echo $producto['tipo']; ?>" required>
    </div>

    <div class="form-group">
      <label for="caracteristicas">Características:</label>
      <div id="caracteristicas-container">
        <?php
        // Mostrar las características actuales
        $caracteristicas = json_decode($producto['caracteristicas'], true);
        if (!empty($caracteristicas)) {
            foreach ($caracteristicas as $clave => $valor) {
                echo '
                <div class="form-row mb-2">
                  <div class="col">
                    <input type="text" class="form-control" name="clave[]" placeholder="Clave" value="' . $clave . '" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" name="valor[]" placeholder="Valor" value="' . $valor . '" required>
                  </div>
                  <div class="col">
                    <button type="button" class="btn btn-danger" onclick="quitarCaracteristica(this)">Quitar</button>
                  </div>
                </div>';
            }
        }
        ?>
      </div>
      <button type="button" class="btn btn-primary" onclick="agregarCaracteristica()">Agregar Característica</button>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-success"><?php echo (isset($_GET['id'])? 'Actualizar': 'Registrar') ?> Producto</button>
    </div>
  </form>
</div>

<script>
// Función para agregar dinámicamente campos de características
function agregarCaracteristica() {
  const container = document.getElementById('caracteristicas-container');
  const nuevaCaracteristica = document.createElement('div');
  nuevaCaracteristica.className = 'form-row mb-2';
  nuevaCaracteristica.innerHTML = `
    <div class="col">
      <input type="text" class="form-control" name="clave[]" placeholder="Clave" required>
    </div>
    <div class="col">
      <input type="text" class="form-control" name="valor[]" placeholder="Valor" required>
    </div>
    <div class="col">
      <button type="button" class="btn btn-danger" onclick="quitarCaracteristica(this)">Quitar</button>
    </div>
  `;
  container.appendChild(nuevaCaracteristica);
}

// Función para quitar una característica
function quitarCaracteristica(btn) {
  const caracteristica = btn.parentNode.parentNode;
  const container = caracteristica.parentNode;
  container.removeChild(caracteristica);
}
</script>
<script>
$(document).ready(function() {
  // Configuración del autocompletado con typeahead.js
  var substringMatcher = function(strs) {
    return function findMatches(q, cb) {
      var matches, substringRegex;

      // Un array que se llenará con las coincidencias de subcadenas
      matches = [];

      // Expresión regular usada para determinar si una cadena contiene la subcadena `q`
      substrRegex = new RegExp(q, 'i');

      // Iterar a través del conjunto de cadenas y, para cualquier cadena que
      // contenga la subcadena `q`, agregarla al array `matches`
      $.each(strs, function(i, str) {
        if (substrRegex.test(str)) {
          matches.push(str);
        }
      });

      cb(matches);
    };
  };

  // Aplicar typeahead.js al campo de tipo de producto
  $('#tipo').typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  },
  {
    name: 'tiposDeProductos',
    source: function(query, syncResults, asyncResults) {
      $.get('procesar_sugerencias.php', { query: query }, function(data) {
        asyncResults(data);
      });
    }
  });
});
</script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
