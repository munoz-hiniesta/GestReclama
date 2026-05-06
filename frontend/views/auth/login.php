<?php

  $pageTitle = "Login";

?>

<div>

  <h2>GestReclama</h2>
  <p>Acceso al sistema</p>

  <!-- mensaje cargado del controller - index -->
  <?php if (isset($mensaje) && $mensaje !== '') : ?>
    <p><?= htmlspecialchars($mensaje) ?></p>
  <?php endif; ?>

  <form name="form_login" method="POST" action="index.php">
    
    <div>

      <label for="email">Email: </label>
      <input
        type="email"
        name="email"
        id="email"
        value="<?= htmlspecialchars($email ?? '') ?>"
        placeholder="micorreo@gestreclama.es"
        required
      >

      <label for="password">Contraseña: </label>
      <input
        type="password"
        name="password"
        id="password"
        placeholder="********"
        required
      >

    </div>

    <div>

      <button type="submit">Iniciar sesión</button>

    </div>

  </form>

</div>
