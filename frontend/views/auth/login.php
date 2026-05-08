<div class="login-container">

  <div class="login-card">>

    <h2 class="login-title">GestReclama</h2>
    <p class="login-subtitle">Acceso al sistema</p>

    <!-- mensaje cargado del controller - index -->
    <?php if (isset($mensaje) && $mensaje !== '') : ?>
      <p class="login-message"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form class="login-form" name="form_login" method="POST" action="index.php">
      
      <div class="login-fields">

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

      <div class="login-actions">

        <button class="login-button" type="submit" name="action" value="login">Iniciar sesión</button>

      </div>

    </form>

  </div>

</div>
