<?php

  session_start();  
  
  // simular sesión activa con datos
  $_SESSION['id'] = 1;
  $_POST['action'] = "logout";
  $_SERVER['REQUEST_METHOD'] = 'POST';

  // llamar a index.php
  require_once PUBLIC_PATH . '/index.php';

?>