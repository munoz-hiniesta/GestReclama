<?php

  // coordinar peticiones del módulo de reclamaciones
  require_once SERVICES_PATH . '/ReclamacionService.php';
  require_once SERVICES_PATH . '/AuthService.php';
  require_once SERVICES_PATH . '/AccionesReclamacionService.php';
  require_once SERVICES_PATH . '/EstadosReclamacion.php';

  class ReclamacionController {

    private PDO $pdo;
    private ReclamacionService $reclamacionService;

    // guardar conexión PDO
    public function __construct(PDO $pdo, ReclamacionService $reclamacionService) {
      $this->pdo = $pdo;
      $this->reclamacionService = $reclamacionService;
    }

    // crear borrador reclamación (más adelante, validar)
    public function create() {
      // recoger campos
      $descripcion = trim($_POST['descripcion'] ?? '');
      $tipo_id = intval($_POST['tipo_id'] ?? 0);
      $prioridad_id = intval($_POST['prioridad_id'] ?? 0);
      $telefono = trim($_POST['telefono'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $nombre_apellidos = trim($_POST['nombre_apellidos'] ?? '');
      $fecha_incidente = trim($_POST['fecha_incidente'] ?? '');
      $canal_entrada = trim($_POST['canal_entrada'] ?? '');
      $solicitud_cliente = trim($_POST['solicitud_cliente'] ?? '');
      $dni = trim($_POST['dni'] ?? '');
      $direccion = trim($_POST['direccion'] ?? '');
      $codigo_postal = trim($_POST['codigo_postal'] ?? '');
      $ciudad = trim($_POST['ciudad'] ?? '');
      $provincia = trim($_POST['provincia'] ?? '');
      $observaciones_internas = trim($_POST['observaciones_internas'] ?? '');
      $informacion_seguimiento = trim($_POST['informacion_seguimiento'] ?? '');
      $importe = trim($_POST['importe'] ?? '');
      $otros_datos = trim($_POST['otros_datos'] ?? '');
      $franquicia_id = intval($_POST['franquicia_id'] ?? 0);

      if ($telefono !== '' && !preg_match('/^[0-9+\s()\-]{6,20}$/', $telefono)) {
        return ['success' => false, 'mensaje' => 'Teléfono no tiene un formato válido.'];
      }

      if ($fecha_incidente !== '' && $fecha_incidente > date('Y-m-d')) {
        return ['success' => false, 'mensaje' => 'La fecha del incidente no puede ser posterior a la fecha actual.'];
      }

      // usuario creador desde sesión si está disponible
      $usuario_creador_id = intval($_SESSION['id'] ?? 0);

      if ($usuario_creador_id <= 0) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/create.php',
          'pageTitle' => 'Nueva reclamación',
          'css' => '/assets/css/reclamacion.create.css',
          'error' => 'Usuario no autenticado.'
        ];
      }

      // procesar archivo adjunto (viene en $_FILES)
      $adjunto_nombre = null;
      if (isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['adjunto']['tmp_name'];
        $orig = basename($_FILES['adjunto']['name']);
        $ext = pathinfo($orig, PATHINFO_EXTENSION);
        // crear carpeta de uploads si no existe
        $uploadDir = PUBLIC_PATH . '/uploads';
        if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0755, true);
        }
        // generar nombre único
        $newName = uniqid('adj_') . '.' . $ext;
        $dest = $uploadDir . '/' . $newName;
        if (move_uploaded_file($tmp, $dest)) {
          $adjunto_nombre = $newName;
        } else {
          return ['success' => false, 'mensaje' => 'Error al mover el archivo adjunto'];
        }
      } else {
        // exigir documento firmado para guardar borrador
        return ['success' => false, 'mensaje' => 'Debe adjuntar un documento firmado para guardar el borrador'];
      }

      $estados = EstadosReclamacion::obtenerReferencias($this->pdo);

      $datos = [
        'descripcion' => $descripcion,
        'tipo_id' => $tipo_id,
        'prioridad_id' => $prioridad_id,
        'telefono' => $telefono !== '' ? $telefono : null,
        'email' => $email !== '' ? $email : null,
        'nombre_apellidos' => $nombre_apellidos !== '' ? $nombre_apellidos : null,
        'fecha_incidente' => $fecha_incidente !== '' ? $fecha_incidente : null,
        'canal_entrada' => $canal_entrada !== '' ? $canal_entrada : null,
        'solicitud_cliente' => $solicitud_cliente !== '' ? $solicitud_cliente : null,
        'dni' => $dni !== '' ? $dni : null,
        'direccion' => $direccion !== '' ? $direccion : null,
        'codigo_postal' => $codigo_postal !== '' ? $codigo_postal : null,
        'ciudad' => $ciudad !== '' ? $ciudad : null,
        'provincia' => $provincia !== '' ? $provincia : null,
        'observaciones_internas' => $observaciones_internas !== '' ? $observaciones_internas : null,
        'informacion_seguimiento' => $informacion_seguimiento !== '' ? $informacion_seguimiento : null,
        'importe' => $importe !== '' ? $importe : null,
        'otros_datos' => $otros_datos !== '' ? $otros_datos : null,
        'estado_id' => $estados['BORRADOR'],
        'franquicia_id' => $franquicia_id,
        'adjunto' => $adjunto_nombre,
        'usuario_creador_id' => $usuario_creador_id
      ];

      $resultado = $this->reclamacionService->guardarBorrador($datos);

      return $resultado;
    }

    // mostrar reclamaciones en estado borrador (más adelante filtros)
    public function index() {
      $filtros = [
        'id' => intval($_GET['filtro_id'] ?? 0),
        'estado_id' => intval($_GET['filtro_estado_id'] ?? 0)
      ];

      $reclamaciones = $this->reclamacionService->obtenerReclamaciones($filtros);
      $estados = $this->reclamacionService->obtenerEstados();

      return [
        'vista' => VIEWS_PATH . '/reclamaciones/index.php',
        'pageTitle' => 'Índice de reclamaciones',
        'css' => '/assets/css/reclamacion.index.css',
        'reclamaciones' => $reclamaciones,
        'filtros' => $filtros,
        'estados' => $estados
      ];
    }

    public function pendientesAsignacion() {
      $reclamaciones = $this->reclamacionService->obtenerReclamacionesPendientesAsignacion();

      return [
        'vista' => VIEWS_PATH . '/reclamaciones/pendientes_asignacion.php',
        'pageTitle' => 'Reclamaciones pendientes de asignación',
        'css' => '/assets/css/reclamacion.index.css',
        'reclamaciones' => $reclamaciones
      ];
    }

    public function asignar() {
      $id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
      $reclamacion = null;
      $respuesta = [];
      $error = null;

      if ($id <= 0) {
        $error = 'ID de reclamación no válido.';
      } else {
          $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);
          if (!$reclamacion) {
            $error = 'La reclamación solicitada no existe.';
          }
      }

      $authService = new AuthService();
      $responsables = $authService->obtenerResponsablesTramitacion($this->pdo);

        $respuesta = [];

        // registrar nueva acción
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error)) {
          $nuevoComentario = trim($_POST['nuevo_comentario'] ?? '');

          if (empty($nuevoComentario)) {
            $respuesta = ['success' => false, 'mensaje' => 'El comentario no puede estar vacío.'];
          } else {
            $usuarioId = intval($_SESSION['id'] ?? 0);
            if ($usuarioId <= 0) {
              $respuesta = ['success' => false, 'mensaje' => 'Usuario no autenticado.'];
            } else {
              $estadoId = intval($reclamacion['estado_id'] ?? 0);
              $accionesService = new AccionesReclamacionService($this->pdo);
              $resultadoCrear = $accionesService->crearAccion($id, $usuarioId, $estadoId, $nuevoComentario);

              $respuesta = $resultadoCrear;

              // si se creó, recargar la reclamación y las acciones para mostrarlas
              if (!empty($resultadoCrear['success'])) {
                $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);
              }
            }
          }
        }

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && $reclamacion && empty($error)) {
        // POST para asignar responsable sigue funcionando (si existe el campo enviado)
        if (isset($_POST['usuario_responsable_id'])) {
          $usuarioResponsableId = intval($_POST['usuario_responsable_id'] ?? 0);

          if ($usuarioResponsableId <= 0) {
            $respuesta = [
              'success' => false,
              'mensaje' => 'Debes seleccionar un responsable de tramitación.'
            ];
          } elseif (($reclamacion['estado_clave'] ?? '') !== 'PENDIENTE') {
            $respuesta = [
              'success' => false,
              'mensaje' => 'La reclamación no está en estado PENDIENTE.'
            ];
          } elseif (!empty($reclamacion['usuario_responsable_id'])) {
            $respuesta = [
              'success' => false,
              'mensaje' => 'La reclamación ya tiene un responsable asignado.'
            ];
          } else {
            $selected = null;
            foreach ($responsables as $responsable) {
              if (intval($responsable['id']) === $usuarioResponsableId) {
                $selected = $responsable;
                break;
              }
            }

            if (!$selected) {
              $respuesta = [
                'success' => false,
                'mensaje' => 'Responsable de tramitación no válido.'
              ];
            } else {
              $resultado = $this->reclamacionService->asignarResponsable($id, $usuarioResponsableId);
              $respuesta = $resultado;

              if ($resultado['success']) {
                $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);
              }
            }
          }
        }
      }

      // obtener la lista actualizada de acciones para mostrar en la vista
      $accionesService = new AccionesReclamacionService($this->pdo);
      $acciones = $accionesService->obtenerAccionesPorReclamacion($id);

      return [
        'vista' => VIEWS_PATH . '/reclamaciones/asignar.php',
        'pageTitle' => 'Asignar responsable de tramitación',
        'css' => '/assets/css/reclamacion.index.css',
        'reclamacion' => $reclamacion,
        'responsables' => $responsables,
        'respuesta' => $respuesta,
        'error' => $error,
        'acciones_reclamacion' => $acciones
      ];
    }

    // mostrar una reclamación concreta (todos sus datos)
    public function show() {
      $id = intval($_GET['id'] ?? $_POST['id'] ?? 0);

      if ($id <= 0) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/show.php',
          'pageTitle' => 'Reclamación no encontrada',
          'css' => '/assets/css/reclamacion.index.css',
          'error' => 'ID de reclamación no válido.'
        ];
      }

      $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);

      if (!$reclamacion) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/show.php',
          'pageTitle' => 'Reclamación no encontrada',
          'css' => '/assets/css/reclamacion.index.css',
          'error' => 'La reclamación solicitada no existe.'
        ];
      }

      $respuesta = [];
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $estadoIdRecibido = intval($_POST['estado_id'] ?? 0);
        $comentario = trim($_POST['nuevo_comentario'] ?? '');
        $estadoIdActual = intval($reclamacion['estado_id'] ?? 0);
        $usuarioId = intval($_SESSION['id'] ?? 0);

        // validar usuario autenticado
        if ($usuarioId <= 0) {
          $respuesta = ['success' => false, 'mensaje' => 'Usuario no autenticado.'];
        }
        // Validar comentario
        elseif ($comentario === '') {
          $respuesta = ['success' => false, 'mensaje' => 'El comentario es obligatorio.'];
        }
        // Validar estado recibido
        elseif ($estadoIdRecibido <= 0) {
          $respuesta = ['success' => false, 'mensaje' => 'Estado no válido.'];
        }
        // comprobar cambio de estado
        elseif ($estadoIdRecibido !== $estadoIdActual) {
          // Obtener la clave del estado recibido para validar que es RESUELTA
          $sql = "SELECT clave FROM estados WHERE id = :id LIMIT 1";
          $stmt = $this->pdo->prepare($sql);
          $stmt->execute([':id' => $estadoIdRecibido]);
          $estadoRecibido = $stmt->fetch(PDO::FETCH_ASSOC);

          if (!$estadoRecibido || $estadoRecibido['clave'] !== 'RESUELTA') {
            $respuesta = ['success' => false, 'mensaje' => 'Transición de estado no permitida.'];
          } else {
            // Ejecutar resolución
            $resultado = $this->reclamacionService->resolverReclamacion($id, $usuarioId, $comentario);
            $respuesta = $resultado;

            if ($resultado['success']) {
              $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);
            }
          }
        }
        // Si NO hay cambio de estado, solo registrar acción de seguimiento
        else {
          $accionesService = new AccionesReclamacionService($this->pdo);
          $resultado = $accionesService->crearAccion($id, $usuarioId, $estadoIdActual, $comentario);
          $respuesta = $resultado;

          if ($resultado['success']) {
            $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);
          }
        }
      }

      $estadoOpciones = $this->reclamacionService->obtenerOpcionesEstadoResolucion(
        $reclamacion['estado_clave'] ?? '',
        intval($reclamacion['estado_id'] ?? 0)
      );

      // obtener histórico de acciones para la vista (fase 1: sólo lectura)
      $accionesService = new AccionesReclamacionService($this->pdo);
      $acciones = $accionesService->obtenerAccionesPorReclamacion($id);

      return [
        'vista' => VIEWS_PATH . '/reclamaciones/show.php',
        'pageTitle' => 'Ver reclamación #' . $id,
        'css' => '/assets/css/reclamacion.index.css',
        'reclamacion' => $reclamacion,
        'acciones_reclamacion' => $acciones,
        'estado_opciones' => $estadoOpciones,
        'respuesta' => $respuesta
      ];
    }

    public function edit() {
      $id = intval($_GET['id'] ?? $_POST['id'] ?? 0);

      if ($id <= 0) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
          'pageTitle' => 'Editar reclamación',
          'css' => '/assets/css/reclamacion.create.css',
          'error' => 'ID de reclamación no válido.'
        ];
      }

      $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);

      if (!$reclamacion) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
          'pageTitle' => 'Editar reclamación',
          'css' => '/assets/css/reclamacion.create.css',
          'error' => 'La reclamación no existe.'
        ];
      }

       $estados = EstadosReclamacion::obtenerReferencias($this->pdo);

      if ($reclamacion['estado_id'] != $estados['BORRADOR']) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
          'pageTitle' => 'Editar reclamación',
          'css' => '/assets/css/reclamacion.create.css',
          'error' => 'Solo se pueden editar reclamaciones en borrador.'
        ];
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $descripcion = trim($_POST['descripcion'] ?? '');
        $tipo_id = intval($_POST['tipo_id'] ?? 0);
        $prioridad_id = intval($_POST['prioridad_id'] ?? 0);
        $telefono = trim($_POST['telefono'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $nombre_apellidos = trim($_POST['nombre_apellidos'] ?? '');
        $fecha_incidente = trim($_POST['fecha_incidente'] ?? '');
        $canal_entrada = trim($_POST['canal_entrada'] ?? '');
        $solicitud_cliente = trim($_POST['solicitud_cliente'] ?? '');
        $dni = trim($_POST['dni'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $codigo_postal = trim($_POST['codigo_postal'] ?? '');
        $ciudad = trim($_POST['ciudad'] ?? '');
        $provincia = trim($_POST['provincia'] ?? '');
        $observaciones_internas = trim($_POST['observaciones_internas'] ?? '');
        $informacion_seguimiento = trim($_POST['informacion_seguimiento'] ?? '');
        $importe = trim($_POST['importe'] ?? '');
        $otros_datos = trim($_POST['otros_datos'] ?? '');

        if ($telefono !== '' && !preg_match('/^[0-9+\s()\-]{6,20}$/', $telefono)) {
          return [
            'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
            'pageTitle' => 'Editar reclamación',
            'css' => '/assets/css/reclamacion.create.css',
            'reclamacion' => $reclamacion,
            'respuesta' => [
              'success' => false,
              'mensaje' => 'Teléfono no tiene un formato válido.'
            ]
          ];
        }

        $resultado = $this->reclamacionService->actualizarBorrador($id, [
          'descripcion' => $descripcion,
          'tipo_id' => $tipo_id,
          'prioridad_id' => $prioridad_id,
          'telefono' => $telefono !== '' ? $telefono : null,
          'email' => $email !== '' ? $email : null,
          'nombre_apellidos' => $nombre_apellidos !== '' ? $nombre_apellidos : null,
          'fecha_incidente' => $fecha_incidente !== '' ? $fecha_incidente : null,
          'canal_entrada' => $canal_entrada !== '' ? $canal_entrada : null,
          'solicitud_cliente' => $solicitud_cliente !== '' ? $solicitud_cliente : null,
          'dni' => $dni !== '' ? $dni : null,
          'direccion' => $direccion !== '' ? $direccion : null,
          'codigo_postal' => $codigo_postal !== '' ? $codigo_postal : null,
          'ciudad' => $ciudad !== '' ? $ciudad : null,
          'provincia' => $provincia !== '' ? $provincia : null,
          'observaciones_internas' => $observaciones_internas !== '' ? $observaciones_internas : null,
          'informacion_seguimiento' => $informacion_seguimiento !== '' ? $informacion_seguimiento : null,
          'importe' => $importe !== '' ? $importe : null,
          'otros_datos' => $otros_datos !== '' ? $otros_datos : null
        ]);

        if ($resultado['success']) {
          $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);
        }

        $tipos = $this->reclamacionService->obtenerTipos();
        $prioridades = $this->reclamacionService->obtenerPrioridades();

        return [
          'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
          'pageTitle' => 'Editar reclamación',
          'css' => '/assets/css/reclamacion.create.css',
          'reclamacion' => $reclamacion,
          'respuesta' => $resultado,
          'tipos' => $tipos,
          'prioridades' => $prioridades
        ];
      }

      $tipos = $this->reclamacionService->obtenerTipos();
      $prioridades = $this->reclamacionService->obtenerPrioridades();

      return [
        'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
        'pageTitle' => 'Editar reclamación',
        'css' => '/assets/css/reclamacion.create.css',
        'reclamacion' => $reclamacion,
        'tipos' => $tipos,
        'prioridades' => $prioridades
      ];
    }

    public function validar() {
      $id = intval($_GET['id'] ?? 0);

      if ($id <= 0) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/show.php',
          'pageTitle' => 'Reclamación no encontrada',
          'css' => '/assets/css/reclamacion.index.css',
          'error' => 'ID de reclamación no válido.'
        ];
      }

      // obtener la reclamación antes de validar
      $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);

      if (!$reclamacion) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/show.php',
          'pageTitle' => 'Reclamación no encontrada',
          'css' => '/assets/css/reclamacion.index.css',
          'error' => 'La reclamación solicitada no existe.'
        ];
      }

      // restringir la validación a encargados funcionales
      if (($_SESSION['rol'] ?? 'trabajador') !== 'encargado') {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/show.php',
          'pageTitle' => 'Ver reclamación #' . $id,
          'css' => '/assets/css/reclamacion.index.css',
          'reclamacion' => $reclamacion,
          'respuesta' => [
            'success' => false,
            'mensaje' => 'Solo el encargado puede validar reclamaciones.'
          ]
        ];
      }

      // validar la reclamación
      $resultado = $this->reclamacionService->validarReclamacion($id);

      // si la validación fue exitosa, obtener los datos actualizados
      if ($resultado['success']) {
        $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);
      }

      return [
        'vista' => VIEWS_PATH . '/reclamaciones/show.php',
        'pageTitle' => 'Ver reclamación #' . $id,
        'css' => '/assets/css/reclamacion.index.css',
        'reclamacion' => $reclamacion,
        'respuesta' => $resultado
      ];
    }

  }

?>
