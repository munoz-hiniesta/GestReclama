<?php

  session_start();

  // validar autenticación
  if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
  }

?>