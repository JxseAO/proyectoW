<?php
session_start();
include("../includes/conexion.php");
include("../includes/tema.php");

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
    $etiquetas = trim($_POST["etiquetas"]);
    $usuario_id = $_SESSION["id"];

    $stmt = $conn->prepare("INSERT INTO tareas(usuario_id, titulo, descripcion, estado, prioridad, fecha_vencimiento, etiquetas) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $usuario_id, $titulo, $descripcion, $estado, $prioridad, $fecha_vencimiento, $etiquetas);
    if($stmt->execute()){
        header("Location: listar.php");
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
<link href="../css/tema.css" rel="stylesheet">
</head>
<body class="<?= $tema=='dark' ? 'dark-mode' : '' ?> <?= $tema=='dark' ? 'bg-dark text-light' : 'bg-light text-dark' ?>">


<!-- Navbar -->
<nav class="navbar navbar-expand-lg <?= $tema=='dark' ? 'navbar-dark bg-dark' : 'navbar-dark bg-primary' ?>">
  <div class="container">
    <a class="navbar-brand" href="#">Crear nueva tarea</a>
    <div class="d-flex align-items-center ms-auto">
      <div class="form-check form-switch m-0 d-flex align-items-center">
        <input class="form-check-input" type="checkbox" id="modoToggle" <?= $tema=='dark'?'checked':'' ?>>
        <label class="form-check-label ms-2 mb-0" for="modoToggle" style="color: inherit;">Tema</label>
      </div>
    </div>
  </div>
</nav>

<!-- Formulario -->
<div class="container mt-5">
    
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
        <div class="mb-3">
            <label class="form-label">Etiquetas (separadas por coma)</label>
            <input type="text" name="etiquetas" class="form-control" placeholder="ej: trabajo, urgente">
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="../js/tema.js"></script>
</body>
</html>
