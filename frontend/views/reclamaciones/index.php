<?php

  /* vista para listar reclamaciones */

?>

<div class="container-index-reclamacion">

  <h1>Listado de reclamaciones</h1>

  <form method="GET" action="index.php" class="filtros-reclamaciones">
    <input type="hidden" name="action" value="reclamaciones.index">

    <div class="filtro-group">
      <label for="filtro_id">ID reclamación</label>
      <input type="number" id="filtro_id" name="filtro_id" value="<?php echo htmlspecialchars($filtros['id'] ?? ''); ?>" min="1">
    </div>

    <div class="filtro-group">
      <label for="filtro_estado_id">Estado</label>
      <select id="filtro_estado_id" name="filtro_estado_id">
        <option value="">Todos</option>
        <?php foreach (($estados ?? []) as $estado): ?>
          <option value="<?php echo htmlspecialchars($estado['id']); ?>" <?php echo intval($filtros['estado_id'] ?? 0) === intval($estado['id']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($estado['nombre']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="filtro-acciones">
      <button type="submit" class="btn-secondary">Filtrar</button>
      <a href="index.php?action=reclamaciones.index" class="btn-secondary">Limpiar</a>
    </div>
  </form>

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
    <div class="mensaje info">No hay reclamaciones registradas para los filtros indicados.</div>
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
