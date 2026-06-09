<?php

  /* vista para mostrar el formulario de asignación de responsable */

?>

<div class="container-create-reclamacion">

  <h1>Asignar responsable de tramitación</h1>

  <?php if (!empty($error)): ?>
    <div class="mensaje error"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <?php if (!empty($respuesta['mensaje'])): ?>
    <div class="mensaje <?php echo $respuesta['success'] ? 'exito' : 'error'; ?>">
      <?php echo htmlspecialchars($respuesta['mensaje']); ?>
    </div>
  <?php endif; ?>

  <?php if ($reclamacion): ?>
    <div class="detalle-reclamacion">
      <p><strong>ID:</strong> <?php echo htmlspecialchars($reclamacion['id']); ?></p>
      <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($reclamacion['descripcion'] ?? '')); ?></p>
      <p><strong>Tipo:</strong> <?php echo htmlspecialchars($reclamacion['tipo_nombre'] ?? $reclamacion['tipo_id'] ?? ''); ?></p>
      <p><strong>Prioridad:</strong> <?php echo htmlspecialchars($reclamacion['prioridad_nombre'] ?? $reclamacion['prioridad_id'] ?? ''); ?></p>
      <p><strong>Fecha del incidente:</strong> <?php echo htmlspecialchars($reclamacion['fecha_incidente'] ?? ''); ?></p>
      <p><strong>Canal de entrada:</strong> <?php echo htmlspecialchars($reclamacion['canal_entrada'] ?? ''); ?></p>
      <p><strong>Solicitud del cliente:</strong> <?php echo htmlspecialchars($reclamacion['solicitud_cliente'] ?? ''); ?></p>
      <p><strong>Nombre y apellidos:</strong> <?php echo htmlspecialchars($reclamacion['nombre_apellidos'] ?? ''); ?></p>
      <p><strong>Estado:</strong> <?php echo htmlspecialchars($reclamacion['estado_nombre'] ?? $reclamacion['estado_clave'] ?? ''); ?></p>
      <p><strong>Observaciones internas:</strong></p>
      <div class="observaciones-internas"><?php echo nl2br(htmlspecialchars($reclamacion['observaciones_internas'] ?? '')); ?></div>
      <p><strong>Fecha de creación:</strong> <?php echo htmlspecialchars($reclamacion['fecha_creacion']); ?></p>
    </div>

    <?php if (($reclamacion['estado_clave'] ?? '') === 'PENDIENTE' && empty($reclamacion['usuario_responsable_id'])): ?>
      <form method="POST" action="index.php?action=reclamaciones.asignar&id=<?php echo urlencode($reclamacion['id']); ?>">
        <div class="form-group">
          <label for="usuario_responsable_id">Responsable de tramitación</label>
          <select name="usuario_responsable_id" id="usuario_responsable_id">
            <option value="">-- Seleccionar responsable --</option>
            <?php foreach ($responsables as $responsable): ?>
              <option value="<?php echo htmlspecialchars($responsable['id']); ?>"><?php echo htmlspecialchars($responsable['nombre']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <button type="submit" class="btn-secondary">Confirmar asignación</button>
      </form>
    <?php else: ?>
      <?php if (!empty($reclamacion['usuario_responsable_id'])): ?>
        <div class="mensaje info">La reclamación ya tiene un responsable asignado: <?php echo htmlspecialchars($reclamacion['responsable_nombre'] ?? ''); ?>.</div>
        <?php elseif (($reclamacion['estado_clave'] ?? '') !== 'PENDIENTE'): ?>
          <div class="mensaje info">La reclamación no está pendiente de asignación.</div>
      <?php endif; ?>
    <?php endif; ?>
  <?php endif; ?>

  <?php $acciones = $acciones_reclamacion ?? []; ?>

  <?php if (!empty($acciones)): ?>
    <div class="historial-seguimiento">

      <h2>Histórico de acciones</h2>

      <table class="tabla-acciones">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Estado</th>
            <th>Comentario</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($acciones as $accion): ?>
            <tr>
              <td><?php echo htmlspecialchars($accion['fecha'] ?? ''); ?></td>
              <td><?php echo htmlspecialchars($accion['usuario_nombre'] ?? ($accion['usuario_id'] ?? '—')); ?></td>
              <td><?php echo htmlspecialchars($accion['estado_nombre'] ?? ($accion['estado_id'] ?? '—')); ?></td>
              <td><?php echo nl2br(htmlspecialchars($accion['comentario'] ?? '')); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>

    </div>
  <?php endif; ?>

  <div class="acciones-index">
    <a href="index.php?action=reclamaciones.pendientes_asignacion" class="btn-secondary">Volver a pendientes</a>
  </div>

</div>
