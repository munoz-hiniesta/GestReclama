<?php

  /* panel principal de navegación para usuarios autenticados */

  $nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';

?>

<div class="panel-container">

  <div class="panel-header">
    <h1>Panel principal</h1>
    <p class="panel-welcome">Bienvenido, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></p>
  </div>

  <div class="mensaje info">
    Desde este panel puedes acceder a las principales funciones de gestión de reclamaciones.
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

    <form method="GET" action="index.php" class="panel-form">
      <input type="hidden" name="action" value="reclamaciones.pendientes_asignacion">
      <button type="submit" class="btn-secondary">Pendientes de asignación</button>
    </form>

  </nav>

</div>
