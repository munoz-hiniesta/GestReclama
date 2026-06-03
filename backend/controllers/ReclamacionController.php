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
      $datos = [
        'descripcion' => $_POST['descripcion'] ?? '',
        'tipo_id' => $_POST['tipo_id'] ?? 0,
        'prioridad_id' => $_POST['prioridad_id'] ?? 0,
        'estado_id' => 1,
        'franquicia_id' => 1,
        'adjunto' => $_POST['adjunto'] ?? null,
        'usuario_creador_id' => 1
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