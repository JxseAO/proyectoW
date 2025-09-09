<?php
session_start();
include("includes/tema.php");

// Si no hay usuario logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit;
}

// Traer tareas del usuario para el calendario
include("includes/conexion.php");
$stmt = $conn->prepare("SELECT id, titulo, fecha_vencimiento FROM tareas WHERE usuario_id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

$tareas = [];
while ($row = $result->fetch_assoc()) {
    $tareas[] = [
        'id' => $row['id'],
        'title' => $row['titulo'],
        'start' => $row['fecha_vencimiento']
    ];
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio - Gestión de Tareas</title>

<!-- Bootswatch CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/tema.css" rel="stylesheet">

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<style>
/* Ajuste del sidebar */
.offcanvas-body a {
    display: block;
    margin: 10px 0;
    color: #fff;
    text-decoration: none;
}
</style>
</head>
<body class="<?= $tema == 'dark' ? 'dark-mode' : '' ?>">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg <?= $tema=='dark' ? 'navbar-dark bg-dark' : 'navbar-dark bg-primary' ?>">
  <div class="container">
    
    <!-- Botón sidebar -->
    <button class="btn btn-outline-light me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
      &#9776;
    </button>

    <a class="navbar-brand" href="index.php">Mi Gestor de Tareas</a>

    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav d-flex align-items-center">
        <!-- Usuario -->
        <li class="nav-item me-3">
          <span class="nav-link mb-0">Usuario: <?= htmlspecialchars($_SESSION['usuario']); ?></span>
        </li>

        <!-- Toggle modo oscuro -->
        <li class="nav-item me-3">
          <div class="form-check form-switch d-flex align-items-center m-0">
            <input class="form-check-input" type="checkbox" id="modoToggle" <?= $tema=='dark'?'checked':'' ?>>
            <label class="form-check-label ms-2 mb-0" for="modoToggle" style="color: inherit;">
              <?= $tema=='dark' ? 'Oscuro' : 'Claro' ?>
            </label>
          </div>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <a class="nav-link btn btn-danger ms-2 text-white" href="auth/logout.php">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Sidebar -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="sidebarLabel">Menú</h5>
    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <a href="tareas/listar.php" class="btn btn-dark w-100 mb-2">Ver mis tareas</a>
    <a href="tareas/crear.php" class="btn btn-dark w-100 mb-2">Crear nueva tarea</a>
    <a href="index.php" class="btn btn-dark w-100 mb-2">Inicio</a>
  </div>
</div>

<!-- Contenido principal -->
<div class="container mt-4">
    <div class="card shadow-sm p-4 text-center mb-4">
        <h2>¡Bienvenido, <?= htmlspecialchars($_SESSION['usuario']); ?>!</h2>
        <p>Desde aquí puedes gestionar tus tareas diarias de manera eficiente.</p>
    </div>

    <!-- Calendario -->
    <div class="card shadow-sm p-4">
        <h3 class="mb-3 text-center">Calendario de Tareas</h3>
        <div id="calendar"></div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/tema.js"></script>
<script src="js/calendario.js"></script>

<script>
const tareas = <?= json_encode($tareas) ?>;
</script>

</body>
</html>
