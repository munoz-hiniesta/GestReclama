<?php

  /* vista para mostrar los datos completos de una reclamación */

?>

<div class="container-index-reclamacion">

  <?php if (!empty($error)): ?>
    <div class="mensaje error"><?php echo htmlspecialchars($error); ?></div>
  <?php else: ?>
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
        <a href="index.php?action=reclamaciones.index" class="btn-secondary">Volver al listado</a>
        <a href="panel.php" class="btn-secondary">Volver al panel</a>
      </div>
    </div>
  <?php endif; ?>

</div>
