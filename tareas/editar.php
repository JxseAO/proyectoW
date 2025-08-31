<?php
session_start();
include("../includes/conexion.php");

if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit;
}

$error = "";
$id = $_GET['id'] ?? null;

// Traer los datos de la tarea, incluyendo etiquetas
$stmt = $conn->prepare("SELECT titulo, descripcion, estado, prioridad, fecha_vencimiento, etiquetas FROM tareas WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($titulo, $descripcion, $estado, $prioridad, $fecha_vencimiento, $etiquetas);
$stmt->fetch();
$stmt->close();

// Procesar el POST para actualizar
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $titulo = trim($_POST["titulo"]);
    $descripcion = trim($_POST["descripcion"]);
    $estado = $_POST["estado"];
    $prioridad = $_POST["prioridad"];
    $fecha_vencimiento = $_POST["fecha_vencimiento"];
    $etiquetas = trim($_POST["etiquetas"]); // Nuevo campo

    $stmt = $conn->prepare("UPDATE tareas SET titulo=?, descripcion=?, estado=?, prioridad=?, fecha_vencimiento=?, etiquetas=? WHERE id=? AND usuario_id=?");
    $stmt->bind_param("ssssssii", $titulo, $descripcion, $estado, $prioridad, $fecha_vencimiento, $etiquetas, $id, $_SESSION['id']);

    if($stmt->execute()){
        header("Location: listar.php");
        exit;
    } else {
        $error = "Error al actualizar la tarea.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Tarea</title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Editar Tarea</h2>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($titulo) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"><?= htmlspecialchars($descripcion) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="pendiente" <?= $estado=='pendiente'?'selected':'' ?>>Pendiente</option>
                <option value="completada" <?= $estado=='completada'?'selected':'' ?>>Completada</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Prioridad</label>
            <select name="prioridad" class="form-select">
                <option value="baja" <?= $prioridad=='baja'?'selected':'' ?>>Baja</option>
                <option value="media" <?= $prioridad=='media'?'selected':'' ?>>Media</option>
                <option value="alta" <?= $prioridad=='alta'?'selected':'' ?>>Alta</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de Vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="form-control" value="<?= $fecha_vencimiento ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Etiquetas (separadas por coma)</label>
            <input type="text" name="etiquetas" class="form-control" value="<?= htmlspecialchars($etiquetas) ?>" placeholder="ej: trabajo, urgente">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
