<?php

  class AccionesReclamacionService {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
      $this->pdo = $pdo;
    }
    
    // obtener acciones de una reclamación
    public function obtenerAccionesPorReclamacion(int $reclamacionId): array {
      try {
        $sql = "SELECT ar.id,
                       ar.comentario,
                       ar.fecha,
                       ar.reclamacion_id,
                       ar.usuario_id,
                       u.nombre AS usuario_nombre,
                       ar.estado_id,
                       e.clave AS estado_clave,
                       e.nombre AS estado_nombre
                  FROM acciones_reclamacion ar
                  LEFT JOIN usuarios u ON ar.usuario_id = u.id
                  LEFT JOIN estados e ON ar.estado_id = e.id
                 WHERE ar.reclamacion_id = :reclamacion_id
                 ORDER BY ar.fecha ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':reclamacion_id' => $reclamacionId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function obtenerAccionPorId(int $id): ?array {
      try {
        $sql = "SELECT ar.id,
                       ar.comentario,
                       ar.fecha,
                       ar.reclamacion_id,
                       ar.usuario_id,
                       u.nombre AS usuario_nombre,
                       ar.estado_id,
                       e.nombre AS estado_nombre
                  FROM acciones_reclamacion ar
                  LEFT JOIN usuarios u ON ar.usuario_id = u.id
                  LEFT JOIN estados e ON ar.estado_id = e.id
                 WHERE ar.id = :id
                 LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $accion = $stmt->fetch(PDO::FETCH_ASSOC);
        return $accion ?: null;
      } catch (Exception $e) {
        return null;
      }
    }

    // crear acción de reclamación
    public function crearAccion(int $reclamacionId, int $usuarioId, int $estadoId, string $comentario): array {
      try {
        $sql = "INSERT INTO acciones_reclamacion (reclamacion_id, usuario_id, estado_id, comentario) 
                       VALUES (:reclamacion_id, :usuario_id, :estado_id, :comentario)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
          ':reclamacion_id' => $reclamacionId,
          ':usuario_id' => $usuarioId,
          ':estado_id' => $estadoId,
          ':comentario' => $comentario
        ]);

        $id = (int)$this->pdo->lastInsertId();

        return ['success' => true, 'id' => $id, 'mensaje' => 'Acción registrada correctamente.'];
      } catch (Exception $e) {
        return ['success' => false, 'id' => null, 'mensaje' => 'Error al registrar la acción: '];
      }
    }

  }

?>
