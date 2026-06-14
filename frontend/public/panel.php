<?php

  require_once '../../backend/bootstrap/bootstrap.php';

  // proteger acceso al panel principal; solo usuarios con sesión iniciada pueden entrar
  require_once MIDDLEWARE_PATH . '/auth.php';

  // preparar para renderizado layout - vista
  $pageTitle = "Panel";
  $vista = '/../panel/panel.php';
  $css = '/css/panel.css';

  // renderizar
  require LAYOUTS_PATH . '/app.layout.php';

?>