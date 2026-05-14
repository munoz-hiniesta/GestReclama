<?php

  require_once SERVICES_PATH . '/AuthService.php';

  class AuthController {
    
    private PDO $pdo;

    // integrar conexión PDO en la clase (viene de backend/database/connection.php - frontend/index.php)
    public function __construct(PDO $pdo) {
      $this->pdo = $pdo;
    }
  
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

      // llamar a AuthService.php (crear instancia, llamar método)

      $authService = new AuthService();
      $user = $authService->getUserByEmail($this->pdo, $email);

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

      // redirijo
      header ('Location: panel.php'); 
      exit;
    }

    public function logout () {

      // vaciar y cerrar sesión
      $_SESSION = [];
      session_destroy();

      // // redirigir creando nueva petición (no guarda POST)
      header ('Location: index.php');
      exit;
    }

  }

?>