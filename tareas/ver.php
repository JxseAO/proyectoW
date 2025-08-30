<?php
session_start();
include("../includes/conexion.php");

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
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Mis Tareas</h2>
    <table class="table table-striped">
        <thead>
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
    <a href="crear.php" class="btn btn-primary">Nueva Tarea</a>
</div>
</body>
</html>