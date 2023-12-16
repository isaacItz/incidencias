<?php
// procesar_sugerencias.php

// Conectar a la base de datos
include 'db.php';

// Consultar la lista de tipos de productos desde la base de datos
$sql = "SELECT DISTINCT tipo FROM productos";
$result = $conn->query($sql);

// Preparar un array para almacenar los resultados
$tiposDeProductos = array();

// Obtener los resultados de la consulta
while ($row = $result->fetch_assoc()) {
    $tiposDeProductos[] = $row['tipo'];
    //error_log($row['tipo']);
}

// Enviar la lista como JSON
header('Content-Type: application/json');
echo json_encode($tiposDeProductos);
?>
