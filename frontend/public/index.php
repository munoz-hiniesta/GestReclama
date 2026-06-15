<?php

  // variables necesarias para otros archivos
  $action = $_POST['action'] ?? $_GET['action'] ?? '';

  // cargar archivos
  require_once '../../backend/bootstrap/bootstrap.php';
  require_once CONTROLLERS_PATH . '/AuthController.php';
  require_once CONTROLLERS_PATH . '/ReclamacionController.php';
  require_once CONTROLLERS_PATH . '/AdminController.php';

  // proteger rutas privadas mediante sesión PHP
  $protectedActions = [
    'reclamaciones.index',
    'reclamaciones.show',
    'reclamaciones.edit',
    'reclamaciones.pendientes_asignacion',
    'reclamaciones.asignar',
    'reclamaciones.create.view',
    'reclamaciones.create',
    'reclamaciones.validar',
    'admin.index',
    'admin.usuario.guardar',
    'admin.franquicia.guardar'
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
      $id = $respuesta['id'] ?? '';
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
      $reclamaciones = $respuesta['reclamaciones'] ?? [];
      $filtros = $respuesta['filtros'] ?? [];
      $estados = $respuesta['estados'] ?? [];
    break;

    case 'reclamaciones.pendientes_asignacion':
      $reclamacionService = new ReclamacionService($pdo);
      $controller = new ReclamacionController($pdo, $reclamacionService);
      $respuesta = $controller->pendientesAsignacion();
      $vista = $respuesta['vista'];
      $pageTitle = $respuesta['pageTitle'];
      $css = $respuesta['css'];
      $reclamaciones = $respuesta['reclamaciones'] ?? [];
    break;

    case 'reclamaciones.asignar':
      $reclamacionService = new ReclamacionService($pdo);
      $controller = new ReclamacionController($pdo, $reclamacionService);
      $respuesta = $controller->asignar();
      $vista = $respuesta['vista'];
      $pageTitle = $respuesta['pageTitle'];
      $css = $respuesta['css'];
      $reclamacion = $respuesta['reclamacion'] ?? null;
      $responsables = $respuesta['responsables'] ?? [];
      $error = $respuesta['error'] ?? null;
      $acciones_reclamacion = $respuesta['acciones_reclamacion'] ?? [];
      $respuesta = $respuesta['respuesta'] ?? [];
    break;

    case 'reclamaciones.show':
      $reclamacionService = new ReclamacionService($pdo);
      $controller = new ReclamacionController($pdo, $reclamacionService);
      $respuesta = $controller->show();
      $vista = $respuesta['vista'];
      $pageTitle = $respuesta['pageTitle'];
      $css = $respuesta['css'];
      $reclamacion = $respuesta['reclamacion'] ?? null;
      $acciones_reclamacion = $respuesta['acciones_reclamacion'] ?? [];
      $estado_opciones = $respuesta['estado_opciones'] ?? [];
      $puede_gestionar_seguimiento = $respuesta['puede_gestionar_seguimiento'] ?? false;
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
      $tipos = $respuesta['tipos'] ?? [];
      $prioridades = $respuesta['prioridades'] ?? [];
      $acciones_reclamacion = $respuesta['acciones_reclamacion'] ?? [];
      $estado_opciones = $respuesta['estado_opciones'] ?? [];
      $puede_gestionar_seguimiento = $respuesta['puede_gestionar_seguimiento'] ?? false;
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
      $acciones_reclamacion = $respuesta['acciones_reclamacion'] ?? [];
      $estado_opciones = $respuesta['estado_opciones'] ?? [];
      $puede_gestionar_seguimiento = $respuesta['puede_gestionar_seguimiento'] ?? false;
      $respuesta = $respuesta['respuesta'] ?? [];
    break;

    case 'reclamaciones.create.view':
      $vista = VIEWS_PATH . '/reclamaciones/create.php';
      $pageTitle = 'Crear reclamación';
      $css = '/assets/css/reclamacion.create.css';
    break;

    case 'reclamaciones.create':
      $reclamacionService = new ReclamacionService($pdo);
      $controller = new ReclamacionController($pdo, $reclamacionService);
      $respuesta = $controller->create();
      // mostrar la misma vista de creación con el resultado (mensaje)
      $vista = VIEWS_PATH . '/reclamaciones/create.php';
      $pageTitle = 'Crear reclamación';
      $css = '/assets/css/reclamacion.create.css';
    break;

    case 'admin.index':
      $adminService = new AdminService($pdo);
      $controller = new AdminController($adminService);
      $respuesta = $controller->index();
      $vista = $respuesta['vista'];
      $pageTitle = $respuesta['pageTitle'];
      $css = $respuesta['css'];
      $usuarios = $respuesta['usuarios'] ?? [];
      $roles = $respuesta['roles'] ?? [];
      $franquicias = $respuesta['franquicias'] ?? [];
      $usuarioEditar = $respuesta['usuarioEditar'] ?? null;
      $franquiciaEditar = $respuesta['franquiciaEditar'] ?? null;
      $respuesta = $respuesta['respuesta'] ?? [];
    break;

    case 'admin.usuario.guardar':
      $adminService = new AdminService($pdo);
      $controller = new AdminController($adminService);
      $respuesta = $controller->guardarUsuario();
      $vista = $respuesta['vista'];
      $pageTitle = $respuesta['pageTitle'];
      $css = $respuesta['css'];
      $usuarios = $respuesta['usuarios'] ?? [];
      $roles = $respuesta['roles'] ?? [];
      $franquicias = $respuesta['franquicias'] ?? [];
      $usuarioEditar = $respuesta['usuarioEditar'] ?? null;
      $franquiciaEditar = $respuesta['franquiciaEditar'] ?? null;
      $respuesta = $respuesta['respuesta'] ?? [];
    break;

    case 'admin.franquicia.guardar':
      $adminService = new AdminService($pdo);
      $controller = new AdminController($adminService);
      $respuesta = $controller->guardarFranquicia();
      $vista = $respuesta['vista'];
      $pageTitle = $respuesta['pageTitle'];
      $css = $respuesta['css'];
      $usuarios = $respuesta['usuarios'] ?? [];
      $roles = $respuesta['roles'] ?? [];
      $franquicias = $respuesta['franquicias'] ?? [];
      $usuarioEditar = $respuesta['usuarioEditar'] ?? null;
      $franquiciaEditar = $respuesta['franquiciaEditar'] ?? null;
      $respuesta = $respuesta['respuesta'] ?? [];
    break;

    default:
      $mensaje = "Acción no permitida";
      $pageTitle = "login";
      $vista = '/../auth/login.php'; 
      $css = '/assets/css/login.css'; 
    break;

  }

  // cargar layout.php (es quien decide qué vista debe cargar)
  $layout = in_array($action, $protectedActions, true)
    ? 'app.layout.php'
    : 'auth.layout.php';

  require_once LAYOUTS_PATH . '/' . $layout;
?>
