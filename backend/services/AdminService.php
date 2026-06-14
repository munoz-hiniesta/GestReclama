<?php

  class AdminService {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
      $this->pdo = $pdo;
    }

    public function obtenerUsuarios(): array {
      try {
        $sql = "SELECT u.id,
                       u.nombre,
                       u.email,
                       u.rol_id,
                       r.nombre AS rol_nombre,
                       u.activo,
                       u.fecha
                  FROM usuarios u
                  LEFT JOIN roles r ON u.rol_id = r.id
                 ORDER BY u.id ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function obtenerUsuarioPorId(int $id): ?array {
      try {
        $stmt = $this->pdo->prepare("SELECT id, nombre, email, rol_id, activo FROM usuarios WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario ?: null;
      } catch (Exception $e) {
        return null;
      }
    }

    public function obtenerRoles(): array {
      try {
        $stmt = $this->pdo->prepare("SELECT id, nombre FROM roles WHERE activo = TRUE ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function emailExiste(string $email, ?int $exceptoId = null): bool {
      $sql = "SELECT id FROM usuarios WHERE email = :email";
      $params = [':email' => $email];

      if ($exceptoId !== null) {
        $sql .= " AND id <> :id";
        $params[':id'] = $exceptoId;
      }

      $sql .= " LIMIT 1";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($params);
      return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardarUsuario(array $datos, int $usuarioActualId): array {
      try {
        $id = intval($datos['id'] ?? 0);
        $nombre = trim($datos['nombre'] ?? '');
        $email = strtolower(trim($datos['email'] ?? ''));
        $rolId = intval($datos['rol_id'] ?? 0);
        $activo = intval($datos['activo'] ?? 0) === 1 ? 1 : 0;
        $password = trim($datos['password'] ?? '');

        if ($nombre === '' || $email === '' || $rolId <= 0) {
          return ['success' => false, 'mensaje' => 'Nombre, email y rol son obligatorios.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          return ['success' => false, 'mensaje' => 'El email no tiene un formato válido.'];
        }

        if ($this->emailExiste($email, $id > 0 ? $id : null)) {
          return ['success' => false, 'mensaje' => 'Ya existe un usuario con ese email.'];
        }

        if ($id > 0 && $id === $usuarioActualId && $activo === 0) {
          return ['success' => false, 'mensaje' => 'No puedes desactivar tu propio usuario.'];
        }

        if ($id <= 0 && $password === '') {
          return ['success' => false, 'mensaje' => 'La contraseña es obligatoria al crear un usuario.'];
        }

        if ($id > 0) {
          if ($password !== '') {
            $sql = "UPDATE usuarios
                       SET nombre = :nombre,
                           email = :email,
                           rol_id = :rol_id,
                           activo = :activo,
                           password = :password
                     WHERE id = :id";
            $params = [
              ':nombre' => $nombre,
              ':email' => $email,
              ':rol_id' => $rolId,
              ':activo' => $activo,
              ':password' => password_hash($password, PASSWORD_DEFAULT),
              ':id' => $id
            ];
          } else {
            $sql = "UPDATE usuarios
                       SET nombre = :nombre,
                           email = :email,
                           rol_id = :rol_id,
                           activo = :activo
                     WHERE id = :id";
            $params = [
              ':nombre' => $nombre,
              ':email' => $email,
              ':rol_id' => $rolId,
              ':activo' => $activo,
              ':id' => $id
            ];
          }

          $stmt = $this->pdo->prepare($sql);
          $stmt->execute($params);
          return ['success' => true, 'mensaje' => 'Usuario actualizado correctamente.'];
        }

        $sql = "INSERT INTO usuarios (nombre, email, password, rol_id, activo)
                VALUES (:nombre, :email, :password, :rol_id, :activo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
          ':nombre' => $nombre,
          ':email' => $email,
          ':password' => password_hash($password, PASSWORD_DEFAULT),
          ':rol_id' => $rolId,
          ':activo' => $activo
        ]);

        return ['success' => true, 'mensaje' => 'Usuario creado correctamente.'];
      } catch (Exception $e) {
        return ['success' => false, 'mensaje' => 'Error al guardar el usuario.'];
      }
    }

    public function obtenerFranquicias(): array {
      try {
        $stmt = $this->pdo->prepare("SELECT id, clave, nombre, ubicacion, activo FROM franquicias ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function obtenerFranquiciaPorId(int $id): ?array {
      try {
        $stmt = $this->pdo->prepare("SELECT id, clave, nombre, ubicacion, activo FROM franquicias WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $franquicia = $stmt->fetch(PDO::FETCH_ASSOC);
        return $franquicia ?: null;
      } catch (Exception $e) {
        return null;
      }
    }

    public function claveFranquiciaExiste(string $clave, ?int $exceptoId = null): bool {
      $sql = "SELECT id FROM franquicias WHERE clave = :clave";
      $params = [':clave' => $clave];

      if ($exceptoId !== null) {
        $sql .= " AND id <> :id";
        $params[':id'] = $exceptoId;
      }

      $sql .= " LIMIT 1";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($params);
      return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardarFranquicia(array $datos): array {
      try {
        $id = intval($datos['id'] ?? 0);
        $clave = strtoupper(trim($datos['clave'] ?? ''));
        $nombre = trim($datos['nombre'] ?? '');
        $ubicacion = trim($datos['ubicacion'] ?? '');
        $activo = intval($datos['activo'] ?? 0) === 1 ? 1 : 0;

        if ($clave === '' || $nombre === '' || $ubicacion === '') {
          return ['success' => false, 'mensaje' => 'Clave, nombre y ubicación son obligatorios.'];
        }

        if ($this->claveFranquiciaExiste($clave, $id > 0 ? $id : null)) {
          return ['success' => false, 'mensaje' => 'Ya existe una franquicia con esa clave.'];
        }

        if ($id > 0) {
          $sql = "UPDATE franquicias
                     SET clave = :clave,
                         nombre = :nombre,
                         ubicacion = :ubicacion,
                         activo = :activo
                   WHERE id = :id";
          $stmt = $this->pdo->prepare($sql);
          $stmt->execute([
            ':clave' => $clave,
            ':nombre' => $nombre,
            ':ubicacion' => $ubicacion,
            ':activo' => $activo,
            ':id' => $id
          ]);

          return ['success' => true, 'mensaje' => 'Franquicia actualizada correctamente.'];
        }

        $sql = "INSERT INTO franquicias (clave, nombre, ubicacion, activo)
                VALUES (:clave, :nombre, :ubicacion, :activo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
          ':clave' => $clave,
          ':nombre' => $nombre,
          ':ubicacion' => $ubicacion,
          ':activo' => $activo
        ]);

        return ['success' => true, 'mensaje' => 'Franquicia creada correctamente.'];
      } catch (Exception $e) {
        return ['success' => false, 'mensaje' => 'Error al guardar la franquicia.'];
      }
    }
  }

?>
