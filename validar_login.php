<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $conexion = new mysqli("localhost", "root", "", "consultorio");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios_admin WHERE usuario = ? AND contrasena = ?";
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $usuario, $contrasena);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $_SESSION['admin'] = $usuario;
            header("Location: admin_servicios.php");
            exit();
        } else {
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        header("Location: login.php?error=2");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
