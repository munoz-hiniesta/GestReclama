<?php

  class Estado {
    private PDO $pdo;

    // guardar conexión PDO
    public function __construct(PDO $pdo) {
      $this->pdo = $pdo;
    }

    public function obtenerEstados() {
      // preparar consulta
       $stmt = $this->pdo->prepare(
        "SELECT id, clave
          FROM estados
          WHERE activo = TRUE"
      );

      // ejecutar consulta
      $stmt->execute();

      // devolver resultado
      return $stmt->fetchAll();
    }
  }

?>