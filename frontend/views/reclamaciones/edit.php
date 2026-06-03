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
        <label for="nombre_apellidos">Nombre y apellidos (opcional):</label>
        <input type="text" id="nombre_apellidos" name="nombre_apellidos" value="<?php echo htmlspecialchars($reclamacion['nombre_apellidos'] ?? ''); ?>">
      </div>

      <div class="form-group">
        <label for="fecha_incidente">Fecha del incidente (opcional):</label>
        <input type="date" id="fecha_incidente" name="fecha_incidente" value="<?php echo htmlspecialchars($reclamacion['fecha_incidente'] ?? ''); ?>" max="<?php echo date('Y-m-d'); ?>">
      </div>

      <div class="form-group">
        <label for="canal_entrada">Canal de entrada (opcional):</label>
        <select id="canal_entrada" name="canal_entrada">
          <option value="">-- Seleccionar canal --</option>
          <option value="presencial" <?php echo ($reclamacion['canal_entrada'] ?? '') == 'presencial' ? 'selected' : ''; ?>>Presencial</option>
          <option value="telefono" <?php echo ($reclamacion['canal_entrada'] ?? '') == 'telefono' ? 'selected' : ''; ?>>Teléfono</option>
          <option value="email" <?php echo ($reclamacion['canal_entrada'] ?? '') == 'email' ? 'selected' : ''; ?>>Email</option>
          <option value="web" <?php echo ($reclamacion['canal_entrada'] ?? '') == 'web' ? 'selected' : ''; ?>>Web</option>
          <option value="app" <?php echo ($reclamacion['canal_entrada'] ?? '') == 'app' ? 'selected' : ''; ?>>App</option>
        </select>
      </div>

      <div class="form-group">
        <label for="solicitud_cliente">Solicitud del cliente (opcional):</label>
        <select id="solicitud_cliente" name="solicitud_cliente">
          <option value="">-- Seleccionar solicitud --</option>
          <option value="devolucion" <?php echo ($reclamacion['solicitud_cliente'] ?? '') == 'devolucion' ? 'selected' : ''; ?>>Devolución</option>
          <option value="reparacion" <?php echo ($reclamacion['solicitud_cliente'] ?? '') == 'reparacion' ? 'selected' : ''; ?>>Reparación</option>
          <option value="compensacion" <?php echo ($reclamacion['solicitud_cliente'] ?? '') == 'compensacion' ? 'selected' : ''; ?>>Compensación</option>
          <option value="informacion" <?php echo ($reclamacion['solicitud_cliente'] ?? '') == 'informacion' ? 'selected' : ''; ?>>Informacion</option>
          <option value="otra" <?php echo ($reclamacion['solicitud_cliente'] ?? '') == 'otra' ? 'selected' : ''; ?>>Otra</option>
        </select>
      </div>

      <div class="form-group">
        <label for="dni">DNI (opcional):</label>
        <input type="text" id="dni" name="dni" value="<?php echo htmlspecialchars($reclamacion['dni'] ?? ''); ?>">
      </div>

      <div class="form-group">
        <label for="direccion">Dirección (opcional):</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($reclamacion['direccion'] ?? ''); ?>">
      </div>

      <div class="form-group">
        <label for="codigo_postal">Código postal (opcional):</label>
        <input type="text" id="codigo_postal" name="codigo_postal" value="<?php echo htmlspecialchars($reclamacion['codigo_postal'] ?? ''); ?>">
      </div>

      <div class="form-group">
        <label for="ciudad">Ciudad (opcional):</label>
        <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($reclamacion['ciudad'] ?? ''); ?>">
      </div>

      <div class="form-group">
        <label for="provincia">Provincia (opcional):</label>
        <input type="text" id="provincia" name="provincia" value="<?php echo htmlspecialchars($reclamacion['provincia'] ?? ''); ?>">
      </div>

      <div class="form-group">
        <label for="observaciones_internas">Observaciones internas (opcional):</label>
        <textarea id="observaciones_internas" name="observaciones_internas"><?php echo htmlspecialchars($reclamacion['observaciones_internas'] ?? ''); ?></textarea>
      </div>

      <div class="form-group">
        <label for="informacion_seguimiento">Información de seguimiento (opcional):</label>
        <textarea id="informacion_seguimiento" name="informacion_seguimiento"><?php echo htmlspecialchars($reclamacion['informacion_seguimiento'] ?? ''); ?></textarea>
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
      <?php if (($reclamacion['estado_id'] ?? '') == 1): ?>
        <a href="index.php?action=reclamaciones.validar&id=<?php echo htmlspecialchars($reclamacion['id']); ?>" class="btn-primary">Validar reclamación</a>
      <?php endif; ?>
      <a href="index.php?action=reclamaciones.index" class="btn-secondary">Volver al listado</a>
    </div>

  <?php endif; ?>

</div>
