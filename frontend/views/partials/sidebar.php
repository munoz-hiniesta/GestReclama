<nav class="app-sidebar">

  <ul class="sidebar-menu">

    <li>
      <a href="panel.php">Panel principal</a>
    </li>

    <li>
      <a href="index.php?action=reclamaciones.create.view">
        Crear reclamación
      </a>
    </li>

    <li>
      <a href="index.php?action=reclamaciones.index">
        Consulta reclamaciones
      </a>
    </li>

    <li>
      <a href="index.php?action=reclamaciones.pendientes_asignacion">
        Pendientes de asignación
      </a>
    </li>

    <?php if (intval($_SESSION['rol_id'] ?? 0) === 1): ?>
      <li>
        <a href="index.php?action=admin.index">
          Gestión administrativa
        </a>
      </li>
    <?php endif; ?>

    <li>
      <form method="POST" action="index.php">
        <button type="submit" name="action" value="logout">
          Cerrar sesión
        </button>
      </form>
    </li>

  </ul>

</nav>
