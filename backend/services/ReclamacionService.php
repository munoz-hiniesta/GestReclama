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

    public function obtenerReclamaciones(array $filtros = []) {
      try {
        $sql = "SELECT r.id,
                       r.descripcion,
                       r.fecha_creacion,
                       r.tipo_id,
                       t.nombre AS tipo_nombre,
                       r.prioridad_id,
                       p.nombre AS prioridad_nombre,
                       r.estado_id,
                       e.clave AS estado_clave,
                       e.nombre AS estado_nombre
                  FROM reclamaciones r
                  LEFT JOIN tipos t ON r.tipo_id = t.id
                  LEFT JOIN prioridades p ON r.prioridad_id = p.id
                  LEFT JOIN estados e ON r.estado_id = e.id";

        $where = [];
        $params = [];

        if (!empty($filtros['id'])) {
          $where[] = "r.id = :id";
          $params[':id'] = $filtros['id'];
        }

        if (!empty($filtros['estado_id'])) {
          $where[] = "r.estado_id = :estado_id";
          $params[':estado_id'] = $filtros['estado_id'];
        }

        if (!empty($where)) {
          $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY r.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function obtenerEstados() {
      try {
        $stmt = $this->pdo->prepare("SELECT id, nombre FROM estados WHERE activo = TRUE ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function obtenerFranquiciaPrincipalUsuario(int $usuarioId): ?int {
      try {
        $sql = "SELECT uf.franquicia_id
                  FROM usuario_franquicia uf
                  JOIN franquicias f ON f.id = uf.franquicia_id
                 WHERE uf.usuario_id = :usuario_id
                   AND f.activo = TRUE
                 ORDER BY uf.franquicia_id ASC
                 LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuarioId]);
        $franquiciaId = $stmt->fetchColumn();

        return $franquiciaId ? intval($franquiciaId) : null;
      } catch (Exception $e) {
        return null;
      }
    }

    public function obtenerOpcionesEstadoResolucion(string $estadoClave, int $estadoId) {
      try {
        if ($estadoClave === 'EN_TRAMITE') {
          $sql = "SELECT id, clave, nombre
                    FROM estados
                   WHERE activo = TRUE
                     AND clave IN ('EN_TRAMITE', 'RESUELTA')
                   ORDER BY FIELD(clave, 'EN_TRAMITE', 'RESUELTA')";

          $stmt = $this->pdo->prepare($sql);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($estadoClave === 'RESUELTA') {
          $sql = "SELECT id, clave, nombre
                    FROM estados
                   WHERE activo = TRUE
                     AND clave = 'RESUELTA'
                   LIMIT 1";

          $stmt = $this->pdo->prepare($sql);
          $stmt->execute();
          $estado = $stmt->fetch(PDO::FETCH_ASSOC);
          return $estado ? [$estado] : [];
        }

        $sql = "SELECT id, clave, nombre
                  FROM estados
                 WHERE activo = TRUE
                   AND id = :id
                 LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $estadoId]);
        $estado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $estado ? [$estado] : [];
      } catch (Exception $e) {
        return [];
      }
    }

    public function resolverReclamacion(int $id, int $usuarioId, string $comentario, bool $esAdmin = false) {
      try {
        // obtener reclamación
        $reclamacion = $this->obtenerReclamacionPorId($id);
        
        if (!$reclamacion) {
          return ['success' => false, 'mensaje' => 'La reclamación no existe.'];
        }

        // verificar responsable asignado
        if (!$esAdmin && (int)$reclamacion['usuario_responsable_id'] !== $usuarioId) {
          return [
            'success' => false,
            'mensaje' => 'Solo el responsable asignado puede resolver la reclamación.'
          ];
        }

        // verificar estado en trámite
        $estadoActual = $reclamacion['estado_clave'] ?? '';
        if ($estadoActual !== 'EN_TRAMITE') {
          return ['success' => false, 'mensaje' => 'Solo se pueden resolver reclamaciones en estado EN_TRÁMITE.'];
        }

        // verificar acciones de seguimiento previas
        $accionesService = new AccionesReclamacionService($this->pdo);
        $acciones = $accionesService->obtenerAccionesPorReclamacion($id);

        if (count($acciones) === 0) {
          return [
            'success' => false,
            'mensaje' => 'Debe existir al menos una acción de seguimiento antes de resolver la reclamación.'
          ];
        }

        // obtener estado RESUELTA
        $sql = "SELECT id FROM estados WHERE clave = 'RESUELTA' AND activo = TRUE LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $estadoResuelto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$estadoResuelto) {
          return ['success' => false, 'mensaje' => 'Estado RESUELTA no encontrado.'];
        }

        $estadoResueltoId = intval($estadoResuelto['id']);

        // actualizar estado y fecha de actualización
        $sql = "UPDATE reclamaciones
                SET estado_id = :estado_resuelto,
                    fecha_actualizacion = NOW()
                WHERE id = :id
                  AND estado_id = :estado_actual";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
          ':estado_resuelto' => $estadoResueltoId,
          ':estado_actual' => $reclamacion['estado_id'],
          ':id' => $id
        ]);

        // registrar acción de resolución
        $accionesService = new AccionesReclamacionService($this->pdo);
        $resultadoAccion = $accionesService->crearAccion(
          $id,
          $usuarioId,
          $estadoResueltoId,
          $comentario
        );

        if (!$resultadoAccion['success']) {
          return ['success' => false, 'mensaje' => 'Error al registrar la acción: ' . ($resultadoAccion['mensaje'] ?? '')];
        }

        return [
          'success' => true,
          'mensaje' => 'Reclamación resuelta correctamente.'
        ];
      } catch (Exception $e) {
        return [
          'success' => false,
          'mensaje' => 'Error al resolver reclamación: ' . $e->getMessage()
        ];
      }
    }

    public function obtenerReclamacionesPendientesAsignacion() {
      try {
        $sql = "SELECT r.id,
                       r.descripcion,
                       r.tipo_id,
                       t.nombre AS tipo_nombre,
                       r.prioridad_id,
                       p.nombre AS prioridad_nombre,
                       r.estado_id,
                       e.nombre AS estado_nombre,
                       r.franquicia_id,
                       r.telefono,
                       r.email,
                       r.nombre_apellidos,
                       r.fecha_incidente,
                       r.canal_entrada,
                       r.solicitud_cliente,
                       r.dni,
                       r.direccion,
                       r.codigo_postal,
                       r.ciudad,
                       r.provincia,
                       r.observaciones_internas,
                       r.informacion_seguimiento,
                       r.importe,
                       r.otros_datos,
                       r.adjunto,
                       r.usuario_creador_id,
                       r.usuario_responsable_id,
                       r.fecha_creacion
                  FROM reclamaciones r
                  LEFT JOIN tipos t ON r.tipo_id = t.id
                  LEFT JOIN prioridades p ON r.prioridad_id = p.id
                  JOIN estados e ON r.estado_id = e.id
                 WHERE e.clave = 'PENDIENTE'
                   AND r.usuario_responsable_id IS NULL
                 ORDER BY r.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function obtenerTipos() {
      try {
        $stmt = $this->pdo->prepare("SELECT id, nombre FROM tipos ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function obtenerPrioridades() {
      try {
        $stmt = $this->pdo->prepare("SELECT id, nombre FROM prioridades ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return [];
      }
    }

    public function asignarResponsable(int $id, int $usuarioResponsableId) {
      try {
        $sql = "UPDATE reclamaciones
                   SET usuario_responsable_id = :usuario_responsable_id,
                       estado_id = (SELECT id FROM estados WHERE clave = 'EN_TRAMITE' LIMIT 1),
                       fecha_actualizacion = NOW()
                 WHERE id = :id
                   AND estado_id = (SELECT id FROM estados WHERE clave = 'PENDIENTE' LIMIT 1)
                   AND usuario_responsable_id IS NULL";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
          ':usuario_responsable_id' => $usuarioResponsableId,
          ':id' => $id
        ]);

        if ($stmt->rowCount() === 0) {
          return [
            'success' => false,
            'mensaje' => 'No se pudo asignar la reclamación. Asegúrese de que está pendiente y sin responsable asignado.'
          ];
        }

        return [
          'success' => true,
          'mensaje' => 'Responsable asignado correctamente y estado cambiado a EN TRÁMITE.'
        ];
      } catch (Exception $e) {
        return [
          'success' => false,
          'mensaje' => 'Error al asignar la reclamación: ' . $e->getMessage()
        ];
      }
    }

    public function obtenerReclamacionPorId(int $id) {
      try {
        $sql = "SELECT r.id,
                 r.descripcion,
                 r.tipo_id,
                 t.nombre AS tipo_nombre,
                 r.prioridad_id,
                 p.nombre AS prioridad_nombre,
                 r.estado_id,
            ur.nombre AS responsable_nombre,
                 e.clave AS estado_clave,
                 e.nombre AS estado_nombre,
                 r.franquicia_id,
                 f.nombre AS franquicia_nombre,
                 r.usuario_creador_id,
                 uc.nombre AS usuario_creador_nombre,
                       r.telefono,
                       r.email,
                       r.nombre_apellidos,
                       r.fecha_incidente,
                       r.canal_entrada,
                       r.solicitud_cliente,
                       r.dni,
                       r.direccion,
                       r.codigo_postal,
                       r.ciudad,
                       r.provincia,
                       r.observaciones_internas,
                       r.informacion_seguimiento,
                       r.importe,
                       r.otros_datos,
                       r.adjunto,
                       r.usuario_creador_id,
                       r.usuario_responsable_id,
                       r.fecha_creacion
                  FROM reclamaciones r
                  LEFT JOIN tipos t ON r.tipo_id = t.id
                  LEFT JOIN prioridades p ON r.prioridad_id = p.id
                  LEFT JOIN estados e ON r.estado_id = e.id
                   LEFT JOIN usuarios ur ON r.usuario_responsable_id = ur.id
                   LEFT JOIN franquicias f ON r.franquicia_id = f.id
                   LEFT JOIN usuarios uc ON r.usuario_creador_id = uc.id
                 WHERE r.id = :id
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

        $estados = EstadosReclamacion::obtenerReferencias($this->pdo);

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
                   AND estado_id = :estado_borrador";

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
          ':id' => $id,
          ':estado_borrador' => $estados['BORRADOR']
        ]);

        if ($stmt->rowCount() === 0) {
          $sqlExiste = "SELECT COUNT(*) 
                          FROM reclamaciones 
                         WHERE id = :id 
                           AND estado_id = :estado_borrador";
          $stmtExiste = $this->pdo->prepare($sqlExiste);
          $stmtExiste->execute([
            ':id' => $id,
            ':estado_borrador' => $estados['BORRADOR']
          ]);

          if (intval($stmtExiste->fetchColumn()) === 1) {
            return [
              'success' => true,
              'mensaje' => 'Reclamación actualizada correctamente.'
            ];
          }

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

        $estados = EstadosReclamacion::obtenerReferencias($this->pdo);

        // verificar estado borrador
        if ($reclamacion['estado_id'] != $estados['BORRADOR']) {
          return [
            'success' => false,
            'mensaje' => 'Solo se pueden validar reclamaciones en estado BORRADOR.'
          ];
        }

        // validar datos obligatorios
        $errores = [];

        // validar nombre_apellidos
        if (empty($reclamacion['nombre_apellidos'])) {
          $errores[] = 'Nombre y apellidos es obligatorio.';
        }

        // validar vía de contacto
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

        // devolver errores de validación
        if (!empty($errores)) {
          return [
            'success' => false,
            'mensaje' => 'Validación fallida. Errores encontrados: ' . implode(' ', $errores)
          ];
        }

        // cambiar estado a pendiente
        $sql = "UPDATE reclamaciones
                   SET estado_id = :estado_pendiente,
                       fecha_actualizacion = NOW()
                 WHERE id = :id
                   AND estado_id = :estado_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
          ':id' => $id,
          ':estado_pendiente' => $estados['PENDIENTE'],
          ':estado_id' => $estados['BORRADOR']
        ]);

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
