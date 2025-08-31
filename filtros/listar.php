<?php
include("../config/conexion.php");

//CAPUTURAR LOS FRILTOS
$estado = isset($_GET["estado"]) ? $_GET["estado"] : " ";
$prioridad = isset($_GET["prioridad"]) ? $_GET["prioridad"] : " ";
$fecha = isset($_GET["fecha"]) ? $_GET["fecha"] : " ";
$etiqueta = isset($_GET["etiqueta"]) ? $_GET["etiqueta"] : " ";

//CONSULTA DINAMICA
$sql = "SELECT * FROM tareas WHERE 1=1"; // el 1=1 es para tener filtros dinamicos
$params = [];

if($estado != "") {
    $sql -= "AND estado = :estado";
    $params[":estado"] = $estado;

}
if($prioridad != "") {
    $sql -= "AND prioridad = :prioridad";
    $params[":prioridad"] = $prioridad;

}
if($fecha != "") {
    $sql -= "AND fecha_vencimiento = :fecha";
    $params[":fecha"] = $fecha;

}
if($etiqueta != "") {
    $sql -= "AND etiquetas LIKE :etiqueta";
    $params[":etiqueta"] = "%$etiqueta%";

}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tareas</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h1 class="mb-4 text-center">Gestión de Tareas</h1>

    <!--formulario de los riltros-->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Filtros de búsqueda
        </div>
        <div class="card-body">
            <form method="GET" action="listar.php" class="row g-3">
                <div class="col-md-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-select">
                        <option value="">-- Todos --</option>
                        <option value="pendiente" <?= $estado=='pendiente'?'selected':'' ?>>Pendiente</option>
                        <option value="completada" <?= $estado=='completada'?'selected':'' ?>>Completada</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="prioridad" class="form-label">Prioridad</label>
                    <select name="prioridad" id="prioridad" class="form-select">
                        <option value="">-- Todas --</option>
                        <option value="baja" <?= $prioridad=='baja'?'selected':'' ?>>Baja</option>
                        <option value="media" <?= $prioridad=='media'?'selected':'' ?>>Media</option>
                        <option value="alta" <?= $prioridad=='alta'?'selected':'' ?>>Alta</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="fecha" class="form-label">Fecha de vencimiento</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="<?= $fecha ?>">
                </div>

                <div class="col-md-3">
                    <label for="etiqueta" class="form-label">Etiqueta</label>
                    <input type="text" name="etiqueta" id="etiqueta" class="form-control" value="<?= $etiqueta ?>" placeholder="ej: trabajo">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-success">Filtrar</button>
                    <a href="listar.php" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- tabla de los resultados-->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Resultados
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Fecha vencimiento</th>
                        <th>Etiquetas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($tareas) > 0): ?>
                        <?php foreach ($tareas as $t): ?>
                        <tr>
                            <td><?= $t['id'] ?></td>
                            <td><?= $t['titulo'] ?></td>
                            <td><?= $t['descripcion'] ?></td>
                            <td>
                                <span class="badge <?= $t['estado']=='pendiente'?'bg-warning text-dark':'bg-success' ?>">
                                    <?= ucfirst($t['estado']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge 
                                    <?= $t['prioridad']=='alta'?'bg-danger':
                                       ($t['prioridad']=='media'?'bg-info text-dark':'bg-secondary') ?>">
                                    <?= ucfirst($t['prioridad']) ?>
                                </span>
                            </td>
                            <td><?= $t['fecha_vencimiento'] ?></td>
                            <td><?= $t['etiquetas'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No se encontraron tareas con los filtros aplicados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>