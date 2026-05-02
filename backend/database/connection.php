<?php

  // Cargar configuración de base de datos
  $config = require __DIR__ . '/../config/database.php';

  // Construir DSN para conexión PDO
  $dsn = "mysql:host = {$config['host']};
          dbname     = {$config['dbname']};
          charset    = {$config['charset']};"
  ;

  try {
    // Crear conexión PDO con opciones
    $pdo = new PDO(
      $dsn,
      $config['user'],
      $config['password'],
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
      ]
    );

  } catch (PDOException $e) {
    // Detener ejecución si falla la conexión
    die('Error de conexión: ' . $e->getMessage());
  }

  // Devolver conexión para reutilizar en el proyecto
  return $pdo;

?>