<?php
$conexion = new mysqli("localhost", "root", "", "consultorio");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
$resultado = $conexion->query("SELECT * FROM servicios");
$servicios = [];
while ($fila = $resultado->fetch_assoc()) {
    $servicios[] = $fila;
}
header('Content-Type: application/json');
echo json_encode($servicios);
?>