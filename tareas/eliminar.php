<?php
session_start();
include("../includes/conexion.php");

if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;
$id = intval($id);

if(!$id){
    die("ID no válido");
}

$stmt = $conn->prepare("DELETE FROM tareas WHERE id=? AND usuario_id=?");
$stmt->bind_param("ii", $id, $_SESSION['id']);
$stmt->execute();

if($stmt->affected_rows > 0){
    // Se eliminó correctamente
    $stmt->close();
    header("Location: listar.php?msg=eliminada");
    exit;
} else {
    $stmt->close();
    header("Location: listar.php?msg=no_encontrada");
    exit;
}
