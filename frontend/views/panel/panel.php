<div class="panel-container">

  <div class="panel-header">
    <h1>Panel de control</h1>
    <p class="panel-welcome">Bienvenido, <strong><?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?></strong></p>
  </div>

  <nav class="panel-nav">
    <form method="GET" action="index.php" class="panel-form">
      <input type="hidden" name="action" value="reclamaciones.index">
      <button type="submit" class="btn-secondary">Ver reclamaciones</button>
    </form>

    <form method="GET" action="index.php" class="panel-form">
      <input type="hidden" name="action" value="reclamaciones.create.view">
      <button type="submit" class="btn-primary">Crear reclamación</button>
    </form>
  </nav>

  <div class="panel-logout">
    <form method="POST" action="index.php">
      <button type="submit" name="action" value="logout" class="btn-logout">Cerrar sesión</button>
    </form>
  </div>

</div>