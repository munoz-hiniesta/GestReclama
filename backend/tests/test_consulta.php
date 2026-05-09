<?php

  $pdo = require_once __DIR__ . '/../database/connection.php';

  require_once __DIR__ . '/../models/Reclamacion.php';

  // llamar a AuthService.php (crear instancia, llamar método)
  $objeto = new Reclamacion($pdo);
  
  // consultar reclamaciones
  $consulta = $objeto->obtenerReclamaciones();

  foreach ($consulta as $i) {
    echo $i['id'];
    echo $i['usuario_creador_id'];
  }

?>