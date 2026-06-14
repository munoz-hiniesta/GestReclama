<?php

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  // constantes para estructura base
  const ROOT_PATH = __DIR__ . '/../../';

  const BACKEND_PATH = ROOT_PATH . 'backend';
  const CONFIG_PATH = BACKEND_PATH . '/config';
  const CONTROLLERS_PATH = BACKEND_PATH . '/controllers';
  const DATABASE_PATH = BACKEND_PATH . '/database';
  const MIDDLEWARE_PATH = BACKEND_PATH . '/middleware';
  const MODELS_PATH = BACKEND_PATH . '/models';
  const SERVICES_PATH = BACKEND_PATH . '/services';

  const FRONTEND_PATH = ROOT_PATH . 'frontend';
  const PUBLIC_PATH = FRONTEND_PATH . '/public';
  const ASSETS_PATH = PUBLIC_PATH . '/assets';
  const CSS_PATH = ASSETS_PATH . '/css';
  const VIEWS_PATH = FRONTEND_PATH . '/views';
  const LAYOUTS_PATH = VIEWS_PATH . '/layouts';

  // cargar conexión y obtener instancia PDO
  $pdo = require_once DATABASE_PATH . '/connection.php';

?>