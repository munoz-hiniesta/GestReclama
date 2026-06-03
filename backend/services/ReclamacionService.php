<?php

  class ReclamacionService {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
      $this->pdo = $pdo;
    }

    public function guardarBorrador(array $datos) {
      try {
        $sql = "INSERT
          INTO reclamaciones (descripcion,
                              tipo_id,
                              prioridad_id,
                              telefono,
                              email,
                              importe,
                              otros_datos,
                              estado_id,
                              franquicia_id,
                              adjunto,
                              usuario_creador_id,
                              fecha_creacion)
          VALUES (:descripcion,
                  :tipo_id,
                  :prioridad_id,
                  :telefono,
                  :email,
                  :importe,
                  :otros_datos,
                  :estado_id,
                  :franquicia_id,
                  :adjunto,
                  :usuario_creador_id,
                  NOW())";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
          ':descripcion' => $datos['descripcion'],
          ':tipo_id' => $datos['tipo_id'],
          ':prioridad_id' => $datos['prioridad_id'],
          ':telefono' => $datos['telefono'],
          ':email' => $datos['email'],
          ':importe' => $datos['importe'],
          ':otros_datos' => $datos['otros_datos'],
          ':estado_id' => $datos['estado_id'],
          ':franquicia_id' => $datos['franquicia_id'],
          ':adjunto' => $datos['adjunto'],
          ':usuario_creador_id' => $datos['usuario_creador_id']
        ]);

        return [
          'success' => true,
          'mensaje' => 'Reclamación guardada correctamente'
        ];
      } catch (Exception $e) {
        return [
          'success' => false,
          'mensaje' => 'Error al guardar reclamación: ' . $e->getMessage()
        ];
      }
    }

    public function obtenerReclamaciones() {
      try {
        $sql = "SELECT id, descripcion, estado_id, fecha_creacion
                  FROM reclamaciones
                 ORDER BY id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function obtenerReclamacionPorId(int $id) {
      try {
        $sql = "SELECT id,
                       descripcion,
                       tipo_id,
                       prioridad_id,
                       estado_id,
                       franquicia_id,
                       telefono,
                       email,
                       importe,
                       otros_datos,
                       adjunto,
                       usuario_creador_id,
                       fecha_creacion
                  FROM reclamaciones
                 WHERE id = :id
                 LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $reclamacion = $stmt->fetch(PDO::FETCH_ASSOC);

        return $reclamacion ?: null;
      } catch (Exception $e) {
        return null;
      }
    }

    public function actualizarBorrador(int $id, array $datos) {
      try {
        $sql = "UPDATE reclamaciones
                   SET descripcion = :descripcion,
                       tipo_id = :tipo_id,
                       prioridad_id = :prioridad_id,
                       telefono = :telefono,
                       email = :email,
                       importe = :importe,
                       otros_datos = :otros_datos
                 WHERE id = :id
                   AND estado_id = 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
          ':descripcion' => $datos['descripcion'],
          ':tipo_id' => $datos['tipo_id'],
          ':prioridad_id' => $datos['prioridad_id'],
          ':telefono' => $datos['telefono'],
          ':email' => $datos['email'],
          ':importe' => $datos['importe'],
          ':otros_datos' => $datos['otros_datos'],
          ':id' => $id
        ]);

        if ($stmt->rowCount() === 0) {
          return [
            'success' => false,
            'mensaje' => 'No se pudo actualizar la reclamación. Asegúrese de que está en estado borrador.'
          ];
        }

        return [
          'success' => true,
          'mensaje' => 'Reclamación actualizada correctamente.'
        ];
      } catch (Exception $e) {
        return [
          'success' => false,
          'mensaje' => 'Error al actualizar reclamación: ' . $e->getMessage()
        ];
      }
    }
  }

?>