<?php

  session_start();  
  
  // simular sesión activa con datos
  $_SESSION['id'] = 1;
  $_POST['action'] = "logout";
  $_SERVER['REQUEST_METHOD'] = 'POST';

  // llamar a index.php
  require_once __DIR__ . '/../../frontend/public/index.php';

?>