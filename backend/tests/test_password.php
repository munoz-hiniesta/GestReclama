<?php

  $passwordPlano = '001';

  // Generar hash
  $hash = password_hash($passwordPlano, PASSWORD_DEFAULT);

  echo "Password plano: $passwordPlano\n";
  echo "Hash generado: $hash\n\n";

  // Verificar password
  if (password_verify($passwordPlano, $hash)) {
      echo "OK: password_verify funciona\n";
  } else {
      echo "ERROR: password_verify falla\n";
  }

?>