<?php

  require_once SERVICES_PATH . '/AdminService.php';

  class AdminController {

    private AdminService $adminService;

    public function __construct(AdminService $adminService) {
      $this->adminService = $adminService;
    }

    private function esAdministrador(): bool {
      return intval($_SESSION['rol_id'] ?? 0) === 1;
    }

    private function respuestaBase(array $respuesta = []): array {
      $usuarioId = intval($_GET['usuario_id'] ?? 0);
      $franquiciaId = intval($_GET['franquicia_id'] ?? 0);

      return [
        'vista' => VIEWS_PATH . '/admin/index.php',
        'pageTitle' => 'Gestión administrativa',
        'css' => '/assets/css/admin.css',
        'usuarios' => $this->adminService->obtenerUsuarios(),
        'roles' => $this->adminService->obtenerRoles(),
        'franquicias' => $this->adminService->obtenerFranquicias(),
        'usuarioEditar' => $usuarioId > 0 ? $this->adminService->obtenerUsuarioPorId($usuarioId) : null,
        'franquiciaEditar' => $franquiciaId > 0 ? $this->adminService->obtenerFranquiciaPorId($franquiciaId) : null,
        'respuesta' => $respuesta
      ];
    }

    private function respuestaAccesoNoPermitido(): array {
      return [
        'vista' => VIEWS_PATH . '/admin/index.php',
        'pageTitle' => 'Gestión administrativa',
        'css' => '/assets/css/admin.css',
        'usuarios' => [],
        'roles' => [],
        'franquicias' => [],
        'usuarioEditar' => null,
        'franquiciaEditar' => null,
        'respuesta' => [
          'success' => false,
          'mensaje' => 'Acceso no permitido.'
        ]
      ];
    }

    public function index(): array {
      if (!$this->esAdministrador()) {
        return $this->respuestaAccesoNoPermitido();
      }

      return $this->respuestaBase();
    }

    public function guardarUsuario(): array {
      if (!$this->esAdministrador()) {
        return $this->respuestaAccesoNoPermitido();
      }

      $resultado = $this->adminService->guardarUsuario($_POST, intval($_SESSION['id'] ?? 0));
      return $this->respuestaBase($resultado);
    }

    public function guardarFranquicia(): array {
      if (!$this->esAdministrador()) {
        return $this->respuestaAccesoNoPermitido();
      }

      $resultado = $this->adminService->guardarFranquicia($_POST);
      return $this->respuestaBase($resultado);
    }
  }

?>
