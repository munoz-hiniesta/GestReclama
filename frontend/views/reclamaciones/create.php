<?php

  /* formulario para crear borrador de reclamación */

?>

<div class="container-create-reclamacion">

  <?php require __DIR__ . '/../partials/mensaje.php'; ?>
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
      <label for="telefono">Teléfono (opcional):</label>
      <input type="text" id="telefono" name="telefono" placeholder="Ej. 600123456">
    </div>

    <div class="form-group">
      <label for="nombre_apellidos">Nombre y apellidos (opcional):</label>
      <input type="text" id="nombre_apellidos" name="nombre_apellidos" placeholder="Nombre Apellidos">
    </div>

    <div class="form-group">
      <label for="fecha_incidente">Fecha del incidente (opcional):</label>
      <input type="date" id="fecha_incidente" name="fecha_incidente" max="<?php echo date('Y-m-d'); ?>">
    </div>

    <div class="form-group">
      <label for="canal_entrada">Canal de entrada (opcional):</label>
      <select id="canal_entrada" name="canal_entrada">
        <option value="">-- Seleccionar canal --</option>
        <option value="presencial">Presencial</option>
        <option value="telefono">Teléfono</option>
        <option value="email">Email</option>
        <option value="web">Web</option>
        <option value="app">App</option>
      </select>
    </div>

    <div class="form-group">
      <label for="solicitud_cliente">Solicitud del cliente (opcional):</label>
      <select id="solicitud_cliente" name="solicitud_cliente">
        <option value="">-- Seleccionar solicitud --</option>
        <option value="devolucion">Devolución</option>
        <option value="reparacion">Reparación</option>
        <option value="compensacion">Compensación</option>
        <option value="informacion">Informacion</option>
        <option value="otra">Otra</option>
      </select>
    </div>

    <div class="form-group">
      <label for="dni">DNI (opcional):</label>
      <input type="text" id="dni" name="dni">
    </div>

    <div class="form-group">
      <label for="direccion">Dirección (opcional):</label>
      <input type="text" id="direccion" name="direccion">
    </div>

    <div class="form-group">
      <label for="codigo_postal">Código postal (opcional):</label>
      <input type="text" id="codigo_postal" name="codigo_postal">
    </div>

    <div class="form-group">
      <label for="ciudad">Ciudad (opcional):</label>
      <input type="text" id="ciudad" name="ciudad">
    </div>

    <div class="form-group">
      <label for="provincia">Provincia (opcional):</label>
      <input type="text" id="provincia" name="provincia">
    </div>

    <div class="form-group">
      <label for="observaciones_internas">Observaciones internas (opcional):</label>
      <textarea id="observaciones_internas" name="observaciones_internas"></textarea>
    </div>

    <div class="form-group">
      <label for="informacion_seguimiento">Información de seguimiento (opcional):</label>
      <textarea id="informacion_seguimiento" name="informacion_seguimiento"></textarea>
    </div>

    <div class="form-group">
      <label for="email">Email (opcional):</label>
      <input type="email" id="email" name="email" placeholder="ejemplo@dominio.com">
    </div>

    <div class="form-group">
      <label for="importe">Importe (opcional):</label>
      <input type="text" id="importe" name="importe" placeholder="0.00">
    </div>

    <div class="form-group">
      <label for="otros_datos">Otros datos complementarios (opcional):</label>
      <textarea id="otros_datos" name="otros_datos"></textarea>
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
