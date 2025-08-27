<?php
session_start();
include("../includes/conexion.php");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, nombre, contrasena FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $nombre, $password_hash);
    $stmt->fetch();

    if ($id && password_verify($password, $password_hash)) {
        $_SESSION['usuario'] = $nombre;
        $_SESSION['id'] = $id;
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
    }

    $stmt->close();
}
?>

<h2>Login</h2>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="email" name="email" placeholder="Correo" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Iniciar sesión</button>
</form>
<a href="register.php">¿No tienes cuenta? Regístrate</a>
