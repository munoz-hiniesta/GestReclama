<?php

  class AuthService {

    public function obtenerUsuarioPorEmail(PDO $pdo, string $email) {

      // preparar consulta
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

      // devolver usuario encontrado o null
      return $user;

    }

    public function obtenerUsuariosPorRol(PDO $pdo, string $rolClave) {
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
      } catch (PDOException $e) {
        return [];
      }
    }

    public function obtenerResponsablesTramitacion(PDO $pdo) {
      return $this->obtenerUsuariosPorRol($pdo, 'RESPONSABLE_TRAMITACION');
    }

  }

?>