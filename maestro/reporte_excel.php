<?php
include("../basedatos/conexion.php");

$salon = $_POST['salon'] ?? 'K11';
$hora = $_POST['hora'] ?? '5-6pm';

/* Rango de horas */
$rangos = [
  "5-6pm" => ["17:00:00", "18:00:00"],
  "6-7pm" => ["18:00:00", "19:00:00"],
  "7-8pm" => ["19:00:00", "20:00:00"],
  "8-9pm" => ["20:00:00", "21:00:00"],
  "9-10pm" => ["21:00:00", "22:00:00"]
];
$inicio = $rangos[$hora][0] ?? "00:00:00";
$fin = $rangos[$hora][1] ?? "23:59:59";

/* Obtener ID del salón */
$querySalon = "SELECT id_salon FROM salones WHERE nombre_salon = '$salon'";
$resultSalon = mysqli_query($conexion, $querySalon);
$rowSalon = mysqli_fetch_assoc($resultSalon);
$idSalon = $rowSalon ? $rowSalon['id_salon'] : 0;

/* Consulta principal */
$query = "
SELECT a.nombre, a.ApellidoP, a.ApellidoM, asi.estado, asi.hora
FROM asistencias asi
JOIN alumnos a ON asi.id_alumno = a.id_alumno
WHERE asi.id_salon = $idSalon 
  AND asi.hora BETWEEN '$inicio' AND '$fin'
ORDER BY asi.hora ASC;
";
$result = mysqli_query($conexion, $query);

/* Encabezados HTTP para descargar el archivo */
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=reporte_{$salon}_{$hora}.csv");

/* Abrir salida */
$output = fopen("php://output", "w");

/* Escribir encabezados */
fputcsv($output, ['Nombre Completo', 'Hora', 'Estado']);

/* Escribir filas */
while ($row = mysqli_fetch_assoc($result)) {
    $nombreCompleto = "{$row['nombre']} {$row['ApellidoP']} {$row['ApellidoM']}";
    fputcsv($output, [$nombreCompleto, $row['hora'], $row['estado']]);
}

fclose($output);
exit;
?>
