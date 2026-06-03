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
                              nombre_apellidos,
                              fecha_incidente,
                              canal_entrada,
                              solicitud_cliente,
                              dni,
                              direccion,
                              codigo_postal,
                              ciudad,
                              provincia,
                              observaciones_internas,
                              informacion_seguimiento,
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
                  :nombre_apellidos,
                  :fecha_incidente,
                  :canal_entrada,
                  :solicitud_cliente,
                  :dni,
                  :direccion,
                  :codigo_postal,
                  :ciudad,
                  :provincia,
                  :observaciones_internas,
                  :informacion_seguimiento,
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
          ':nombre_apellidos' => $datos['nombre_apellidos'] ?? null,
          ':fecha_incidente' => $datos['fecha_incidente'] ?? null,
          ':canal_entrada' => $datos['canal_entrada'] ?? null,
          ':solicitud_cliente' => $datos['solicitud_cliente'] ?? null,
          ':dni' => $datos['dni'] ?? null,
          ':direccion' => $datos['direccion'] ?? null,
          ':codigo_postal' => $datos['codigo_postal'] ?? null,
          ':ciudad' => $datos['ciudad'] ?? null,
          ':provincia' => $datos['provincia'] ?? null,
          ':observaciones_internas' => $datos['observaciones_internas'] ?? null,
          ':informacion_seguimiento' => $datos['informacion_seguimiento'] ?? null,
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
                       nombre_apellidos,
                       fecha_incidente,
                       canal_entrada,
                       solicitud_cliente,
                       dni,
                       direccion,
                       codigo_postal,
                       ciudad,
                       provincia,
                       observaciones_internas,
                       informacion_seguimiento,
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
                       nombre_apellidos = :nombre_apellidos,
                       fecha_incidente = :fecha_incidente,
                       canal_entrada = :canal_entrada,
                       solicitud_cliente = :solicitud_cliente,
                       dni = :dni,
                       direccion = :direccion,
                       codigo_postal = :codigo_postal,
                       ciudad = :ciudad,
                       provincia = :provincia,
                       observaciones_internas = :observaciones_internas,
                       informacion_seguimiento = :informacion_seguimiento,
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
          ':nombre_apellidos' => $datos['nombre_apellidos'] ?? null,
          ':fecha_incidente' => $datos['fecha_incidente'] ?? null,
          ':canal_entrada' => $datos['canal_entrada'] ?? null,
          ':solicitud_cliente' => $datos['solicitud_cliente'] ?? null,
          ':dni' => $datos['dni'] ?? null,
          ':direccion' => $datos['direccion'] ?? null,
          ':codigo_postal' => $datos['codigo_postal'] ?? null,
          ':ciudad' => $datos['ciudad'] ?? null,
          ':provincia' => $datos['provincia'] ?? null,
          ':observaciones_internas' => $datos['observaciones_internas'] ?? null,
          ':informacion_seguimiento' => $datos['informacion_seguimiento'] ?? null,
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

    public function validarReclamacion(int $id) {
      try {
        // obtener la reclamación
        $reclamacion = $this->obtenerReclamacionPorId($id);
        
        if (!$reclamacion) {
          return [
            'success' => false,
            'mensaje' => 'La reclamación no existe.'
          ];
        }

        // verificar que está en estado BORRADOR (1)
        if ($reclamacion['estado_id'] != 1) {
          return [
            'success' => false,
            'mensaje' => 'Solo se pueden validar reclamaciones en estado BORRADOR.'
          ];
        }

        // validar datos obligatorios según RN-016
        $errores = [];

        // validar nombre_apellidos
        if (empty($reclamacion['nombre_apellidos'])) {
          $errores[] = 'Nombre y apellidos es obligatorio.';
        }

        // validar al menos una vía de contacto (teléfono o email)
        if (empty($reclamacion['telefono']) && empty($reclamacion['email'])) {
          $errores[] = 'Debe indicar al menos un teléfono o correo electrónico.';
        }

        // validar fecha_incidente
        if (empty($reclamacion['fecha_incidente'])) {
          $errores[] = 'Fecha del incidente es obligatoria.';
        } elseif ($reclamacion['fecha_incidente'] > date('Y-m-d')) {
          $errores[] = 'La fecha del incidente no puede ser posterior a la fecha actual.';
        }

        // validar canal_entrada
        if (empty($reclamacion['canal_entrada'])) {
          $errores[] = 'Canal de entrada es obligatorio.';
        }

        // validar solicitud_cliente
        if (empty($reclamacion['solicitud_cliente'])) {
          $errores[] = 'Solicitud del cliente es obligatoria.';
        }

        // validar documento adjunto
        if (empty($reclamacion['adjunto'])) {
          $errores[] = 'Documento adjunto es obligatorio.';
        }

        // si hay errores, devolverlos sin cambiar estado
        if (!empty($errores)) {
          return [
            'success' => false,
            'mensaje' => 'Validación fallida. Errores encontrados: ' . implode(' ', $errores)
          ];
        }

        // si todas las validaciones son correctas, cambiar estado a PENDIENTE (2)
        $sql = "UPDATE reclamaciones
                   SET estado_id = 2,
                       fecha_actualizacion = NOW()
                 WHERE id = :id
                   AND estado_id = 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        if ($stmt->rowCount() === 0) {
          return [
            'success' => false,
            'mensaje' => 'No se pudo actualizar el estado de la reclamación.'
          ];
        }

        return [
          'success' => true,
          'mensaje' => 'Reclamación validada correctamente. Estado actualizado a PENDIENTE.'
        ];
      } catch (Exception $e) {
        return [
          'success' => false,
          'mensaje' => 'Error al validar reclamación: ' . $e->getMessage()
        ];
      }
    }
  }

?>