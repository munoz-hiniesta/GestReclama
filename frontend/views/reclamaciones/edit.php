<?php

  /* vista para editar un borrador de reclamación */

?>

<div class="container-create-reclamacion">

  <?php if (!empty($respuesta['mensaje'])): ?>
    <div class="mensaje <?php echo $respuesta['success'] ? 'exito' : 'error'; ?>">
      <?php echo htmlspecialchars($respuesta['mensaje']); ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($error)): ?>
    <div class="mensaje error"><?php echo htmlspecialchars($error); ?></div>
  <?php elseif (!empty($reclamacion)): ?>

    <h1>Editar reclamación #<?php echo htmlspecialchars($reclamacion['id']); ?></h1>

    <form method="POST" action="index.php">
      <input type="hidden" name="action" value="reclamaciones.edit">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($reclamacion['id']); ?>">

      <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($reclamacion['descripcion']); ?></textarea>
      </div>

      <div class="form-group">
        <label for="tipo_id">Tipo:</label>
        <select id="tipo_id" name="tipo_id" required>
          <option value="">-- Seleccionar tipo --</option>
          <option value="1" <?php echo $reclamacion['tipo_id'] == 1 ? 'selected' : ''; ?>>Tipo 1</option>
          <option value="2" <?php echo $reclamacion['tipo_id'] == 2 ? 'selected' : ''; ?>>Tipo 2</option>
        </select>
      </div>

      <div class="form-group">
        <label for="prioridad_id">Prioridad:</label>
        <select id="prioridad_id" name="prioridad_id" required>
          <option value="">-- Seleccionar prioridad --</option>
          <option value="1" <?php echo $reclamacion['prioridad_id'] == 1 ? 'selected' : ''; ?>>Baja</option>
          <option value="2" <?php echo $reclamacion['prioridad_id'] == 2 ? 'selected' : ''; ?>>Media</option>
          <option value="3" <?php echo $reclamacion['prioridad_id'] == 3 ? 'selected' : ''; ?>>Alta</option>
        </select>
      </div>

      <div class="form-group">
        <label for="telefono">Teléfono (opcional):</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($reclamacion['telefono'] ?? ''); ?>" placeholder="Ej. 600123456">
      </div>

      <div class="form-group">
        <label for="email">Email (opcional):</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($reclamacion['email'] ?? ''); ?>" placeholder="ejemplo@dominio.com">
      </div>

      <div class="form-group">
        <label for="importe">Importe (opcional):</label>
        <input type="text" id="importe" name="importe" value="<?php echo htmlspecialchars($reclamacion['importe'] ?? ''); ?>" placeholder="0.00">
      </div>

      <div class="form-group">
        <label for="otros_datos">Otros datos complementarios (opcional):</label>
        <textarea id="otros_datos" name="otros_datos"><?php echo htmlspecialchars($reclamacion['otros_datos'] ?? ''); ?></textarea>
      </div>

      <button type="submit" class="btn-submit">Actualizar borrador</button>
    </form>

    <div class="acciones-crear">
      <a href="index.php?action=reclamaciones.index" class="btn-secondary">Volver al listado</a>
    </div>

  <?php endif; ?>

</div>
