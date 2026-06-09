<?php

  require_once SERVICES_PATH . '/AuthService.php';

  class AuthController {
    
    private PDO $pdo;

    // guardar conexión PDO
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

      // obtener usuario por email
      $authService = new AuthService();
      $user = $authService->obtenerUsuarioPorEmail($this->pdo, $email);

      // comprobar que el usuario existe
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
      // rol funcional para el workflow actual encargado puede validar, trabajador no
      $_SESSION['rol'] = ($user['rol_clave'] === 'ENCARGADO') ? 'encargado' : 'trabajador';

      // redirigir al panel
      header ('Location: panel.php'); 
      exit;
    }

    public function logout () {

      // vaciar y cerrar sesión
      $_SESSION = [];
      session_destroy();

      // redirigir creando nueva petición (no guarda POST)
      header ('Location: index.php');
      exit;
    }

  }

?>