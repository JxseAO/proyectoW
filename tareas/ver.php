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

<!-- SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js" crossorigin="anonymous"></script>

<style>
/* 🔧 Indicador visual mientras arrastras */
.dragging {
    opacity: 0.6;
    background-color: #cce5ff !important;
}
.drag-handle {
    cursor: grab;
}
</style>
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
                <th></th> <!-- columna para arrastrar -->
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Fecha de Vencimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tabla-tareas">
            <?php while($row = $res->fetch_assoc()): ?>
            <tr data-id="<?= $row['id'] ?>">
                <td class="drag-handle">☰</td>
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
        <a href="exportar_pdf.php" class="btn btn-danger">Exportar PDF</a>
    </div>
</div>

<script src="../js/tema.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    new Sortable(document.getElementById('tabla-tareas'), {
        handle: ".drag-handle",  // ahora solo se puede arrastrar usando el ícono ☰
        animation: 150,
        onStart: function (evt) {
            evt.item.classList.add("dragging");
        },
        onEnd: function (evt) {
            evt.item.classList.remove("dragging");
            console.log("Fila movida de", evt.oldIndex, "a", evt.newIndex);
        }
    });
});
</script>

</body>
</html>
