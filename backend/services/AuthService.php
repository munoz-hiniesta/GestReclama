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

    public function obtenerUsuariosPorRol($pdo, $rolClave) {
      try {
        $stmt = $pdo->prepare(
          "SELECT u.*
             FROM usuarios u
             JOIN roles r ON u.rol_id = r.id
            WHERE r.clave = :rol_clave
              AND u.activo = 1
            ORDER BY u.nombre ASC"
        );

        $stmt->execute(['rol_clave' => $rolClave]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function obtenerResponsablesTramitacion($pdo) {
      return $this->obtenerUsuariosPorRol($pdo, 'RESPONSABLE_TRAMITACION');
    }

  }

?>