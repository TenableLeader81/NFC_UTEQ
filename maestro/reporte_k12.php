<?php
session_start();

// 🔒 Verificar sesión activa
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    header('Location: ../sesion/login.php');
    exit;
}

// 🔒 Solo permitir maestros
if ($_SESSION['rol'] !== 'Maestro') {
    header('Location: ../sesion/login.php');
    exit;
}

$salon = "K12"; // Este archisavo es para K11, puedes duplicarlo para K12
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportes <?php echo $salon; ?></title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    h1 {
      font-size: 1.8rem;
      margin: 0;
    }

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

    .logout:hover {
      background: #d32f2f;
    }

    .container {
      margin-top: 40px;
      text-align: center;
    }

    .container h2 {
      color: #1a1a2e;
      font-size: 1.6rem;
      margin-bottom: 20px;
    }

    .horarios, .consultas {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 40px;
    }

    .horarios button, .consultas button {
      background-color: #6c63ff;
      border: none;
      color: white;
      padding: 12px 25px;
      font-size: 1rem;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    .horarios button:hover, .consultas button:hover {
      background-color: #5a52e0;
      transform: scale(1.05);
    }

    canvas {
      margin-top: 40px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 20px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Reportes <?php echo $salon; ?></h1>
    <form action="../sesion/logout.php" method="POST">
      <button type="submit" class="logout">Cerrar sesión</button>
    </form>
  </header>

  <div class="container">
    <h2>Selecciona el horario</h2>

    <div class="horarios">
      <form action="reporte_detalle.php" method="GET">
        <input type="hidden" name="salon" value="<?php echo $salon; ?>">
        <input type="hidden" name="hora" value="5-6pm">
        <button type="submit">5 - 6 pm</button>
      </form>

      <form action="reporte_detalle.php" method="GET">
        <input type="hidden" name="salon" value="<?php echo $salon; ?>">
        <input type="hidden" name="hora" value="6-7pm">
        <button type="submit">6 - 7 pm</button>
      </form>

      <form action="reporte_detalle.php" method="GET">
        <input type="hidden" name="salon" value="<?php echo $salon; ?>">
        <input type="hidden" name="hora" value="7-8pm">
        <button type="submit">7 - 8 pm</button>
      </form>

      <form action="reporte_detalle.php" method="GET">
        <input type="hidden" name="salon" value="<?php echo $salon; ?>">
        <input type="hidden" name="hora" value="8-9pm">
        <button type="submit">8 - 9 pm</button>
      </form>

      <form action="reporte_detalle.php" method="GET">
        <input type="hidden" name="salon" value="<?php echo $salon; ?>">
        <input type="hidden" name="hora" value="9-10pm">
        <button type="submit">9 - 10 pm</button>
      </form>
    </div>

    <h2>Consultas rápidas</h2>
    <div class="consultas">
      <button>Asistencias</button>
      <button>Retardos</button>
      <button>Faltas</button>
      <button>Generar reporte</button>
    </div>

    <h2>Vista general (Ejemplo de gráfica)</h2>
    <canvas id="grafica" width="500" height="250"></canvas>
  </div>

  <script>
    const ctx = document.getElementById('grafica');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Puntuales', 'Retardos', 'Faltas'],
        datasets: [{
          label: 'Asistencia General (ejemplo)',
          data: [25, 5, 3],
          backgroundColor: ['#6c63ff', '#f1c40f', '#e74c3c']
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
