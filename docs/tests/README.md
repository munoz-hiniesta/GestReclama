# PRUEBAS GESTRECLAMA

## Metodología de pruebas

Las pruebas funcionales del sistema GestReclama se realizan de forma manual, validando progresivamente cada funcionalidad a medida que se desarrolla.

El objetivo de estas pruebas es verificar:

- el comportamiento esperado de las funcionalidades implementadas
- la correcta interacción entre componentes
- la estabilidad general del sistema
- la correcta gestión de errores y validaciones

Las pruebas se documentan progresivamente durante el desarrollo del proyecto.

---

## Organización de pruebas

El sistema de validación del proyecto se divide actualmente en dos partes:

### 1. Pruebas funcionales documentadas

Ubicadas en:

```text
docs/tests
```

Documentan:

- casos de uso
- validaciones funcionales
- comportamiento esperado del sistema
- pruebas frontend/layout

### 2. Scripts técnicos auxiliares

Ubicados en:

```text
backend/tests
```

Permiten validar componentes técnicos de forma aislada durante el desarrollo.

Incluyen:

- conexión y esquema de base de datos
- autenticación
- sesiones
- validaciones técnicas
- pruebas rápidas de desarrollo

---

## Organización de archivos

```text
docs/tests/
│
├── README.md
├── pruebas-auth.md
└── pruebas-frontend.md
```

### README.md

Documento principal del sistema de pruebas.

Incluye:

- metodología de pruebas
- organización general
- estructura de documentación

### pruebas-auth.md

Contiene pruebas relacionadas con autenticación y login.

Incluye:

- validación de credenciales
- mensajes de error
- persistencia de sesión
- validaciones de acceso

### pruebas-frontend.md

Contiene pruebas relacionadas con frontend y renderizado visual.

Incluye:

- renderizado de layouts
- carga dinámica de vistas
- carga de estilos CSS
- acceso de variables a vistas

---

## Estado actual

Las pruebas evolucionan progresivamente junto con el desarrollo del proyecto y se amplían conforme se implementan nuevas funcionalidades.
