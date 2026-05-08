<?php

  session_start();

  // variables necesarias para otros archivos
  $action = $_POST['action'] ?? '';
  $pageTitle = "login";
  $vista = '/../auth/login.php'; // archivo de vista por defecto
  $css = '/css/login.css'; // archivo plantilla css por defecto

   /** $vista: decide qué vista renderizar dentro de la misma petición*/

  // carga controlador
  require_once  __DIR__ . '/../../backend/controllers/AuthController.php';

  // si método de formulario POST y la acción es login
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    switch ($action) {
      case 'login':
        // crea nuevo objeto de la clase AuthController,
        // llama al método login() y
        // guarda respuesta devuelta por el controller
        $controller = new AuthController(); 
        $respuesta = $controller->login();
        $id = $respuesta['id'] ?? '';;
        $email = $respuesta['email'] ?? '';
        $mensaje = $respuesta['mensaje']?? '';
      break;

      case 'logout': 
        $controller = new AuthController();
        $controller->logout();
      break;

      default:
        $mensaje = "Acción no permitida";
      break;

    }

  }

  // cargar layout.php (es quien decide qué vista debe cargar)
  require_once __DIR__ . '/../views/layouts/layout.php';

?>