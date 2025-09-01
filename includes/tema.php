<?php



$tema = $_SESSION['tema'] ?? 'light';


include("conexion.php");

$tema = 'light'; // valor por defecto

if(isset($_SESSION['id'])){
    $stmt = $conn->prepare("SELECT tema FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($usuario_tema);
    if($stmt->fetch()){
        $tema = $usuario_tema;
    }
    $stmt->close();
}
?>
