# Pruebas frontend

## Layout frontend

### Caso 1: Renderizado correcto del layout

- Entrada: acceso a `gestreclama.local`
- Pasos:
  1. Acceder a la aplicación
- Resultado esperado:
  - layout renderizado correctamente
  - vista login visible
- Resultado obtenido:
  - layout y vista cargados correctamente
- Estado: OK

### Caso 2: Carga correcta de CSS dinámico

- Entrada: acceso a pantalla login
- Pasos:
  1. Acceder al login
  2. Verificar estilos cargados
- Resultado esperado:
  - archivo `login.css` aplicado correctamente
- Resultado obtenido:
  - estilos cargados correctamente
- Estado: OK

### Caso 3: Renderizado dinámico de vistas

- Entrada: renderizado desde `layout.php`
- Pasos:
  1. Acceder a la aplicación
  2. Verificar carga de `login.php` desde layout
- Resultado esperado:
  - vista renderizada correctamente dentro del layout
- Resultado obtenido:
  - vista renderizada correctamente
- Estado: OK

### Caso 4: Variables accesibles desde vistas

- Entrada: mensaje y email desde controller
- Pasos:
  1. Introducir login incorrecto
  2. Verificar renderizado del mensaje
- Resultado esperado:
  - mensaje visible
  - email persistido
- Resultado obtenido:
  - variables accesibles correctamente

---

## Estilos login

### Caso 5: Renderizado visual correcto del login

- Entrada: acceso a `gestreclama.local`
- Pasos:
  1. Acceder a la pantalla login
- Resultado esperado:
  - login centrado en pantalla
  - card visible correctamente
  - estructura visual estable
- Resultado obtenido:
  - login renderizado correctamente
- Estado: OK

### Caso 1: Jerarquía visual del login

- Entrada: acceso a pantalla login
- Pasos:
  1. Verificar estructura visual del login
- Resultado esperado:
  - título visible correctamente
  - subtítulo visible correctamente
  - formulario organizado visualmente
- Resultado obtenido:
  - jerarquía visual aplicada correctamente
- Estado: OK

### Caso 2: Distribución vertical de campos

- Entrada: acceso a pantalla login
- Pasos:
  1. Verificar disposición de labels e inputs
- Resultado esperado:
  - campos alineados verticalmente
  - separación visual consistente
- Resultado obtenido:
  - distribución visual correcta
- Estado: OK

### Caso 3: Estilos de inputs y formulario

- Entrada: acceso a pantalla login
- Pasos:
  1. Verificar estilos de inputs
  2. Verificar estilos generales del formulario
- Resultado esperado:
  - inputs estilizados correctamente
  - bordes y padding visibles
  - tipografía aplicada correctamente
- Resultado obtenido:
  - estilos aplicados correctamente
- Estado: OK

### Caso 4: Estilos del botón login

- Entrada: acceso a pantalla login
- Pasos:
  1. Verificar renderizado del botón
  2. Pasar cursor sobre el botón
- Resultado esperado:
  - botón visible correctamente
  - efecto hover funcional
- Resultado obtenido:
  - botón estilizado correctamente
- Estado: OK

### Caso 5: Visualización de mensajes de error

- Entrada: login incorrecto
- Pasos:
  1. Introducir credenciales inválidas
  2. Enviar formulario
- Resultado esperado:
  - mensaje visible correctamente
  - mensaje integrado visualmente en el login
  - layout estable tras mostrar mensaje
- Resultado obtenido:
  - mensaje renderizado correctamente
- Estado: OK

### Caso 6: Responsive básico del login

- Entrada: reducción manual del viewport
- Pasos:
  1. Reducir ancho de navegador
  2. Verificar comportamiento del login
- Resultado esperado:
  - card mantiene visibilidad
  - contenido no desborda pantalla
  - layout sigue estable
- Resultado obtenido:
  - responsive básico funcional
- Estado: OK
