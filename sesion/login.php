<?php
session_start();

// 🚫 Evitar que el navegador use caché (soluciona el bug del botón “Atrás”)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include("../basedatos/conexion.php");

$mensaje = "";

// 🧠 Si ya hay sesión activa, redirigir según rol
if (isset($_SESSION['id_usuario'])) {
    if ($_SESSION['rol'] === 'Direccion') {
        header("Location: ../admin/administrador.php");
        exit;
    } elseif ($_SESSION['rol'] === 'Maestro') {
        header("Location: ../maestro/maestros.php");
        exit;
    } else {
        header("Location: ../index.php");
        exit;
    }
}

// 🔹 Procesar el formulario cuando se envía
if (isset($_POST['iniciar_sesion'])) {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    $query = "
        SELECT u.*, r.nombre_rol 
        FROM usuarios u
        INNER JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.correo = '$correo' AND u.contrasena = '$contrasena'
    ";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);

        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['rol'] = $row['nombre_rol'];

        // 🔁 Redirigir según el rol
        if ($row['nombre_rol'] == 'Direccion') {
            header("Location: ../admin/administrador.php");
            exit;
        } elseif ($row['nombre_rol'] == 'Maestro') {
            header("Location: ../maestro/maestros.php");
            exit;
        } else {
            header("Location: ../index.php");
            exit;
        }
    } else {
        $mensaje = "⚠️ Correo o contraseña incorrectos.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #1a1a2e;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: white;
    }

    .login-box {
      background: #24243e;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.5);
      width: 350px;
      text-align: center;
    }

    h2 { margin-bottom: 20px; }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 6px;
      background: #3e3e55;
      color: white;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #6c63ff;
      border: none;
      border-radius: 6px;
      color: white;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover { background: #5a52e0; }

    .mensaje {
      color: #ff6666;
      margin-top: 15px;
      font-size: 0.9rem;
    }

    a {
      color: #6c63ff;
      text-decoration: none;
      font-size: 0.9rem;
    }

    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Iniciar Sesión</h2>
    <form method="POST" action="">
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      <input type="password" name="contrasena" placeholder="Contraseña" required>
      <button type="submit" name="iniciar_sesion">Ingresar</button>
    </form>

    <?php if ($mensaje): ?>
      <div class="mensaje"><?= $mensaje ?></div>
    <?php endif; ?>

    <br>
    <a href="../index.php">← Volver al inicio</a>
  </div>
</body>
</html>
