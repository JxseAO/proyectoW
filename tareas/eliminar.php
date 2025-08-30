<?php
session_start();
include("../includes/conexion.php");

if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;

$stmt = $conn->prepare("DELETE FROM tareas WHERE id=? AND usuario_id=?");
$stmt->bind_param("ii", $id, $_SESSION['id']);
$stmt->execute();
$stmt->close();

header("Location: ver.php");
exit;
