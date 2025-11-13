<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'Direccion') {
    header("Location: ../sesion/login.php");
    exit;
}

include("../basedatos/conexion.php");

// ======= RESÚMENES RÁPIDOS =======
$totalAlumnos = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) AS total FROM alumnos"))['total'];
$totalMaestros = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) AS total FROM usuarios WHERE id_rol = 2"))['total'];
$totalAdmins = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) AS total FROM usuarios WHERE id_rol = 1"))['total'];
$totalSalones = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) AS total FROM salones"))['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f4f6fc;
      display: flex;
      flex-direction: column;
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
    .logout {
      background: #f44336;
      border: none;
      color: #fff;
      padding: 8px 15px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
      font-weight: bold;
    }
    .logout:hover { background: #d32f2f; }

    main {
      flex: 1;
      padding: 40px;
    }

    .cards {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      justify-content: center;
      margin-bottom: 50px;
    }

    .card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      width: 220px;
      padding: 25px;
      text-align: center;
      transition: 0.3s;
    }

    .card:hover {
      transform: scale(1.05);
    }

    .card h3 {
      margin-bottom: 10px;
      color: #1a1a2e;
    }

    .card span {
      font-size: 1.8rem;
      font-weight: bold;
      color: #6c63ff;
    }

    .modules {
      text-align: center;
    }

    .modules a {
      text-decoration: none;
      display: inline-block;
      background-color: #6c63ff;
      color: #fff;
      padding: 15px 40px;
      border-radius: 8px;
      font-weight: bold;
      margin: 15px;
      transition: 0.3s;
    }

    .modules a:hover {
      background-color: #5a52e0;
      transform: scale(1.05);
    }

    canvas {
      max-width: 600px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
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
    <h1>Panel de Administración</h1>
    <form action="../sesion/logout.php" method="POST">
      <button type="submit" class="logout">Cerrar sesión</button>
    </form>
  </header>

  <main>
    <section class="cards">
      <div class="card">
        <h3>👨‍🎓 Alumnos</h3>
        <span><?php echo $totalAlumnos; ?></span>
      </div>
      <div class="card">
        <h3>👩‍🏫 Maestros</h3>
        <span><?php echo $totalMaestros; ?></span>
      </div>
      <div class="card">
        <h3>🏢 Administradores</h3>
        <span><?php echo $totalAdmins; ?></span>
      </div>
      <div class="card">
        <h3>🏫 Salones</h3>
        <span><?php echo $totalSalones; ?></span>
      </div>
    </section>

    <section class="modules">
      <h2>Gestión del Sistema</h2>
      <a href="alumnos.php">👨‍🎓 Alumnos</a>
      <a href="maestros.php">👩‍🏫 Maestros</a>
      <a href="administradores.php">🏢 Administradores</a>
    </section>

    <canvas id="grafica"></canvas>
  </main>

  <footer>
    © <?php echo date('Y'); ?> - Sistema de Control UTEQ
  </footer>

  <script>
    const ctx = document.getElementById('grafica');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Asistencias', 'Retardos', 'Faltas'],
        datasets: [{
          label: 'Resumen semanal (Ejemplo)',
          data: [80, 15, 5],
          backgroundColor: ['#6c63ff', '#f1c40f', '#e74c3c']
        }]
      },
      options: {
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
</body>
</html>
