<?php
session_start();
include("../includes/conexion.php");

$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);


    //VERIFICAR QUE EL CORREO YA EXISTE
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0){
        $error = "El correo ya esta registrado.";
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios(nombre, email, contrasena) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $password_hash);

        if ($stmt->execute()) {
            $_SESSION['usuario'] = $nombre;
            $_SESSION['id'] = $conn->insert_id;
            header("Location: ../login.php");
            exit;
        } else {
            $error = "Error al registrar usuario.";
        }
    }
    $stmt->close();
}
?>

<h2>Registro</h2>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="email" name="email" placeholder="Correo" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Registrar</button>
</form>
<a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
