<?php
$host = "localhost";
$db = "tareas_app";
$user = "root";
$pass = "admin";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die("Conexion fallida: " . $conn->connect_error);
}
?>