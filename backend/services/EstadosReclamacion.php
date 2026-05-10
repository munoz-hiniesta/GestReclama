<?php

  class EstadosReclamacion {

    // generar clave interna (EN_TRAMITE) para nombre introducido por usuario (En trámite)
    public static function generarClave($nombre) {

      $nombre = iconv('UTF-8', 'ASCII//TRANSLIT', $nombre); // transliterar caracteres acentuados a ASCII
      $nombre = trim($nombre); // quitar espacios al principio y final de cadena
      $nombre = mb_strtoupper($nombre); // convertir todo a mayúsculas
      $nombre = preg_replace('/[^A-Z0-9]+/', '_', $nombre); // convertir todos los caracteres extraños y espacios internos en guión bajo
      $nombre = preg_replace('/^_+|_+$/', '', $nombre); // eliminar guiones bajos al comienzo y final de cadena

      return $nombre;

    }

    // centralizar acceso backend a estados mediante referencias semánticas
    public static function obtenerReferencias($pdo) {

      // obtener estados activos desde modelo
      $estadoModel = new Estado($pdo);
      $resultado = $estadoModel->obtenerEstados();

      $estados = [];

      foreach ($resultado as $estado) { // estado = estado individual obtenido del resultado (fila actual del resultado)
        $estados[$estado['clave']] = $estado['id']; // $estados['BORRADOR'] = 1
      }

      return $estados;

    }
  }

?>
