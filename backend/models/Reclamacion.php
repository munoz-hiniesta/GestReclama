<?php

  class Reclamacion {
    private PDO $pdo;

    // guardar conexión PDO
    public function __construct(PDO $pdo) {
      $this->pdo = $pdo;
    }

    public function obtenerReclamaciones() {
      // preparar consulta
       $stmt = $this->pdo->prepare(
        "SELECT *
          FROM reclamaciones"
      );

      // ejecutar consulta
      $stmt->execute();

      // devolver resultado
      return $stmt->fetchAll();
    }
  }

?>