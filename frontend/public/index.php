<?php

  session_start();

  // si método de formulario POST
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // carga controlador
    require_once  __DIR__ . '/../../backend/controllers/AuthController.php';

    // crea nuevo objeto de la clase AuthController,
    // llama al método login() y
    // guarda respuesta devuelta por el controller
    $controller = new AuthController();
    $respuesta = $controller->login();
    $email = $respuesta['email'] ?? '';
    $mensaje = $respuesta['mensaje']?? '';

  }

  // cargar vista login (login.php)
  require_once __DIR__ . '/../views/auth/login.php';

?>