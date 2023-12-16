<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_producto"])) {
    $idProducto = $_GET["id_producto"];

    // Realiza la consulta para obtener la información del producto
    $sql = "SELECT * FROM productos WHERE control_pro = $idProducto";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();

        // Decodificamos el JSON de características
        $caracteristicas = json_decode($producto['caracteristicas'], true);

        echo "<strong>Nombre:</strong> " . $producto['nombre'] . "<br>";

        // Mostramos las características en una tabla
        echo "<strong>Características:</strong>";
        echo "<table class='table'>";
        echo "<thead><tr><th>Clave</th><th>Valor</th></tr></thead>";
        echo "<tbody>";
        foreach ($caracteristicas as $clave => $valor) {
            echo "<tr><td>$clave</td><td>$valor</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No se encontró información para el ID del producto ingresado.";
    }
}

// Cerrar la conexión
$conn->close();
?>
