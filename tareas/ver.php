<?php
session_start();
include("../includes/conexion.php");
include("../includes/tema.php");

if(!isset($_SESSION["id"])){
    header("Location: ../auth/login.php");
    exit;
}

$usuario_id = $_SESSION["id"];

$result = $conn->prepare("SELECT id, titulo, descripcion, estado, prioridad, fecha_vencimiento FROM tareas WHERE usuario_id = ?");
$result->bind_param("i", $usuario_id);
$result->execute();
$res = $result->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mis Tareas</title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/tema.css" rel="stylesheet">
</head>
<body class="<?= $tema=='dark' ? 'dark-mode' : '' ?>">

<nav class="navbar navbar-expand-lg <?= $tema=='dark' ? 'navbar-dark bg-dark' : 'navbar-dark bg-primary' ?>">
  <div class="container">
    <a class="navbar-brand" href="#">Mis Tareas</a>
    <div class="d-flex align-items-center ms-auto">
      <div class="form-check form-switch m-0 d-flex align-items-center">
        <input class="form-check-input" type="checkbox" id="modoToggle" <?= $tema=='dark'?'checked':'' ?>>
        <label class="form-check-label ms-2 mb-0" for="modoToggle" style="color: inherit;">Modo Oscuro</label>
      </div>
    </div>
  </div>
</nav>

<div class="container mt-5">
    
    <table class="table table-striped <?= $tema=='dark'?'table-dark':'' ?>">
        <thead class="<?= $tema=='dark'?'table-dark':'table-light' ?>">
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Fecha de Vencimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?= $row['titulo'] ?></td>
                <td><?= $row['descripcion'] ?></td>
                <td><?= $row['estado'] ?></td>
                <td><?= $row['prioridad'] ?></td>
                <td><?= $row['fecha_vencimiento'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="mt-3">
        <a href="crear.php" class="btn btn-primary">Nueva Tarea</a>
        <a href="listar.php" class="btn btn-secondary">Regresar</a>
    </div>
</div>

<script src="../js/tema.js"></script>
</body>
</html>
