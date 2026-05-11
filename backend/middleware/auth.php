<?php

  // validar autenticación
  if (!isset($_SESSION['id'])) {

    header('Location: index.php');
    exit;
  }

?>