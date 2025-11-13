<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'Direccion') {
    header("Location: ../sesion/login.php");
    exit;
}

include("../basedatos/conexion.php");

// === Cambiar estatus a inactivo ===
if (isset($_GET['inactivar'])) {
    $id = intval($_GET['inactivar']);

    // Verificar que el alumno exista y esté activo
    $check = mysqli_query($conexion, "SELECT * FROM alumnos WHERE id_alumno = $id AND estatus = 'activo'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conexion, "UPDATE alumnos SET estatus = 'inactivo' WHERE id_alumno = $id");
        echo "<script>alert('✅ Alumno marcado como inactivo'); window.location='alumnos.php';</script>";
        exit;
    } else {
        echo "<script>alert('⚠️ Este alumno ya estaba inactivo o no existe'); window.location='alumnos.php';</script>";
        exit;
    }
}

// === Descargar Excel (solo activos) ===
if (isset($_GET['descargar'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=alumnos_activos.xls");
    $query = mysqli_query($conexion, "SELECT * FROM alumnos WHERE estatus = 'activo'");
    echo "ID\tNombre\tApellidoP\tApellidoM\tMatrícula\tUID_NFC\tEstatus\n";
    while ($row = mysqli_fetch_assoc($query)) {
        echo "{$row['id_alumno']}\t{$row['nombre']}\t{$row['ApellidoP']}\t{$row['ApellidoM']}\t{$row['matricula']}\t{$row['uid_nfc']}\t{$row['estatus']}\n";
    }
    exit;
}

// === Agregar alumno ===
if (isset($_POST['agregar'])) {
    $nombre = trim($_POST['nombre']);
    $ApellidoP = trim($_POST['ApellidoP']);
    $ApellidoM = trim($_POST['ApellidoM']);
    $matricula = trim($_POST['matricula']);
    $uid_nfc = trim($_POST['uid_nfc']);

    $insert = "INSERT INTO alumnos (nombre, ApellidoP, ApellidoM, matricula, uid_nfc, estatus)
               VALUES ('$nombre', '$ApellidoP', '$ApellidoM', '$matricula', '$uid_nfc', 'activo')";
    mysqli_query($conexion, $insert);
    echo "<script>alert('✅ Alumno agregado correctamente'); window.location='alumnos.php';</script>";
    exit;
}

// === Consulta principal (solo activos) ===
$alumnos = mysqli_query($conexion, "SELECT * FROM alumnos WHERE estatus = 'activo' ORDER BY id_alumno DESC");
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Alumnos</title>
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
    .logout, .volver {
      background: #6c63ff;
      border: none;
      color: #fff;
      padding: 8px 15px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
      font-weight: bold;
    }
    .logout:hover, .volver:hover { background: #5a52e0; }

    main { width: 90%; margin-top: 30px; }
    h2 { text-align: center; color: #1a1a2e; }

    .acciones {
      text-align: right;
      margin-bottom: 20px;
    }

    .acciones button, .acciones a {
      background-color: #6c63ff;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      text-decoration: none;
      margin-left: 5px;
    }

    .acciones button:hover, .acciones a:hover {
      background-color: #5a52e0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #6c63ff;
      color: white;
    }

    tr:hover { background-color: #f1f1f1; }

    form.agregar {
      background: #fff;
      padding: 20px;
      margin-top: 30px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      width: 400px;
      margin-left: auto;
      margin-right: auto;
    }

    input[type="text"] {
      width: 100%;
      padding: 10px;
      margin: 5px 0 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    input[type="submit"] {
      background-color: #6c63ff;
      color: #fff;
      border: none;
      padding: 10px 15px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      width: 100%;
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
    form.agregar {
  background: #fff;
  padding: 25px 30px;
  margin: 40px auto;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  width: 100%;
  max-width: 420px;
  display: flex;
  flex-direction: column;
  align-items: stretch;
  justify-content: center;
}

form.agregar h3 {
  font-size: 1.4rem;
  text-align: left;
  margin-bottom: 15px;
  font-weight: 600;
}

.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 15px;
}

input[type="text"] {
  width: 100%;
  padding: 10px 12px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 0.95rem;
  transition: border-color 0.3s;
}

input[type="text"]:focus {
  border-color: #6c63ff;
  outline: none;
  box-shadow: 0 0 4px rgba(108,99,255,0.3);
}

input[type="submit"] {
  background-color: #6c63ff;
  color: #fff;
  border: none;
  padding: 12px;
  border-radius: 8px;
  font-weight: bold;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

input[type="submit"]:hover {
  background-color: #5a52e0;
  transform: translateY(-2px);
}

  </style>
</head>
<body>
  <header>
    <h1>Gestión de Alumnos</h1>
    <div>
      <a href="administrador.php" class="volver">⬅ Volver</a>
      <form action="../sesion/logout.php" method="POST" style="display:inline;">
        <button type="submit" class="logout">Cerrar sesión</button>
      </form>
    </div>
  </header>

  <main>
    <div class="acciones">
      <a href="?descargar=1">⬇ Descargar Excel</a>
    </div>

    <table>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido P</th>
        <th>Apellido M</th>
        <th>Matrícula</th>
        <th>UID NFC</th>
        <th>Acciones</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($alumnos)) { ?>
      <tr>
        <td><?php echo $row['id_alumno']; ?></td>
        <td><?php echo $row['nombre']; ?></td>
        <td><?php echo $row['ApellidoP']; ?></td>
        <td><?php echo $row['ApellidoM']; ?></td>
        <td><?php echo $row['matricula']; ?></td>
        <td><?php echo $row['uid_nfc']; ?></td>
        <td>
          <a href="editar_alumno.php?id=<?php echo $row['id_alumno']; ?>">✏️</a>
<a href="alumnos.php?inactivar=<?php echo $row['id_alumno']; ?>"
   onclick="return confirm('⚠️ ¿Seguro que deseas marcar como inactivo a este alumno?');">
   🚫
</a>

        </td>
      </tr>
      <?php } ?>
    </table>

<form method="POST" class="agregar">
  <h3 style="display: flex; align-items: center; gap: 8px; color: #1a1a2e;">
    <span style="color:#6c63ff; font-size:1.5rem;">➕</span> 
    Agregar Alumno
  </h3>

  <div class="form-group">
    <input type="text" name="nombre" placeholder="Nombre" required>
  </div>

  <div class="form-group">
    <input type="text" name="ApellidoP" placeholder="Apellido Paterno" required>
  </div>

  <div class="form-group">
    <input type="text" name="ApellidoM" placeholder="Apellido Materno" required>
  </div>

  <div class="form-group">
    <input type="text" name="matricula" placeholder="Matrícula" required>
  </div>

  <div class="form-group">
    <input type="text" name="uid_nfc" placeholder="UID NFC (ej: 9F244C68)">
  </div>

  <input type="submit" name="agregar" value="Guardar Alumno">
</form>

  </main>

  <footer>
    © <?php echo date('Y'); ?> - Sistema de Control UTEQ
  </footer>
</body>
</html>
