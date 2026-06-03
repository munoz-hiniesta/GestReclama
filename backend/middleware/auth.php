<?php

  // protección básica de rutas privadas: si no hay sesión activa, redirigir al login
  if (!isset($_SESSION['id'])) {

    header('Location: index.php');
    exit;
  }

?>