<?php

  /* vista para listar reclamaciones pendientes de asignación */

?>

<div class="container-index-reclamacion">

  <h1>Reclamaciones pendientes de asignación</h1>

  <?php if (!empty($reclamaciones)): ?>
    <div class="table-wrapper">
      <table class="tabla-reclamaciones">
        <thead>
          <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Fecha de creación</th>
            <th>Tipo</th>
            <th>Prioridad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($reclamaciones as $reclamacion): ?>
            <tr>
              <td><?php echo htmlspecialchars($reclamacion['id']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['descripcion']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['fecha_creacion']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['tipo_nombre']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['prioridad_nombre']); ?></td>
              <td>
                <a href="index.php?action=reclamaciones.asignar&id=<?php echo urlencode($reclamacion['id']); ?>" class="btn-secondary">Asignar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="mensaje info">No hay reclamaciones pendientes de asignación.</div>
  <?php endif; ?>

  <div class="acciones-index">
    <a href="index.php?action=reclamaciones.index" class="btn-secondary">Volver al listado</a>
  </div>

</div>
