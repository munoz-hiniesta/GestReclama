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
      $franquicia_id = intval($_POST['franquicia_id'] ?? 0) ?: 1;

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
        'estado_id' => 1,
        'franquicia_id' => $franquicia_id,
        'adjunto' => $adjunto_nombre,
        'usuario_creador_id' => $usuario_creador_id
      ];

      $resultado = $this->reclamacionService->guardarBorrador($datos);

      return $resultado;
    }

    // editar borrador reclamación (más adelante, editar pre-validación)
    public function edit() {

    }

    // mostrar reclamaciones en estado borrador (más adelante filtros)
    public function index() {
      return [
        'vista' => VIEWS_PATH . '/reclamaciones/index.php',
        'pageTitle' => 'Índice de reclamaciones',
        'css' => CSS_PATH . '/reclamacion.index.css'
      ];
    }

    // mostrar una reclamación concreta (todos sus datos)
    public function show() {

    }

  }

?>