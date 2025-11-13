<?php
session_start();

// 🔒 Verificar sesión activa
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['rol'])) {
    header('Location: ../sesion/login.php');
    exit;
}

// 🔒 Solo permitir acceso a rol Maestro
if ($_SESSION['rol'] !== 'Maestro') {
    header('Location: ../sesion/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel del Maestro</title>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f4f6fc;
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    .header {
      background: #1a1a2e;
      color: #fff;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .header h1 {
      font-size: 1.8rem;
      margin: 0;
    }

    .user-info {
      font-size: 1rem;
    }

    .content {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .content h2 {
      color: #1a1a2e;
      font-size: 2rem;
      margin-bottom: 30px;
    }

    .buttons {
      display: flex;
      gap: 40px;
    }

    .buttons button {
      background-color: #6c63ff;
      border: none;
      color: #fff;
      padding: 15px 40px;
      font-size: 1.2rem;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .buttons button:hover {
      background-color: #5a52e0;
      transform: scale(1.05);
    }

    .logout {
      background: #f44336;
      border: none;
      color: #fff;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
    }

    .logout:hover {
      background: #d32f2f;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>Panel del Maestro</h1>
    <div class="user-info">
      <?php echo htmlspecialchars($_SESSION['nombre']); ?> |
      <form action="../sesion/logout.php" method="POST" style="display:inline;">
        <button type="submit" class="logout">Cerrar sesión</button>
      </form>
    </div>
  </div>

  <div class="content">
    <h2>Edificio K</h2>
    <div class="buttons">
      <form action="reporte_k11.php" method="GET">
        <button type="submit">K11</button>
      </form>
      <form action="reporte_k12.php" method="GET">
        <button type="submit">K12</button>
      </form>
    </div>
  </div>
</body>
</html>
