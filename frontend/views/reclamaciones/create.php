<?php

  /* formulario para crear borrador de reclamación */

?>

<div class="container-create-reclamacion">

  <?php if (isset($respuesta['mensaje'])): ?>
    <div class="mensaje <?php echo $respuesta['success'] ? 'exito' : 'error'; ?>">
      <?php echo htmlspecialchars($respuesta['mensaje']); ?>
    </div>
  <?php endif; ?>

  <h1>Crear nueva reclamación</h1>

  <form method="POST" action="index.php" enctype="multipart/form-data">
    
    <input type="hidden" name="action" value="reclamaciones.create">

    <div class="form-group">
      <label for="descripcion">Descripción:</label>
      <textarea id="descripcion" name="descripcion" required></textarea>
    </div>

    <div class="form-group">
      <label for="tipo_id">Tipo:</label>
      <select id="tipo_id" name="tipo_id" required>
        <option value="">-- Seleccionar tipo --</option>
        <option value="1">Tipo 1</option>
        <option value="2">Tipo 2</option>
      </select>
    </div>

    <div class="form-group">
      <label for="prioridad_id">Prioridad:</label>
      <select id="prioridad_id" name="prioridad_id" required>
        <option value="">-- Seleccionar prioridad --</option>
        <option value="1">Baja</option>
        <option value="2">Media</option>
        <option value="3">Alta</option>
      </select>
    </div>

    <div class="form-group">
      <label for="adjunto">Archivo adjunto:</label>
      <input type="file" id="adjunto" name="adjunto">
    </div>

    <button type="submit" class="btn-submit">Guardar borrador</button>

  </form>

  <div class="acciones-crear">
    <form method="GET" action="panel.php">
      <button type="submit" class="btn-secondary">Volver al panel</button>
    </form>
  </div>

</div>
