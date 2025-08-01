<?php
session_start();
if (isset($_SESSION['admin'])) {
    header("Location: admin_servicios.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciar sesión - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Jost', sans-serif;
            background: #f0f8ff;
            color: #333;
        }
        .container {
            max-width: 400px;
            margin: 80px auto;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        label {
            font-weight: 600;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Iniciar sesión</h2>

        <?php if (isset($_GET["error"]) && $_GET["error"] == 1): ?>
            <p class="error">Usuario o contraseña incorrectos</p>
        <?php endif; ?>

        <form method="POST" action="validar_login.php">
            <label>Usuario:</label>
            <input type="text" name="usuario" required>

            <label>Contraseña:</label>
            <input type="password" name="contrasena" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
