# PRUEBAS GESTRECLAMA

## Metodología de pruebas

  Las pruebas del sistema GestReclama se han realizado de forma manual, validando progresivamente cada funcionalidad a medida que se desarrollaba.

  Se han diferenciado dos tipos de pruebas:

    - Pruebas técnicas: orientadas a verificar el correcto funcionamiento de la base del sistema.
    - Pruebas funcionales: centradas en validar los casos de uso definidos.

---

## Pruebas técnicas

### Caso 1: Ejecución de schema.sql

- Entrada: ejecución del script
- Precondiciones: base de datos creada
- Pasos:
  1. Ejecutar script SQL
- Resultado esperado: tablas creadas correctamente
- Resultado obtenido: OK
- Estado: OK

### Caso 2: Conexión a base de datos (PDO)

- Entrada: ejecución del archivo de conexión  

- Precondiciones:  
  - Base de datos creada  
  - Credenciales correctas en config/database.php  
- Pasos:
  1. Incluir el archivo connection.php  
  2. Ejecutar una consulta simple (SELECT 1)  
  3. Verificar que no se producen errores  
- Resultado esperado:  
  conexión establecida correctamente y consulta ejecutada sin errores  
- Resultado obtenido:  
  conexión realizada correctamente y consulta ejecutada  
- Estado: OK  
- Observaciones:  
  la conexión PDO funciona correctamente y puede reutilizarse en el resto del sistema  

---

## CU02 – Login

### Caso 1: Login correcto

- Entrada: email válido + contraseña correcta
- Precondiciones: usuario registrado
- Pasos:
  1. Acceder al login
  2. Introducir credenciales
  3. Pulsar "Iniciar sesión"
- Resultado esperado: acceso al sistema
- Resultado obtenido: acceso correcto
- Estado: OK

### Caso 2: Contraseña incorrecta

- Entrada: email válido + contraseña incorrecta
- Pasos:
  1. Introducir credenciales
  2. Enviar formulario
- Resultado esperado: mensaje de error
- Resultado obtenido: mensaje mostrado
- Estado: OK

### Caso 3: Usuario no existente

- Entrada: email no registrado + cualquier contraseña
- Pasos:
  1. Introducir credenciales
  2. Enviar formulario
- Resultado esperado: mensaje "usuario no existe"
- Resultado obtenido: mensaje mostrado
- Estado: OK

### Caso 4: Campos vacíos

- Entrada: email vacío y/o contraseña vacía
- Pasos:
  1. Dejar campos vacíos
  2. Enviar formulario
- Resultado esperado: mensaje "Todos los campos son obligatorios"
- Resultado obtenido: mensaje mostrado
- Estado: OK

### Caso 5: Sesión creada correctamente

- Entrada: credenciales válidas
- Precondiciones: usuario registrado
- Pasos:
  1. Iniciar sesión
- Resultado esperado: variables de sesión creadas
- Resultado obtenido: sesión creada correctamente
- Estado: OK

### Caso 6: Acceso sin POST

- Entrada: acceso directo sin enviar formulario
- Pasos:
  1. Acceder a la ruta sin POST
- Resultado esperado: no se ejecuta login
- Resultado obtenido: no ocurre ninguna acción
- Estado: OK

---

## CU03 – Registro de reclamación

### Caso 1: Guardar borrador

- Entrada: datos válidos
- Pasos:
  1. Introducir datos
  2. Guardar
- Resultado esperado: guardado como borrador
- Resultado obtenido: OK
- Estado: OK

---

## CU04 – Asignación

### Caso 1: Asignación correcta

- Entrada: reclamación válida + usuario
- Pasos:
  1. Seleccionar reclamación
  2. Asignar usuario
- Resultado esperado: asignación realizada
- Resultado obtenido: OK
- Estado: OK

---

## CU05 – Seguimiento

### Caso 1: Cambio de estado

- Entrada: estado válido
- Pasos:
  1. Seleccionar reclamación
  2. Cambiar estado
- Resultado esperado: estado actualizado
- Resultado obtenido: OK
- Estado: OK

---

## CU07 – Logout

### Caso 1: Logout correcto

- Entrada: usuario autenticado
- Pasos:
  1. Pulsar logout
- Resultado esperado: sesión cerrada
- Resultado obtenido: OK
- Estado: OK
