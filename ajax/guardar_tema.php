<?php
session_start();
include("../includes/conexion.php");

if(!isset($_SESSION['id']) || !isset($_POST['tema'])){
    http_response_code(400);
    exit;
}

$tema = $_POST['tema']; // 'light' o 'dark'
$stmt = $conn->prepare("UPDATE usuarios SET tema=? WHERE id=?");
$stmt->bind_param("si", $tema, $_SESSION['id']);
$stmt->execute();
$stmt->close();

echo 'ok';
