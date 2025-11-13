<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'Direccion') {
    header("Location: ../sesion/login.php");
    exit;
}

include("../basedatos/conexion.php");

// Verificar ID recibido
if (!isset($_GET['id'])) {
    header("Location: alumnos.php");
    exit;
}

$id = intval($_GET['id']);

// ===== Obtener datos actuales del alumno =====
$query = mysqli_query($conexion, "SELECT * FROM alumnos WHERE id_alumno = $id");
if (mysqli_num_rows($query) == 0) {
    echo "<script>alert('Alumno no encontrado'); window.location='alumnos.php';</script>";
    exit;
}
$alumno = mysqli_fetch_assoc($query);

// ===== Actualizar datos =====
if (isset($_POST['actualizar'])) {
    $nombre = trim($_POST['nombre']);
    $ApellidoP = trim($_POST['ApellidoP']);
    $ApellidoM = trim($_POST['ApellidoM']);
    $matricula = trim($_POST['matricula']);
    $uid_nfc = trim($_POST['uid_nfc']);

    $update = "
        UPDATE alumnos SET 
        nombre='$nombre',
        ApellidoP='$ApellidoP',
        ApellidoM='$ApellidoM',
        matricula='$matricula',
        uid_nfc='$uid_nfc'
        WHERE id_alumno=$id
    ";

    if (mysqli_query($conexion, $update)) {
        echo "<script>alert('Alumno actualizado correctamente'); window.location='alumnos.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error al actualizar');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Alumno</title>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f4f6fc;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }
    header {
      background: #1a1a2e;
      color: #fff;
      width: 100%;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    h1 { margin: 0; font-size: 1.8rem; }
    .volver, .logout {
      background: #6c63ff;
      border: none;
      color: #fff;
      padding: 8px 15px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
      text-decoration: none;
    }
    .volver:hover, .logout:hover {
      background-color: #5a52e0;
    }

    main {
      margin-top: 40px;
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      width: 400px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-top: 10px;
      font-weight: bold;
      color: #333;
    }

    input[type="text"] {
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    input[type="submit"] {
      background: #6c63ff;
      border: none;
      color: #fff;
      font-weight: bold;
      padding: 12px;
      border-radius: 6px;
      margin-top: 20px;
      cursor: pointer;
      transition: 0.3s;
    }

    input[type="submit"]:hover {
      background-color: #5a52e0;
    }

    footer {
      text-align: center;
      padding: 20px;
      color: #777;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <header>
    <h1>Editar Alumno</h1>
    <div>
      <a href="alumnos.php" class="volver">⬅ Volver</a>
      <form action="../sesion/logout.php" method="POST" style="display:inline;">
        <button type="submit" class="logout">Cerrar sesión</button>
      </form>
    </div>
  </header>

  <main>
    <form method="POST">
      <label>Nombre:</label>
      <input type="text" name="nombre" value="<?php echo $alumno['nombre']; ?>" required>

      <label>Apellido Paterno:</label>
      <input type="text" name="ApellidoP" value="<?php echo $alumno['ApellidoP']; ?>" required>

      <label>Apellido Materno:</label>
      <input type="text" name="ApellidoM" value="<?php echo $alumno['ApellidoM']; ?>" required>

      <label>Matrícula:</label>
      <input type="text" name="matricula" value="<?php echo $alumno['matricula']; ?>" required>

      <label>UID NFC:</label>
      <input type="text" name="uid_nfc" value="<?php echo $alumno['uid_nfc']; ?>">

      <input type="submit" name="actualizar" value="Guardar Cambios">
    </form>
  </main>

  <footer>
    © <?php echo date('Y'); ?> - Sistema de Control UTEQ
  </footer>
</body>
</html>
