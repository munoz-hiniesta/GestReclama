<?php

  class AuthService {

    public function getUserByEmail($pdo, $email) {

    // preparar stmt (PDO)
      $stmt = $pdo->prepare(
      "SELECT *
       FROM usuarios
       WHERE email = :email
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