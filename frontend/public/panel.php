<?php

  require_once '../../backend/bootstrap/bootstrap.php';
  require_once MIDDLEWARE_PATH . '/auth.php';

  // recuperar datos de sesión (se mantiene activa hasta que se cierra con logout)  
  $id = $_SESSION['id'];
  $rol_id = $_SESSION['rol_id'];

  // preparar para renderizado layout - vista
  $pageTitle = "panel";
  $vista = '/../panel/panel.php';
  $css = '/css/panel.css';

  // renderizar
  require LAYOUTS_PATH . '/auth.layout.php';

?>