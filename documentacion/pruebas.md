# PRUEBAS GESTRECLAMA

## Metodología de pruebas

Las pruebas del sistema GestReclama se han realizado de forma manual, validando progresivamente cada funcionalidad a medida que se desarrollaba.

Se han diferenciado dos tipos de pruebas:

- Pruebas técnicas: orientadas a verificar el correcto funcionamiento de la base del sistema.
- Pruebas funcionales: centradas en validar los casos de uso definidos.

---

## Pruebas técnicas

### Caso 1: Ejecución de schema.sql

- Entrada: ejecución del script SQL
- Precondiciones: base de datos creada
- Pasos:
  1. Ejecutar script SQL
- Resultado esperado: tablas creadas correctamente
- Resultado obtenido: tablas creadas correctamente
- Estado: OK

---

### Caso 2: Conexión a base de datos (PDO)

- Entrada: ejecución del archivo de conexión
- Precondiciones:
  - Base de datos creada
  - Credenciales correctas en `config/database.php`
- Pasos:
  1. Incluir `connection.php`
  2. Ejecutar una consulta simple (`SELECT 1`)
  3. Verificar que no se producen errores
- Resultado esperado: conexión establecida correctamente y consulta ejecutada sin errores
- Resultado obtenido: conexión realizada correctamente y consulta ejecutada
- Estado: OK
- Observaciones: la conexión PDO funciona correctamente y puede reutilizarse en el resto del sistema

---

## Pruebas funcionales

### CU02 – Login

#### Caso 1: Login correcto

- Entrada: email válido + contraseña correcta
- Precondiciones: usuario registrado
- Pasos:
  1. Acceder al login
  2. Introducir credenciales
  3. Pulsar "Iniciar sesión"
- Resultado esperado: redirección tras login correcto
- Resultado obtenido: redirección ejecutada correctamente
- Estado: OK

#### Caso 2: Contraseña incorrecta

- Entrada: email válido + contraseña incorrecta
- Pasos:
  1. Introducir credenciales
  2. Enviar formulario
- Resultado esperado: mensaje de error
- Resultado obtenido: mensaje mostrado correctamente
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

#### Caso 6: Acceso sin POST

- Entrada: acceso directo sin enviar formulario
- Pasos:
  1. Acceder a la ruta sin enviar formulario
- Resultado esperado: no se ejecuta el proceso de login
- Resultado obtenido: no ocurre ninguna acción
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
