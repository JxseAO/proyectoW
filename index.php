<?php
session_start();

// Si no hay usuario logueado, redirige al login
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
    <style>
        body {
            background-color: #f8f9fa;
        }
        .welcome-card {
            max-width: 600px;
            margin: 50px auto;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">MiGestor de Tareas</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link">Usuario: <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-danger text-white ms-2" href="auth/logout.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container">
    <div class="card welcome-card shadow-sm p-4 text-center">
        <h2 class="mb-4">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>
        <p>Desde aquí puedes gestionar tus tareas diarias de manera eficiente.</p>

        <div class="d-grid gap-3 mt-4">
            <!-- Botón principal ahora apunta a listar.php -->
            <a href="tareas/listar.php" class="btn btn-primary btn-lg">Ver mis tareas</a>
            <a href="#" class="btn btn-secondary btn-lg">Modo Claro/Oscuro</a> <!-- Toggle opcional -->
        </div>
    </div>
</div>

</body>
</html>
