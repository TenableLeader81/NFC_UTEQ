<?php
   $conexion = mysqli_connect("localhost","root","","asistencia_db");
   
   if ($conexion) {
    echo "";
   } else {
    echo "No se ha podido conectar con la BD";
   }

?>


