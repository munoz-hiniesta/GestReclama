<?php

  // variables necesarias para otros archivos
  $action = $_POST['action'] ?? $_GET['action'] ?? '';

  // cargar archivos
  require_once '../../backend/bootstrap/bootstrap.php';
  require_once CONTROLLERS_PATH . '/AuthController.php';
  require_once CONTROLLERS_PATH . '/ReclamacionController.php';

  // proteger rutas privadas mediante sesión PHP
  $protectedActions = [
    'reclamaciones.index',
    'reclamaciones.show',
    'reclamaciones.edit',
    'reclamaciones.create.view',
    'reclamaciones.create',
    'reclamaciones.validar'
  ];

  if (in_array($action, $protectedActions, true)) {
    require_once MIDDLEWARE_PATH . '/auth.php';
  }

  switch ($action) {
    
    case '':
      $pageTitle = "login";
      $vista = '/../auth/login.php'; 
      $css = '/assets/css/login.css';
    break;

    case 'login':
      // crea nuevo objeto de la clase AuthController,
      // llama al método login() y
      // guarda respuesta devuelta por el controller
      $controller = new AuthController($pdo); 
      $respuesta = $controller->login();
      $id = $respuesta['id'] ?? '';;
      $email = $respuesta['email'] ?? '';
      $mensaje = $respuesta['mensaje']?? '';
      $pageTitle = "login";
      $vista = '/../auth/login.php'; 
      $css = '/assets/css/login.css'; 
    break;

    case 'logout': 
      $controller = new AuthController($pdo);
      $controller->logout();
    break;
      
    case 'reclamaciones.index':
      $reclamacionService = new ReclamacionService($pdo);
      $controller = new ReclamacionController($pdo, $reclamacionService); 
      $respuesta = $controller->index();
      $vista = $respuesta['vista'];
      $pageTitle = $respuesta['pageTitle'];
      $css = $respuesta['css'];
    break;

    case 'reclamaciones.show':
      $reclamacionService = new ReclamacionService($pdo);
      $controller = new ReclamacionController($pdo, $reclamacionService);
      $respuesta = $controller->show();
      $vista = $respuesta['vista'];
      $pageTitle = $respuesta['pageTitle'];
      $css = $respuesta['css'];
      $reclamacion = $respuesta['reclamacion'] ?? null;
      $error = $respuesta['error'] ?? null;
      $respuesta = $respuesta['respuesta'] ?? [];
    break;

    case 'reclamaciones.edit':
      $reclamacionService = new ReclamacionService($pdo);
      $controller = new ReclamacionController($pdo, $reclamacionService);
      $respuesta = $controller->edit();
      $vista = $respuesta['vista'];
      $pageTitle = $respuesta['pageTitle'];
      $css = $respuesta['css'];
      $reclamacion = $respuesta['reclamacion'] ?? null;
      $error = $respuesta['error'] ?? null;
      $respuesta = $respuesta['respuesta'] ?? [];
    break;

    case 'reclamaciones.validar':
      $reclamacionService = new ReclamacionService($pdo);
      $controller = new ReclamacionController($pdo, $reclamacionService);
      $respuesta = $controller->validar();
      $vista = $respuesta['vista'];
      $pageTitle = $respuesta['pageTitle'];
      $css = $respuesta['css'];
      $reclamacion = $respuesta['reclamacion'] ?? null;
      $error = $respuesta['error'] ?? null;
      $respuesta = $respuesta['respuesta'] ?? [];
    break;

    case 'reclamaciones.create.view':
      $vista = VIEWS_PATH . '/reclamaciones/create.php';
      $pageTitle = 'Crear reclamación';
      $css = CSS_PATH . '/reclamacion.create.css';
    break;

    case 'reclamaciones.create':
      $reclamacionService = new ReclamacionService($pdo);
      $controller = new ReclamacionController($pdo, $reclamacionService);
      $respuesta = $controller->create();
      // mostrar la misma vista de creación con el resultado (mensaje)
      $vista = VIEWS_PATH . '/reclamaciones/create.php';
      $pageTitle = 'Crear reclamación';
      $css = CSS_PATH . '/reclamacion.create.css';
    break;

    default:
      $mensaje = "Acción no permitida";
      $pageTitle = "login";
      $vista = '/../auth/login.php'; 
      $css = '/assets/css/login.css'; 
    break;

  }

  // cargar layout.php (es quien decide qué vista debe cargar)
  require_once LAYOUTS_PATH . '/auth.layout.php';
?>