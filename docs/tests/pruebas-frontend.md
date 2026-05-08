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