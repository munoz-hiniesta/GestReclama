<?php

  require_once __DIR__ . '/../services/AuthService.php';

  class AuthController {
    
    public function login () {  

      // comprobar método de envío del formulario
      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
      }
      
      // limpiar datos
      $email    = trim($_POST['email'] ?? '');
      $password = trim($_POST['password'] ?? '');

      // comprobar que ningún dato esté vacío
      if ($email === '' || $password === '') {
        echo "Todos los campos son obligatorios";
        return;
      }

      // cargar conexión PDO
      $pdo = require __DIR__ . '/../database/connection.php';

      // llamar a AuthService.php (crear instancia, llamar método)
      $authService = new AuthService();
      $user        = $authService->getUserByEmail($pdo, $email);

      // comprobar datos de AuthService.php
      if ($user) {
        echo "usuario existe";
      } else {
        echo "usuario no existe";
      }

    }

  }

?>