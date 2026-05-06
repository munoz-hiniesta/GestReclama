<?php

  session_start();

  $action = $_POST['action'] ?? '';

  // si método de formulario POST y la acción es login
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    switch ($action) {
      case 'login': 
        // carga controlador
        require_once  __DIR__ . '/../../backend/controllers/AuthController.php';

        // crea nuevo objeto de la clase AuthController,
        // llama al método login() y
        // guarda respuesta devuelta por el controller
        $controller = new AuthController();
        $respuesta = $controller->login();
        $email = $respuesta['email'] ?? '';
        $mensaje = $respuesta['mensaje']?? '';
        
      break;

      default:
        $mensaje = "Acción no permitida";
      break;

    }

  }

  // cargar vista login (login.php)
  require_once __DIR__ . '/../views/auth/login.php';

?>