<?php

  require_once MODELS_PATH . '/Estado.php';

  class EstadosReclamacion {

    // generar clave interna a partir del nombre del estado
    public static function generarClave(string $nombre): string {

      $nombre = iconv('UTF-8', 'ASCII//TRANSLIT', $nombre);
      $nombre = trim($nombre);
      $nombre = mb_strtoupper($nombre);
      $nombre = preg_replace('/[^A-Z0-9]+/', '_', $nombre);
      $nombre = preg_replace('/^_+|_+$/', '', $nombre);

      return $nombre;

    }

    // obtener referencias de estados
    public static function obtenerReferencias(PDO $pdo): array {

      // obtener estados activos desde modelo
      $estadoModel = new Estado($pdo);
      $listaEstados = $estadoModel->obtenerEstados();

      $estados = [];

      foreach ($listaEstados as $estado) {
        $estados[$estado['clave']] = $estado['id']; // $estados['BORRADOR'] = 1
      }

      return $estados;

    }
  }

?>
