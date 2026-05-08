# Scripts de validación técnica

Scripts utilizados para validar funcionalidades y componentes de forma aislada durante el desarrollo.

Permiten comprobar partes concretas del sistema sin depender del flujo completo de la aplicación.

Estos scripts sirven como apoyo técnico durante el desarrollo y complementan las pruebas funcionales documentadas en `docs/tests`.

---

## Infraestructura

- `test_connection.php` → verifica conexión PDO con la base de datos
- `test_schema.php` → valida estructura y acceso a tablas

---

## Autenticación

- `test_login.php` → simulación técnica de login
- `test_logout.php` → validación técnica de cierre de sesión
- `test_password.php` → validación de hash y `password_verify`
- `test_session.php` → validación de sesión de usuario

---

## Reclamaciones

- `test_insert_reclamacion.php` → inserción básica de reclamación
- `test_estado.php` → validación de cambio de estado

---

## Relación con pruebas funcionales

Los scripts técnicos complementan las pruebas funcionales documentadas en `docs/tests`.

### CU02 – Login

Scripts relacionados:

- `test_login.php`
- `test_password.php`
- `test_session.php`

### CU07 – Logout

Scripts relacionados:

- `test_logout.php`
- `test_session.php`

---

## Notas

- Los scripts pueden ejecutarse de forma independiente.
- No forman parte del sistema de producción.
- No deben exponerse públicamente en entornos productivos.
- Su objetivo es facilitar validaciones rápidas durante el desarrollo.