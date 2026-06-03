<?php

  /* vista para mostrar los datos completos de una reclamación */

?>

<div class="container-index-reclamacion">

  <?php if (!empty($error)): ?>
    <div class="mensaje error"><?php echo htmlspecialchars($error); ?></div>
  <?php else: ?>
    
    <?php if (!empty($respuesta) && is_array($respuesta) && array_key_exists('success', $respuesta)): ?>
      <?php 
        $clase = $respuesta['success'] ? 'exito' : 'error';
        $mensaje = $respuesta['mensaje'] ?? '';
      ?>
      <div class="mensaje <?php echo htmlspecialchars($clase); ?>"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>
    
    <h1>Reclamación #<?php echo htmlspecialchars($reclamacion['id']); ?></h1>

    <div class="detalle-reclamacion">
      <table class="tabla-reclamaciones">
        <tbody>
          <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($reclamacion['id']); ?></td>
          </tr>
          <tr>
            <th>Descripción</th>
            <td><?php echo nl2br(htmlspecialchars($reclamacion['descripcion'])); ?></td>
          </tr>
          <tr>
            <th>Tipo ID</th>
            <td><?php echo htmlspecialchars($reclamacion['tipo_id']); ?></td>
          </tr>
          <tr>
            <th>Prioridad ID</th>
            <td><?php echo htmlspecialchars($reclamacion['prioridad_id']); ?></td>
          </tr>
          <tr>
            <th>Estado ID</th>
            <td><?php echo htmlspecialchars($reclamacion['estado_id']); ?></td>
          </tr>
          <tr>
            <th>Franquicia ID</th>
            <td><?php echo htmlspecialchars($reclamacion['franquicia_id']); ?></td>
          </tr>
          <tr>
            <th>Teléfono</th>
            <td><?php echo htmlspecialchars($reclamacion['telefono'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Nombre y apellidos</th>
            <td><?php echo htmlspecialchars($reclamacion['nombre_apellidos'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Fecha incidente</th>
            <td><?php echo htmlspecialchars($reclamacion['fecha_incidente'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Canal entrada</th>
            <td><?php echo htmlspecialchars($reclamacion['canal_entrada'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Solicitud cliente</th>
            <td><?php echo htmlspecialchars($reclamacion['solicitud_cliente'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>DNI</th>
            <td><?php echo htmlspecialchars($reclamacion['dni'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Dirección</th>
            <td><?php echo nl2br(htmlspecialchars($reclamacion['direccion'] ?? '—')); ?></td>
          </tr>
          <tr>
            <th>Código postal</th>
            <td><?php echo htmlspecialchars($reclamacion['codigo_postal'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Ciudad</th>
            <td><?php echo htmlspecialchars($reclamacion['ciudad'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Provincia</th>
            <td><?php echo htmlspecialchars($reclamacion['provincia'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Observaciones internas</th>
            <td><?php echo nl2br(htmlspecialchars($reclamacion['observaciones_internas'] ?? '—')); ?></td>
          </tr>
          <tr>
            <th>Información seguimiento</th>
            <td><?php echo nl2br(htmlspecialchars($reclamacion['informacion_seguimiento'] ?? '—')); ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($reclamacion['email'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Importe</th>
            <td><?php echo htmlspecialchars($reclamacion['importe'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Otros datos</th>
            <td><?php echo nl2br(htmlspecialchars($reclamacion['otros_datos'] ?? '—')); ?></td>
          </tr>
          <tr>
            <th>Adjunto</th>
            <td><?php echo htmlspecialchars($reclamacion['adjunto'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Usuario creador ID</th>
            <td><?php echo htmlspecialchars($reclamacion['usuario_creador_id']); ?></td>
          </tr>
          <tr>
            <th>Fecha creación</th>
            <td><?php echo htmlspecialchars($reclamacion['fecha_creacion']); ?></td>
          </tr>
        </tbody>
      </table>
  
      <div class="acciones-index">
        <?php if ($reclamacion['estado_id'] == 1 && ($_SESSION['rol'] ?? 'trabajador') === 'encargado'): ?>
          <a href="index.php?action=reclamaciones.validar&id=<?php echo htmlspecialchars($reclamacion['id']); ?>" class="btn-primary">Validar reclamación</a>
        <?php endif; ?>
        <?php if ($reclamacion['estado_id'] == 1): ?>
          <a href="index.php?action=reclamaciones.edit&id=<?php echo htmlspecialchars($reclamacion['id']); ?>" class="btn-secondary">Editar</a>
        <?php endif; ?>
        <a href="index.php?action=reclamaciones.index" class="btn-secondary">Volver al listado</a>
        <a href="panel.php" class="btn-secondary">Volver al panel</a>
      </div>
    </div>
  <?php endif; ?>

</div>
