<?php

// Cargar conexión
$pdo = require __DIR__ . '/../database/connection.php';

try {
    // Ejecutar consulta mínima
    $stmt = $pdo->query("SELECT 1");

    // Si llega aquí, todo funciona
    echo "Conexión OK";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}