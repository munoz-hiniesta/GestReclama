<!DOCTYPE html>

<html lang="es">

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($css); ?>">
  
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
