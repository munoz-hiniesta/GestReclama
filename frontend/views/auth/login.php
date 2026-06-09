<div class="login-container">

  <div class="login-card">

    <div class="login-header">  
      <h2 class="login-title">GestReclama</h2>
      <p class="login-subtitle">Acceso al sistema</p>
    </div>

    <div class="login-message">
      <!-- mensaje cargado del controller - index -->
      <?php if (isset($mensaje) && $mensaje !== '') : ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
      <?php endif; ?>
    </div>  

    <form class="login-form" name="form_login" method="POST" action="index.php">
      
      <div class="login-fields">

        <label for="email">Email: </label>
        <input
          type="email"
          name="email"
          id="email"
          value="<?php echo htmlspecialchars($email ?? ''); ?>"
          placeholder="usuario@correo.com"
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
