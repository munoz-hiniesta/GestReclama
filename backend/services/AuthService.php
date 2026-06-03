<?php

  class AuthService {

    public function getUserByEmail($pdo, $email) {

      // preparar stmt (PDO)
      $stmt = $pdo->prepare(
      "SELECT u.*, r.clave AS rol_clave
       FROM usuarios u
       LEFT JOIN roles r ON r.id = u.rol_id
       WHERE u.email = :email
       LIMIT 1"
      );
    
      // ejecutar consulta
      $stmt->execute(['email' => $email]);

      // obtener usuario
      $user = $stmt->fetch();

      // devolver usuario o null a AuthController.php
      return $user;

    }

  }

?>