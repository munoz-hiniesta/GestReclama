# Tests manuales

Scripts utilizados para validar funcionalidades de forma aislada durante el desarrollo.

Permiten comprobar componentes individuales sin pasar por el flujo completo de la aplicación.

---

## Técnicos

- test_connection.php → verifica conexión PDO
- test_schema.php → valida estructura de tablas

---

## Autenticación

- test_login.php → prueba login (usuario existente / no existente)
- test_password.php → validación de contraseña (correcta / incorrecta)

---

## Reclamaciones

- test_insert_reclamacion.php → inserción básica
- test_estado.php → cambio de estado

---

## Relación con pruebas funcionales

Los scripts técnicos sirven como soporte para validar los casos definidos en `pruebas.md`.

- CU02 – Login:
  - test_login.php
  - test_password.php

---

## Notas

Estos scripts son independientes y pueden ejecutarse de forma aislada.

No forman parte del sistema en producción.