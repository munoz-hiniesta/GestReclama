<?php

  /* vista para listar reclamaciones */

?>

<div class="container-index-reclamacion">

  <h1>Listado de reclamaciones</h1>

  <?php if (!empty($reclamaciones)): ?>
    <div class="table-wrapper">
      <table class="tabla-reclamaciones">
        <thead>
          <tr>
              <th>ID</th>
              <th>Descripción</th>
              <th>Tipo</th>
              <th>Prioridad</th>
              <th>Estado</th>
              <th>Fecha de creación</th>
              <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach ($reclamaciones as $reclamacion): ?>
            <tr>
              <td><?php echo htmlspecialchars($reclamacion['id']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['descripcion']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['tipo_nombre'] ?? $reclamacion['tipo_id']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['prioridad_nombre'] ?? $reclamacion['prioridad_id']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['estado_nombre'] ?? $reclamacion['estado_id']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['fecha_creacion']); ?></td>
              <td>
                <a href="index.php?action=reclamaciones.show&id=<?php echo urlencode($reclamacion['id']); ?>" class="btn-secondary">Ver</a>
                <?php if (($reclamacion['estado_clave'] ?? '') === 'BORRADOR'): ?>
                  <a href="index.php?action=reclamaciones.edit&id=<?php echo urlencode($reclamacion['id']); ?>" class="btn-secondary">Editar</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="mensaje info">No hay reclamaciones registradas.</div>
  <?php endif; ?>

  <div class="acciones-index">
    <form method="GET" action="index.php">
      <input type="hidden" name="action" value="reclamaciones.create.view">
      <button type="submit" class="btn-secondary">Crear reclamación</button>
    </form>

    <form method="GET" action="index.php">
      <input type="hidden" name="action" value="reclamaciones.pendientes_asignacion">
      <button type="submit" class="btn-secondary">Reclamaciones pendientes de asignación</button>
    </form>

    <a href="panel.php" class="btn-secondary">Volver al panel</a>
  </div>

</div>
