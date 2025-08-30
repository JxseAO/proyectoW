<?php
session_start();
include("../includes/conexion.php");

$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Verificar si el correo ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0){
        $error = "El correo ya está registrado.";
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios(nombre, email, contrasena) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $password_hash);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Error al registrar usuario.";
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-sm" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Registro</h2>

        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="email" class="form-control" placeholder="Correo" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>

        <p class="text-center mt-3">
            <a href="login.php" class="btn btn-link">¿Ya tienes cuenta? Inicia sesión</a>
        </p>
    </div>
</div>
</body>
</html>
