<?php

  /* vista sencilla para listar reclamaciones reales desde la base de datos */

?>

<div class="container-index-reclamacion">

  <h1>Listado de reclamaciones</h1>

  <?php if (!empty($respuesta['reclamaciones'])): ?>
    <div class="table-wrapper">
      <table class="tabla-reclamaciones">
        <thead>
          <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Estado ID</th>
            <th>Fecha creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($respuesta['reclamaciones'] as $reclamacion): ?>
            <tr>
              <td><?php echo htmlspecialchars($reclamacion['id']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['descripcion']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['estado_id']); ?></td>
              <td><?php echo htmlspecialchars($reclamacion['fecha_creacion']); ?></td>
              <td>
                <a href="index.php?action=reclamaciones.show&id=<?php echo urlencode($reclamacion['id']); ?>" class="btn-secondary">Ver</a>
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

    <a href="panel.php" class="btn-secondary">Volver al panel</a>
  </div>

</div>
