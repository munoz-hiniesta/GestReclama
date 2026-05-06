<?php

  require_once __DIR__ . '/../services/AuthService.php';

  class AuthController {
    
    public function login () {  

      $mensaje = '';
      $email = '';
     
      // limpiar datos
      $email    = trim($_POST['email'] ?? '');
      $password = trim($_POST['password'] ?? '');

      // comprobar que ningún dato esté vacío
      if ($email === '' || $password === '') {
        $mensaje = "Todos los campos son obligatorios";
        return [
          'mensaje' => $mensaje,
          'email' => $email
        ];
      }

      // cargar conexión PDO
      $pdo = require __DIR__ . '/../database/connection.php';

      // llamar a AuthService.php (crear instancia, llamar método)
      $authService = new AuthService();
      $user = $authService->getUserByEmail($pdo, $email);

      // comprobar datos de AuthService.php - usuario inexistente
      if (!$user) {
        $mensaje = "usuario no existe";
        return [
          'mensaje' => $mensaje,
          'email' => $email
        ];
      }
      
      // verificar password
      if (!password_verify($password, $user['password'])) {
        $mensaje = "password incorrecto";
        return [
          'mensaje' => $mensaje,
          'email' => $email
        ];
      }
      
      // guardar datos en sesión
      $_SESSION['id'] = $user['id'];
      $_SESSION['nombre'] = $user['nombre'];
      $_SESSION['rol_id'] = $user['rol_id'];

      // redirigir a index.php
      header ('Location: index.php');
      exit;
    }

  }

?>