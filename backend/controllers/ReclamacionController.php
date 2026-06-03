<?php

  /* coordina las peticiones del módulo reclamaciones, actuando como intermediario entre
    frontend, services backend y modelos de persistencia.
  */

  require_once SERVICES_PATH . '/ReclamacionService.php';

  class ReclamacionController {

    private PDO $pdo;
    private ReclamacionService $reclamacionService;

    // integrar conexión PDO en la clase (viene de backend/database/connection.php - frontend/index.php)
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
      $importe = trim($_POST['importe'] ?? '');
      $otros_datos = trim($_POST['otros_datos'] ?? '');
      $franquicia_id = intval($_POST['franquicia_id'] ?? 0) ?: 1;

      if ($telefono !== '' && !preg_match('/^[0-9+\s()\-]{6,20}$/', $telefono)) {
        return ['success' => false, 'mensaje' => 'Teléfono no tiene un formato válido.'];
      }

      // usuario creador desde sesión si está disponible
      $usuario_creador_id = $_SESSION['usuario_id'] ?? 1;

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
        // Según RN-015, para guardar BORRADOR es necesario el documento firmado
        return ['success' => false, 'mensaje' => 'Debe adjuntar un documento firmado para guardar el borrador'];
      }

      $datos = [
        'descripcion' => $descripcion,
        'tipo_id' => $tipo_id,
        'prioridad_id' => $prioridad_id,
        'telefono' => $telefono !== '' ? $telefono : null,
        'email' => $email !== '' ? $email : null,
        'importe' => $importe !== '' ? $importe : null,
        'otros_datos' => $otros_datos !== '' ? $otros_datos : null,
        'estado_id' => 1,
        'franquicia_id' => $franquicia_id,
        'adjunto' => $adjunto_nombre,
        'usuario_creador_id' => $usuario_creador_id
      ];

      $resultado = $this->reclamacionService->guardarBorrador($datos);

      return $resultado;
    }

    // mostrar reclamaciones en estado borrador (más adelante filtros)
    public function index() {
      $reclamaciones = $this->reclamacionService->obtenerReclamaciones();

      return [
        'vista' => VIEWS_PATH . '/reclamaciones/index.php',
        'pageTitle' => 'Índice de reclamaciones',
        'css' => CSS_PATH . '/reclamacion.index.css',
        'reclamaciones' => $reclamaciones
      ];
    }

    // mostrar una reclamación concreta (todos sus datos)
    public function show() {
      $id = intval($_GET['id'] ?? 0);

      if ($id <= 0) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/show.php',
          'pageTitle' => 'Reclamación no encontrada',
          'css' => CSS_PATH . '/reclamacion.index.css',
          'error' => 'ID de reclamación no válido.'
        ];
      }

      $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);

      if (!$reclamacion) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/show.php',
          'pageTitle' => 'Reclamación no encontrada',
          'css' => CSS_PATH . '/reclamacion.index.css',
          'error' => 'La reclamación solicitada no existe.'
        ];
      }

      return [
        'vista' => VIEWS_PATH . '/reclamaciones/show.php',
        'pageTitle' => 'Ver reclamación #' . $id,
        'css' => CSS_PATH . '/reclamacion.index.css',
        'reclamacion' => $reclamacion
      ];
    }

    public function edit() {
      $id = intval($_REQUEST['id'] ?? 0);

      if ($id <= 0) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
          'pageTitle' => 'Editar reclamación',
          'css' => CSS_PATH . '/reclamacion.create.css',
          'error' => 'ID de reclamación no válido.'
        ];
      }

      $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);

      if (!$reclamacion) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
          'pageTitle' => 'Editar reclamación',
          'css' => CSS_PATH . '/reclamacion.create.css',
          'error' => 'La reclamación no existe.'
        ];
      }

      if ($reclamacion['estado_id'] !== '1' && $reclamacion['estado_id'] !== 1) {
        return [
          'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
          'pageTitle' => 'Editar reclamación',
          'css' => CSS_PATH . '/reclamacion.create.css',
          'error' => 'Solo se pueden editar reclamaciones en borrador.'
        ];
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $descripcion = trim($_POST['descripcion'] ?? '');
        $tipo_id = intval($_POST['tipo_id'] ?? 0);
        $prioridad_id = intval($_POST['prioridad_id'] ?? 0);
        $telefono = trim($_POST['telefono'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $importe = trim($_POST['importe'] ?? '');
        $otros_datos = trim($_POST['otros_datos'] ?? '');

        if ($telefono !== '' && !preg_match('/^[0-9+\s()\-]{6,20}$/', $telefono)) {
          return [
            'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
            'pageTitle' => 'Editar reclamación',
            'css' => CSS_PATH . '/reclamacion.create.css',
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
          'importe' => $importe !== '' ? $importe : null,
          'otros_datos' => $otros_datos !== '' ? $otros_datos : null
        ]);

        if ($resultado['success']) {
          $reclamacion = $this->reclamacionService->obtenerReclamacionPorId($id);
        }

        return [
          'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
          'pageTitle' => 'Editar reclamación',
          'css' => CSS_PATH . '/reclamacion.create.css',
          'reclamacion' => $reclamacion,
          'respuesta' => $resultado
        ];
      }

      return [
        'vista' => VIEWS_PATH . '/reclamaciones/edit.php',
        'pageTitle' => 'Editar reclamación',
        'css' => CSS_PATH . '/reclamacion.create.css',
        'reclamacion' => $reclamacion
      ];
    }

  }

?>