<?php

  // mostrar datos completos de una reclamación

?>

<div class="container-index-reclamacion">

  <?php if (!empty($error)): ?>
    <div class="mensaje error"><?php echo htmlspecialchars($error); ?></div>
  <?php else: ?>
    
    <h1>Reclamación #<?php echo htmlspecialchars($reclamacion['id']); ?></h1>

    <div class="detalle-reclamacion bloque-seguimiento">
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
            <th>Tipo</th>
            <td><?php echo htmlspecialchars($reclamacion['tipo_nombre'] ?? $reclamacion['tipo_id']); ?></td>
          </tr>
          <tr>
            <th>Prioridad</th>
            <td><?php echo htmlspecialchars($reclamacion['prioridad_nombre'] ?? $reclamacion['prioridad_id']); ?></td>
          </tr>
          <tr>
            <th>Estado</th>
            <td><?php echo htmlspecialchars($reclamacion['estado_nombre'] ?? $reclamacion['estado_id']); ?></td>
          </tr>
          <tr>
            <th>Franquicia</th>
            <td><?php echo htmlspecialchars($reclamacion['franquicia_nombre'] ?? $reclamacion['franquicia_id'] ?? '—'); ?></td>
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
            <th>Usuario creador</th>
            <td><?php echo htmlspecialchars($reclamacion['usuario_creador_nombre'] ?? $reclamacion['usuario_creador_id'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Responsable</th>
            <td><?php echo htmlspecialchars($reclamacion['responsable_nombre'] ?? '—'); ?></td>
          </tr>
          <tr>
            <th>Fecha creación</th>
            <td><?php echo htmlspecialchars($reclamacion['fecha_creacion']); ?></td>
          </tr>
        </tbody>
      </table>
  
      <div class="acciones-index">
        <?php if (($reclamacion['estado_clave'] ?? '') === 'BORRADOR' && ($_SESSION['rol'] ?? 'trabajador') === 'encargado'): ?>
          <a href="index.php?action=reclamaciones.validar&id=<?php echo htmlspecialchars($reclamacion['id']); ?>" class="btn-primary">Validar reclamación</a>
        <?php endif; ?>
        <?php if (($reclamacion['estado_clave'] ?? '') === 'BORRADOR'): ?>
          <a href="index.php?action=reclamaciones.edit&id=<?php echo htmlspecialchars($reclamacion['id']); ?>" class="btn-secondary">Editar</a>
        <?php endif; ?>
        <a href="index.php?action=reclamaciones.index" class="btn-secondary">Volver al listado</a>
        <a href="panel.php" class="btn-secondary">Volver al panel</a>
      </div>
    </div>
    
    <div class="historial-seguimiento bloque-seguimiento">
      <h2>Histórico de acciones</h2>
      <?php $acciones = $acciones_reclamacion ?? []; ?>
      <?php if (empty($acciones)): ?>
        <p>No hay acciones registradas para esta reclamación.</p>
      <?php else: ?>
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
      <?php endif; ?>
      </div>

      <div class="registrar-accion bloque-seguimiento">
        <h3>Registrar nueva acción</h3>
        <?php if (!empty($respuesta) && is_array($respuesta) && array_key_exists('success', $respuesta)): ?>
          <div class="mensaje <?php echo $respuesta['success'] ? 'exito' : 'error'; ?>"><?php echo htmlspecialchars($respuesta['mensaje'] ?? ''); ?></div>
        <?php endif; ?>
        <?php if (($reclamacion['estado_clave'] ?? '') !== 'RESUELTA'): ?>
          <form method="POST" action="index.php" class="form-seguimiento">
            <input type="hidden" name="action" value="reclamaciones.show">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($reclamacion['id']); ?>">
            
            <div class="form-group">
              <label for="estado_id">Estado de resolución:</label>
              <select id="estado_id" name="estado_id" required>
                <?php foreach ($estado_opciones as $estado): ?>
                  <option value="<?php echo htmlspecialchars($estado['id']); ?>" <?php echo intval($estado['id']) === intval($reclamacion['estado_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($estado['nombre']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            
            <div class="form-group">
              <label for="nuevo_comentario">Comentario:</label>
              <textarea id="nuevo_comentario" name="nuevo_comentario" required></textarea>
            </div>
            
            <button type="submit" class="btn-primary">Guardar acción</button>
          </form>
        <?php else: ?>
          <p class="nota">Esta reclamación está resuelta. No se pueden registrar nuevas acciones.</p>
        <?php endif; ?>
      </div>
  <?php endif; ?>

</div>
