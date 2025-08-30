<?php
session_start();
include("../includes/conexion.php");

if(!isset($_SESSION["id"])){
    header("Location: ../auth/login.php");
    exit;
}

$error = "";
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $titulo = trim($_POST["titulo"]);
    $descripcion = trim($_POST["descripcion"]);
    $estado = $_POST["estado"];
    $prioridad = $_POST["prioridad"];
    $fecha_vencimiento = $_POST["fecha_vencimiento"];
    $usuario_id = $_SESSION["id"];

    $stmt = $conn->prepare("INSERT INTO tareas(usuario_id, titulo, descripcion, estado, prioridad, fecha_vencimiento) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt = $conn->bind_param("isssss", $usuario_id, $titulo, $descripcion, $estado, $prioridad, $fecha_vencimiento);

    if($stmt->execute()){
        header("Location: ver.php");
        exit;
    } else {
        $error = "Error al crear la tarea.";

    }
    $stmt->close();
}  
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crear Tarea</title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Crear Nueva Tarea</h2>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="pendiente">Pendiente</option>
                <option value="completada">Completada</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Prioridad</label>
            <select name="prioridad" class="form-select">
                <option value="baja">Baja</option>
                <option value="media" selected>Media</option>
                <option value="alta">Alta</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de Vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="ver.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>