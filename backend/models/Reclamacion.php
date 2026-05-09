<?php

  class Reclamacion {
    private PDO $pdo;

    // integrar conexión PDO en la clase
    public function __construct(PDO $pdo) {
      $this->pdo = $pdo;
    }

    public function obtenerReclamaciones() {
      // preparar stmt (PDO)
       $stmt = $this->pdo->prepare(
        "SELECT *
          FROM reclamaciones"
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