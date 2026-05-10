<?php

  class Estado {
    private PDO $pdo;

    // integrar conexión PDO en la clase (viene de backend/database/connection.php - frontend/index.php)
    public function __construct(PDO $pdo) {
      $this->pdo = $pdo;
    }

    public function obtenerEstados() {
      // preparar stmt (PDO)
       $stmt = $this->pdo->prepare(
        "SELECT id, clave
          FROM estados
          WHERE activo = TRUE"
      );

      // ejecutar consulta
      $stmt->execute();

      // obtener resultado
      $result = $stmt->fetchAll();

      // devolver resultado
      return $result;
    }
  }

?>