<?php

  // cargar conexión
  $pdo = require DATABASE_PATH . '/connection.php';

  try {
    // ejecutar consulta sin prepare
    $stmt   = $pdo->query("SHOW TABLES");

    // recoger todos los resultados 
    $tables = $stmt->fetchAll();

    // mostrar resultados
    echo "Tablas encontradas: \n";

    foreach ($tables as $registro) {
      echo "- " . array_values($registro)[0] . "\n";
    }

    echo "\n OK: conexión y esquema de tablas correcto \n";
    
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

?>