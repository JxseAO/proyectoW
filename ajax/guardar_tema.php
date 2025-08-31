<?php
session_start();
include("../includes/conexion.php");

if(isset($_SESSION["id"]) && isset($_POST["tema"])){
    $tema = $_POST["tema"] === "dark" ? "dark" : "light";
    $stmt = $conn->prepare("UPDATE usuarios SET tema=? WHERE id=?");
    $stmt->bind_param("si", $tema, $_SESSION['id']);
    $stmt->execute();
    $stmt->close();

}
?>
