# Pruebas reclamaciones

## CU03 – Registro de reclamaciones

### Caso 1: Acceso al módulo de reclamaciones autenticado

- Entrada: acceso al módulo de reclamaciones
- Precondiciones:
  - sesión autenticada activa
- Pasos:
  1. Iniciar sesión correctamente
  2. Acceder al módulo de reclamaciones
- Resultado esperado:
  - acceso permitido al módulo
- Resultado obtenido:
  - acceso realizado correctamente
- Estado: OK

### Caso 2: Acceso bloqueado sin autenticación

- Entrada: acceso manual al módulo de reclamaciones
- Precondiciones:
  - sesión inexistente
- Pasos:
  1. Acceder manualmente a ruta protegida
- Resultado esperado:
  - redirección automática a login
- Resultado obtenido:
  - acceso bloqueado correctamente
- Estado: OK

### Caso 3: Carga correcta del formulario de reclamación

- Entrada: acceso al formulario
- Precondiciones:
  - usuario autenticado
- Pasos:
  1. Acceder al formulario de reclamaciones
- Resultado esperado:
  - formulario renderizado correctamente
- Resultado obtenido:
  - formulario mostrado correctamente
- Estado: OK

### Caso 4: Registro correcto de reclamación

- Entrada:
  - descripción válida
  - tipo válido
  - franquicia válida
- Precondiciones:
  - usuario autenticado
- Pasos:
  1. Completar formulario
  2. Enviar reclamación
- Resultado esperado:
  - reclamación almacenada correctamente
- Resultado obtenido:
  - reclamación registrada correctamente
- Estado: OK

### Caso 5: Registro de reclamación en estado borrador

- Entrada:
  - datos válidos
- Precondiciones:
  - usuario autenticado
- Pasos:
  1. Completar formulario parcialmente
  2. Guardar borrador
- Resultado esperado:
  - reclamación almacenada en estado borrador
- Resultado obtenido:
  - borrador guardado correctamente
- Estado: OK

### Caso 6: Validación de campos obligatorios

- Entrada:
  - formulario incompleto
- Pasos:
  1. Dejar campos obligatorios vacíos
  2. Enviar formulario
- Resultado esperado:
  - mensajes de validación mostrados
- Resultado obtenido:
  - validaciones ejecutadas correctamente
- Estado: OK

### Caso 7: Persistencia de datos tras error

- Entrada:
  - formulario parcialmente válido
- Pasos:
  1. Completar formulario
  2. Provocar error de validación
  3. Verificar contenido del formulario
- Resultado esperado:
  - datos persistidos tras error
- Resultado obtenido:
  - persistencia realizada correctamente
- Estado: OK

### Caso 8: Asociación automática con usuario creador

- Entrada:
  - reclamación válida
- Precondiciones:
  - usuario autenticado
- Pasos:
  1. Registrar reclamación
  2. Consultar datos almacenados
- Resultado esperado:
  - reclamación asociada al usuario autenticado
- Resultado obtenido:
  - asociación realizada correctamente
- Estado: OK

### Caso 9: Asociación correcta con franquicia

- Entrada:
  - reclamación válida
  - franquicia seleccionada
- Pasos:
  1. Registrar reclamación
  2. Verificar franquicia almacenada
- Resultado esperado:
  - franquicia almacenada correctamente
- Resultado obtenido:
  - asociación realizada correctamente
- Estado: OK

### Caso 10: Estado inicial correcto de reclamación

- Entrada:
  - nueva reclamación registrada
- Pasos:
  1. Registrar reclamación
  2. Consultar estado asignado
- Resultado esperado:
  - estado inicial correcto
- Resultado obtenido:
  - estado asignado correctamente
- Estado: OK

### Caso 11: Consulta de reclamaciones desde backend

- Entrada:
  - ejecución de consulta mediante modelo
- Precondiciones:
  - reclamaciones existentes en BD
- Pasos:
  1. Ejecutar script técnico de consulta
  2. Verificar resultados obtenidos
- Resultado esperado:
  - reclamaciones obtenidas correctamente
- Resultado obtenido:
  - consulta ejecutada correctamente
- Estado: OK

### Caso 12: Listado de reclamaciones renderizado correctamente

- Entrada:
  - reclamaciones existentes
- Precondiciones:
  - usuario autenticado
- Pasos:
  1. Acceder al listado
- Resultado esperado:
  - listado mostrado correctamente
- Resultado obtenido:
  - listado renderizado correctamente
- Estado: OK

### Caso 13: Visualización correcta de estados

- Entrada:
  - reclamaciones registradas
- Pasos:
  1. Acceder al listado
  2. Verificar visualización de estados
- Resultado esperado:
  - estados mostrados correctamente
- Resultado obtenido:
  - estados renderizados correctamente
- Estado: OK

### Caso 14: Consulta vacía sin reclamaciones

- Entrada:
  - sistema sin reclamaciones registradas
- Pasos:
  1. Ejecutar consulta
  2. Acceder al listado
- Resultado esperado:
  - sistema maneja correctamente lista vacía
- Resultado obtenido:
  - comportamiento correcto
- Estado: OK

### Caso 15: Integridad referencial de reclamaciones

- Entrada:
  - inserciones y relaciones activas
- Pasos:
  1. Registrar reclamación
  2. Validar relaciones en BD
- Resultado esperado:
  - relaciones válidas correctamente
- Resultado obtenido:
  - integridad validada correctamente
- Estado: OK