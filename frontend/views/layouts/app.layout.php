<!DOCTYPE html>

<html lang="es">

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($css); ?>">

  </head>

  <body>

    <div class="app-shell">

      <header class="app-header">
        <a href="panel.php" class="app-logo">GestReclama</a>
        <div class="app-header-info">
          <span>Bienvenido/a: <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?></span>
          <span><?php echo htmlspecialchars($pageTitle); ?></span>
        </div>
      </header>

      <div class="app-content">

        <?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

        <main class="app-main">

          <?php
            if (file_exists($vista)) {
              require_once $vista;
            } else {
              require_once __DIR__ . $vista;
            }
          ?>

        </main>

      </div>

    </div>

  </body>

</html>
