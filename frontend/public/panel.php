<?php

  require_once __DIR__ . '/../../backend/middleware/auth.php';

  // recuperar datos de sesión (se mantiene activa hasta que se cierra con logout)  
  $id = $_SESSION['id'];
  $rol_id = $_SESSION['rol_id'];

  // preparar para renderizado layout - vista
  $pageTitle = "panel";
  $vista = '/../panel/panel.php';
  $css = '/css/panel.css';

  // renderizar
  require __DIR__ . '/../views/layouts/layout.php';

?>