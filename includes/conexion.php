<?php
$host = "localhost";
$db = "tareas_app";
$user = "root";
$pass = "123456";
$port = 3307; // entero, no string

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
?>
