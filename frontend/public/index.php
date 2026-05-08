<?php

  session_start();

  // variables necesarias para otros archivos
  $action = $_POST['action'] ?? '';
  $pageTitle = "login";
  $vista = '/../auth/login.php'; // archivo de vista por defecto
  $css = '/css/login.css'; // archivo plantilla css por defecto

  // carga controlador
  require_once  __DIR__ . '/../../backend/controllers/AuthController.php';


  // si método de formulario POST y la acción es login
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    switch ($action) {
      case 'login': 
        // preparar require_once para layout.php
        $vista = '/../auth/login.php';
        $css = '/css/login.css';
        // crea nuevo objeto de la clase AuthController,
        // llama al método login() y
        // guarda respuesta devuelta por el controller
        $controller = new AuthController(); 
        $respuesta = $controller->login();
        $email = $respuesta['email'] ?? '';
        $mensaje = $respuesta['mensaje']?? '';
      break;

      case 'logout':
        $vista = '/../auth/logout.php';
        $css = '/css/logout.css';
        $controller = new AuthController();
        $controller->logout();
      break;

      default:
        $mensaje = "Acción no permitida";
      break;

    }

  }

  // cargar vista login (login.php)
  require_once __DIR__ . '/../views/layouts/layout.php';

?>