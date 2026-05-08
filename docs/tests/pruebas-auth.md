# Pruebas autenticación

## CU02 – Login

### Caso 1: Login correcto

- Entrada: email válido + contraseña correcta
- Precondiciones: usuario registrado
- Pasos:
  1. Acceder al login
  2. Introducir credenciales
  3. Pulsar "Iniciar sesión"
- Resultado esperado:
  - redirección tras login correcto
- Resultado obtenido:
  - redirección ejecutada correctamente
- Estado: OK

### Caso 2: Contraseña incorrecta

- Entrada: email válido + contraseña incorrecta
- Pasos:
  1. Introducir credenciales
  2. Enviar formulario
- Resultado esperado:
  - mensaje de error
- Resultado obtenido:
  - mensaje mostrado correctamente
- Estado: OK

#### Caso 3: Usuario no existente

- Entrada: email no registrado + cualquier contraseña
- Pasos:
  1. Introducir credenciales
  2. Enviar formulario
- Resultado esperado: mensaje "usuario no existe"
- Resultado obtenido: mensaje mostrado correctamente
- Estado: OK

#### Caso 4: Campos vacíos

- Entrada: email vacío y/o contraseña vacía
- Pasos:
  1. Dejar campos vacíos
  2. Enviar formulario
- Resultado esperado: mensaje "Todos los campos son obligatorios"
- Resultado obtenido: mensaje mostrado correctamente
- Estado: OK

#### Caso 5: Sesión creada correctamente

- Entrada: credenciales válidas
- Precondiciones: usuario registrado
- Pasos:
  1. Iniciar sesión
- Resultado esperado: variables de sesión creadas correctamente
- Resultado obtenido: sesión iniciada y redirección ejecutada
- Estado: OK

#### Caso 6: Carga inicial del login mediante GET

- Entrada: acceso inicial a la aplicación
- Pasos:
  1. Acceder a `http://gestreclama.local`
- Resultado esperado: carga correcta del formulario de login
- Resultado obtenido: login cargado correctamente desde `index.php`
- Estado: OK

#### Caso 7: Persistencia de email tras error

- Entrada: email válido + contraseña incorrecta
- Pasos:
  1. Introducir email válido
  2. Introducir contraseña incorrecta
  3. Enviar formulario
- Resultado esperado: el email permanece en el formulario
- Resultado obtenido: email persistido correctamente
- Estado: OK

#### Caso 8: Acción inválida

- Entrada: petición POST con acción no permitida
- Pasos:
  1. Enviar formulario con una acción distinta de `login`
- Resultado esperado: mensaje "Acción no permitida"
- Resultado obtenido: mensaje mostrado correctamente
- Estado: OK

---

## CU07 – Logout

### Caso 1: Logout correcto

- Entrada: usuario autenticado
- Precondiciones:
  - sesión iniciada correctamente
- Pasos:
  1. Acceder al panel autenticado
  2. Pulsar "Cerrar sesión"
- Resultado esperado:
  - sesión destruida correctamente
  - redirección a login
- Resultado obtenido:
  - logout ejecutado correctamente
  - redirección realizada
- Estado: OK

### Caso 2: Variables de sesión eliminadas

- Entrada: logout ejecutado
- Precondiciones:
  - usuario autenticado previamente
- Pasos:
  1. Iniciar sesión
  2. Ejecutar logout
  3. Intentar acceder a variables de sesión
- Resultado esperado:
  - variables de sesión inexistentes
- Resultado obtenido:
  - sesión eliminada correctamente
- Estado: OK

### Caso 3: Acceso bloqueado tras logout

- Entrada: acceso manual a `panel.php` tras cerrar sesión
- Precondiciones:
  - logout ejecutado previamente
- Pasos:
  1. Cerrar sesión
  2. Intentar acceder manualmente a `panel.php`
- Resultado esperado:
  - redirección automática a login
- Resultado obtenido:
  - acceso bloqueado correctamente
- Estado: OK

### Caso 4: Acción logout procesada desde index.php

- Entrada: envío POST con `action=logout`
- Precondiciones:
  - sesión iniciada
- Pasos:
  1. Pulsar botón logout
- Resultado esperado:
  - `index.php` detecta acción logout
  - `AuthController::logout()` ejecutado
- Resultado obtenido:
  - acción procesada correctamente
- Estado: OK

### Caso 5: Logout mediante nueva petición GET

- Entrada: cierre de sesión correcto
- Precondiciones:
  - usuario autenticado
- Pasos:
  1. Ejecutar logout
- Resultado esperado:
  - nueva petición GET a `index.php`
  - login renderizado correctamente
- Resultado obtenido:
  - redirect ejecutado correctamente
- Estado: OK

---

## Middleware autenticado

### Caso 1: Acceso permitido con sesión válida

- Entrada: acceso a `panel.php`
- Precondiciones:
  - sesión autenticada activa
- Pasos:
  1. Iniciar sesión correctamente
  2. Acceder a `panel.php`
- Resultado esperado:
  - acceso permitido
  - panel renderizado correctamente
- Resultado obtenido:
  - acceso permitido correctamente
- Estado: OK

### Caso 2: Acceso bloqueado sin sesión

- Entrada: acceso manual a `panel.php`
- Precondiciones:
  - sesión inexistente
- Pasos:
  1. Acceder directamente a `panel.php`
- Resultado esperado:
  - redirección automática a login
- Resultado obtenido:
  - acceso bloqueado correctamente
- Estado: OK

### Caso 3: Middleware reutilizable en rutas protegidas

- Entrada: inclusión de `backend/middleware/auth.php`
- Pasos:
  1. Incluir middleware desde ruta protegida
  2. Verificar validación automática
- Resultado esperado:
  - protección ejecutada correctamente
- Resultado obtenido:
  - middleware funcionando correctamente
- Estado: OK
