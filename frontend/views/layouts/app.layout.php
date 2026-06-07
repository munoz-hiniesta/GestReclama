<!DOCTYPE html>

<html lang="es">

  <head>

    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="<?= $css ?>">

  </head>

  <body>

    <div class="app-shell">

      <header class="app-header">
        GestReclama
      </header>

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

  </body>

</html>