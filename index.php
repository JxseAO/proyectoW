<?php
session_start();
include("includes/tema.php");

// Si no hay usuario logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio - Gestión de Tareas</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/tema.css" rel="stylesheet">
</head>
<body class="<?= $tema == 'dark' ? 'dark-mode' : '' ?>">


<nav class="navbar navbar-expand-lg <?= $tema=='dark' ? 'navbar-dark bg-dark' : 'navbar-dark bg-primary' ?>">
  <div class="container">
    <a class="navbar-brand" href="../index.php">Mi Gestor de Tareas</a>

    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav d-flex align-items-center">

        <!-- Usuario -->
        <li class="nav-item me-3">
          <span class="nav-link mb-0">
            Usuario: <?= htmlspecialchars($_SESSION['usuario']); ?>
          </span>
        </li>

        <!-- Toggle modo oscuro -->
        <li class="nav-item me-3">
          <div class="form-check form-switch d-flex align-items-center m-0">
            <input 
              class="form-check-input" 
              type="checkbox" 
              id="modoToggle" 
              <?= $tema=='dark'?'checked':'' ?>
            >
            <label class="form-check-label ms-2 mb-0" for="modoToggle" style="color: inherit;">
              <?= $tema=='dark' ? 'Oscuro' : 'Claro' ?>
            </label>
          </div>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <a class="nav-link btn btn-danger ms-2 text-white" href="../auth/login.php">
            Cerrar sesión
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>





<div class="container mt-5">
    <div class="card shadow-sm p-4 text-center">
        <h2>¡Bienvenido, <?= htmlspecialchars($_SESSION['usuario']); ?>!</h2>
        <p>Desde aquí puedes gestionar tus tareas diarias de manera eficiente.</p>
        <div class="d-grid gap-3 mt-4">
            <a href="tareas/listar.php" class="btn btn-primary btn-lg">Ver mis tareas</a>
            <a href="tareas/crear.php" class="btn btn-success btn-lg">Crear nueva tarea</a>
        </div>
    </div>
</div>
<script src="js/tema.js"></script>
</body>


</html>
