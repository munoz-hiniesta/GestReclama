<?php

  require_once __DIR__ . '/../controllers/AuthController.php';

  // Simular petición POST
  $_SERVER['REQUEST_METHOD'] = 'POST';

  $_POST['email'] = 'email_001@gestreclama.com';
  $_POST['password'] = '001';

  echo "=== TEST LOGIN ===\n";

  $controller = new AuthController();
  $controller->login();

  echo "\n=== FIN TEST ===\n";

?>