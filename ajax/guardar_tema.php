<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("conexion.php");

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo "No autorizado";
    exit;
}

if (isset($_POST['tema'])) {
    $tema = $_POST['tema'];
    if ($tema !== "light" && $tema !== "dark") {
        http_response_code(400);
        echo "Valor inválido";
        exit;
    }

    $_SESSION['tema'] = $tema; // opcional, para mantenerlo en sesión

    $stmt = $conn->prepare("UPDATE usuarios SET tema=? WHERE id=?");
    $stmt->bind_param("si", $tema, $_SESSION['id']);
    $stmt->execute();
    $stmt->close();

    echo "ok";
} else {
    http_response_code(400);
    echo "No se recibió tema";
}
