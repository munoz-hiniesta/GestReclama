<!DOCTYPE html>

<html lang="es">

  <head>

    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="<?= $css ?>">
  </head>

  <body>

    <?php 
      if (file_exists($vista)) {
        require_once $vista;
      } else {
        require_once __DIR__ . $vista;
      }
    ?>

  </body>

</html>
