<?php

  $pdo = require_once DATABASE_PATH . '/connection.php';

  require_once MODELS_PATH . '/Reclamacion.php';

  // llamar a AuthService.php (crear instancia, llamar método)
  $objeto = new Reclamacion($pdo);
  
  // consultar reclamaciones
  $consulta = $objeto->obtenerReclamaciones();

  foreach ($consulta as $i) {
    echo $i['id'];
    echo $i['usuario_creador_id'];
  }

?>