<?php if (!empty($respuesta['mensaje'])): ?>
  <div class="mensaje <?php echo $respuesta['success'] ? 'exito' : 'error'; ?>">
    <?php echo htmlspecialchars($respuesta['mensaje']); ?>
  </div>
<?php endif; ?>