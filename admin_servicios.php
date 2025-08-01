<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "consultorio");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && is_numeric($_POST["id"]) && isset($_POST["nombre"])) {
    $id = (int) $_POST["id"];
    $nombre = trim($_POST["nombre"]);
    $imagen = "";

    if (empty($nombre)) {
        $mensaje = "<p style='color:red;text-align:center;'>El nombre del servicio no puede estar vacío.</p>";
    } else {
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"]) {
            $imagen = "img/" . basename($_FILES["imagen"]["name"]);
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagen);

            $stmt = $conexion->prepare("UPDATE servicios SET nombre = ?, imagen = ? WHERE id = ?");
            $stmt->bind_param("ssi", $nombre, $imagen, $id);
        } else {
            $stmt = $conexion->prepare("UPDATE servicios SET nombre = ? WHERE id = ?");
            $stmt->bind_param("si", $nombre, $id);
        }

        if ($stmt->execute()) {
            $mensaje = "<p style='color:green;text-align:center;'>Servicio actualizado correctamente.</p>";
        } else {
            $mensaje = "<p style='color:red;text-align:center;'>Error al actualizar: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}

$resultado = $conexion->query("SELECT * FROM servicios");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Administrador de Servicios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Jost', sans-serif;
            background: #e9f1f7;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 60px auto;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        label, select, input[type="text"], input[type="file"] {
            width: 100%;
            margin-bottom: 15px;
        }
        input, select {
            padding: 10px;
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
        .logout-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .logout-link:hover {
            text-decoration: underline;
        }
        img {
            display: block;
            margin: 10px auto;
            max-width: 100px;
            border-radius: 10px;
        }
        .mensaje {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Servicios</h1>
        <a class="logout-link" href="logout.php">Cerrar sesión</a>

        <?= $mensaje ?>

        <form method="POST" enctype="multipart/form-data">
            <label for="id">Selecciona un servicio:</label>
            <select name="id" onchange="this.form.submit()">
                <option value="">-- Selecciona --</option>
                <?php
                if ($resultado) {
                    $resultado->data_seek(0);
                    while ($s = $resultado->fetch_assoc()):
                ?>
                    <option value="<?= $s['id'] ?>" <?= (isset($_POST['id']) && $_POST['id'] == $s['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['nombre']) ?>
                    </option>
                <?php endwhile; } ?>
            </select>
        </form>

        <?php
        if (isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] != ""):
            $id = (int) $_POST['id'];
            $query = $conexion->prepare("SELECT * FROM servicios WHERE id = ?");
            $query->bind_param("i", $id);
            $query->execute();
            $resultado_servicio = $query->get_result();
            $serv = $resultado_servicio->fetch_assoc();

            if ($serv):
        ?>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $serv['id'] ?>">

                <label>Nombre del servicio:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($serv['nombre']) ?>">

                <label>Imagen actual:</label>
                <img src="<?= htmlspecialchars($serv['imagen']) ?>" alt="Imagen actual">

                <label>Subir nueva imagen:</label>
                <input type="file" name="imagen">

                <button type="submit">Guardar cambios</button>
            </form>
        <?php
            endif;
            $query->close();
        endif;
        ?>
    </div>
</body>
</html>
