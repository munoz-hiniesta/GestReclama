<?php

  // Simular petición POST
  $_SERVER['REQUEST_METHOD'] = 'POST';
  $_POST['email'] = 'email_001@gestreclama.com';
  $_POST['password'] = '001';
  $_POST['action'] = 'login';

  // conecto con index.php  
  require_once PUBLIC_PATH . '/index.php';

  // muestro resultados del test
  echo "=== TEST LOGIN ===\n";

?>