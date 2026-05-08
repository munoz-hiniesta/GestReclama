<?php

  session_start(); /** necesario para acceder a la sesión en cada petición PHP que requiera $_SESSION */

  // validar autenticación
  if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
  }

  // recuperar datos de sesión (se mantiene activa hasta que se cierra con logout)  
  $id = $_SESSION['id'];
  $rol_id = $_SESSION['rol_id'];

  // preparar para renderizado layout - vista
  $pageTitle = "panel";
  $vista = '/../views/panel/panel.php';
  $css = '/css/panel.css';

  // renderizar
  require __DIR__ . '/../views/layouts/layout.php';

?>