<?php
session_start();
include("../basedatos/conexion.php");

if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    header('Location: ../sesion/login.php');
    exit;
}

if ($_SESSION['rol'] !== 'Maestro') {
    header('Location: ../sesion/login.php');
    exit;
}

$salon = $_GET['salon'] ?? 'Desconocido';
$hora = $_GET['hora'] ?? 'Sin horario';

/* 🔍 Relación entre el nombre del horario y un rango real (para la consulta SQL) */
$rangos = [
  "5-6pm" => ["17:00:00", "18:00:00"],
  "6-7pm" => ["18:00:00", "19:00:00"],
  "7-8pm" => ["19:00:00", "20:00:00"],
  "8-9pm" => ["20:00:00", "21:00:00"],
  "9-10pm" => ["21:00:00", "22:00:00"]
];

$inicio = $rangos[$hora][0] ?? "00:00:00";
$fin = $rangos[$hora][1] ?? "23:59:59";

/* 🔹 Obtener ID del salón */
$querySalon = "SELECT id_salon FROM salones WHERE nombre_salon = '$salon'";
$resultSalon = mysqli_query($conexion, $querySalon);
$rowSalon = mysqli_fetch_assoc($resultSalon);
$idSalon = $rowSalon ? $rowSalon['id_salon'] : 0;

/* 🔹 Consulta principal: alumnos y asistencias en el rango horario */
$query = "
SELECT a.nombre, a.ApellidoP, a.ApellidoM, asi.estado, asi.hora
FROM asistencias asi
JOIN alumnos a ON asi.id_alumno = a.id_alumno
WHERE asi.id_salon = $idSalon 
  AND asi.hora BETWEEN '$inicio' AND '$fin'
ORDER BY asi.hora ASC;
";

$result = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo "Reporte $salon - $hora"; ?></title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f6fc;
      text-align: center;
      padding: 40px;
    }
    h1 {
      color: #1a1a2e;
      margin-bottom: 10px;
    }
    table {
      margin: 0 auto;
      border-collapse: collapse;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin-top: 30px;
    }
    th, td {
      padding: 12px 20px;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #6c63ff;
      color: white;
    }
    tr:hover {
      background-color: #f2f2f2;
    }
    canvas {
      margin-top: 40px;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <h1>Reporte <?php echo $salon; ?></h1>
  <p>Horario seleccionado: <strong><?php echo $hora; ?></strong></p>

  <table>
    <tr>
      <th>Alumno</th>
      <th>Hora</th>
      <th>Estado</th>
    </tr>
    <?php
    $conteo = ["puntual"=>0,"retardo"=>0,"falta"=>0];
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['nombre']} {$row['ApellidoP']} {$row['ApellidoM']}</td>
                <td>{$row['hora']}</td>
                <td>{$row['estado']}</td>
              </tr>";
        $conteo[$row['estado']]++;
    }
    ?>
  </table>
  <form action="reporte_excel.php" method="POST" style="margin-top:20px;">
  <input type="hidden" name="salon" value="<?php echo $salon; ?>">
  <input type="hidden" name="hora" value="<?php echo $hora; ?>">
  <button type="submit" style="
      background-color:#27ae60;
      border:none;
      color:white;
      padding:12px 25px;
      border-radius:8px;
      cursor:pointer;
      font-size:1rem;
      font-weight:bold;
      transition:0.3s;">📊 Descargar en Excel</button>
</form>


  <canvas id="grafica" width="600" height="300"></canvas>

  <script>
    const ctx = document.getElementById('grafica');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Puntuales', 'Retardos', 'Faltas'],
        datasets: [{
          label: 'Estadísticas <?php echo $salon; ?> (<?php echo $hora; ?>)',
          data: [<?php echo $conteo['puntual']; ?>, <?php echo $conteo['retardo']; ?>, <?php echo $conteo['falta']; ?>],
          backgroundColor: ['#6c63ff', '#f1c40f', '#e74c3c']
        }]
      },
      options: { scales: { y: { beginAtZero: true } } }
    });
  </script>
</body>
</html>
