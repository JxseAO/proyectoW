<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit;
}
?>

<h1>Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h1>
<a href="auth/logout.php">Cerrar sesión</a>
