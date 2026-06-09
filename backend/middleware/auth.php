<?php

  // redirigir al login si no hay sesión activa
  if (!isset($_SESSION['id'])) {

    header('Location: index.php');
    exit;
  }

?>