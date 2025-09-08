<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include(__DIR__ . "/conexion.php"); // asegúrate de que la ruta sea correcta

$tema = "light"; // por defecto

if (isset($_SESSION['id'])) {
    $stmt = $conn->prepare("SELECT tema FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($temaBD);
    if ($stmt->fetch() && in_array($temaBD, ['light', 'dark'])) {
        $tema = $temaBD;
    }
    $stmt->close();
}
