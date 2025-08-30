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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-sm" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Iniciar Sesión</h2>

        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="email" class="form-control" placeholder="Correo" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
        </form>

        <p class="text-center mt-3">
            <a href="register.php" class="btn btn-link">¿No tienes cuenta? Regístrate</a>
        </p>
    </div>
</div>
</body>
</html>
