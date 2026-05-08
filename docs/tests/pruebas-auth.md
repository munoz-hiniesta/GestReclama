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