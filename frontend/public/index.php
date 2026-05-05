<?php

  session_start();

  // si método de formulario POST
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // carga controlador
    require_once  __DIR__ . '/../../backend/controllers/AuthController.php';

    // crea nuevo objeto de la clase AuthController y llama al método login()
    $controller = new AuthController();
    $controller->login();

    exit;

  }

  // si método de formulario no POST
  require_once __DIR__ . '/../views/auth/login.php';

?>