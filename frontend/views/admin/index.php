<?php

  /* gestión administrativa básica */

?>

<div class="admin-container">

  <h1>Gestión administrativa</h1>

  <?php if (!empty($respuesta['mensaje'])): ?>
    <div class="mensaje <?php echo $respuesta['success'] ? 'exito' : 'error'; ?>">
      <?php echo htmlspecialchars($respuesta['mensaje']); ?>
    </div>
  <?php endif; ?>

  <div class="admin-bloque">
    <h2>Usuarios</h2>

    <div class="table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Activo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (($usuarios ?? []) as $usuario): ?>
            <tr>
              <td><?php echo htmlspecialchars($usuario['id']); ?></td>
              <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
              <td><?php echo htmlspecialchars($usuario['email']); ?></td>
              <td><?php echo htmlspecialchars($usuario['rol_nombre'] ?? $usuario['rol_id']); ?></td>
              <td><?php echo intval($usuario['activo']) === 1 ? 'Sí' : 'No'; ?></td>
              <td>
                <a href="index.php?action=admin.index&usuario_id=<?php echo urlencode($usuario['id']); ?>" class="btn-secondary">Editar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <h3><?php echo !empty($usuarioEditar) ? 'Editar usuario' : 'Crear usuario'; ?></h3>

    <form method="POST" action="index.php" class="admin-form">
      <input type="hidden" name="action" value="admin.usuario.guardar">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuarioEditar['id'] ?? ''); ?>">

      <div class="form-group">
        <label for="usuario_nombre">Nombre</label>
        <input type="text" id="usuario_nombre" name="nombre" value="<?php echo htmlspecialchars($usuarioEditar['nombre'] ?? ''); ?>" required>
      </div>

      <div class="form-group">
        <label for="usuario_email">Email</label>
        <input type="email" id="usuario_email" name="email" value="<?php echo htmlspecialchars($usuarioEditar['email'] ?? ''); ?>" required>
      </div>

      <div class="form-group">
        <label for="usuario_rol_id">Rol</label>
        <select id="usuario_rol_id" name="rol_id" required>
          <option value="">-- Seleccionar rol --</option>
          <?php foreach (($roles ?? []) as $rol): ?>
            <option value="<?php echo htmlspecialchars($rol['id']); ?>" <?php echo intval($usuarioEditar['rol_id'] ?? 0) === intval($rol['id']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($rol['nombre']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="usuario_activo">Activo</label>
        <select id="usuario_activo" name="activo">
          <option value="1" <?php echo intval($usuarioEditar['activo'] ?? 1) === 1 ? 'selected' : ''; ?>>Sí</option>
          <option value="0" <?php echo isset($usuarioEditar['activo']) && intval($usuarioEditar['activo']) === 0 ? 'selected' : ''; ?>>No</option>
        </select>
      </div>

      <div class="form-group">
        <label for="usuario_password">Contraseña <?php echo !empty($usuarioEditar) ? '(solo si cambia)' : ''; ?></label>
        <input type="password" id="usuario_password" name="password" <?php echo empty($usuarioEditar) ? 'required' : ''; ?>>
      </div>

      <button type="submit" class="btn-primary">Guardar usuario</button>
      <?php if (!empty($usuarioEditar)): ?>
        <a href="index.php?action=admin.index" class="btn-secondary">Cancelar edición</a>
      <?php endif; ?>
    </form>
  </div>

  <div class="admin-bloque">
    <h2>Franquicias</h2>

    <div class="table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Clave</th>
            <th>Nombre</th>
            <th>Ubicación</th>
            <th>Activo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (($franquicias ?? []) as $franquicia): ?>
            <tr>
              <td><?php echo htmlspecialchars($franquicia['id']); ?></td>
              <td><?php echo htmlspecialchars($franquicia['clave']); ?></td>
              <td><?php echo htmlspecialchars($franquicia['nombre']); ?></td>
              <td><?php echo htmlspecialchars($franquicia['ubicacion']); ?></td>
              <td><?php echo intval($franquicia['activo']) === 1 ? 'Sí' : 'No'; ?></td>
              <td>
                <a href="index.php?action=admin.index&franquicia_id=<?php echo urlencode($franquicia['id']); ?>" class="btn-secondary">Editar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <h3><?php echo !empty($franquiciaEditar) ? 'Editar franquicia' : 'Crear franquicia'; ?></h3>

    <form method="POST" action="index.php" class="admin-form">
      <input type="hidden" name="action" value="admin.franquicia.guardar">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($franquiciaEditar['id'] ?? ''); ?>">

      <div class="form-group">
        <label for="franquicia_clave">Clave</label>
        <input type="text" id="franquicia_clave" name="clave" value="<?php echo htmlspecialchars($franquiciaEditar['clave'] ?? ''); ?>" required>
      </div>

      <div class="form-group">
        <label for="franquicia_nombre">Nombre</label>
        <input type="text" id="franquicia_nombre" name="nombre" value="<?php echo htmlspecialchars($franquiciaEditar['nombre'] ?? ''); ?>" required>
      </div>

      <div class="form-group">
        <label for="franquicia_ubicacion">Ubicación</label>
        <input type="text" id="franquicia_ubicacion" name="ubicacion" value="<?php echo htmlspecialchars($franquiciaEditar['ubicacion'] ?? ''); ?>" required>
      </div>

      <div class="form-group">
        <label for="franquicia_activo">Activo</label>
        <select id="franquicia_activo" name="activo">
          <option value="1" <?php echo intval($franquiciaEditar['activo'] ?? 1) === 1 ? 'selected' : ''; ?>>Sí</option>
          <option value="0" <?php echo isset($franquiciaEditar['activo']) && intval($franquiciaEditar['activo']) === 0 ? 'selected' : ''; ?>>No</option>
        </select>
      </div>

      <button type="submit" class="btn-primary">Guardar franquicia</button>
      <?php if (!empty($franquiciaEditar)): ?>
        <a href="index.php?action=admin.index" class="btn-secondary">Cancelar edición</a>
      <?php endif; ?>
    </form>
  </div>

</div>
