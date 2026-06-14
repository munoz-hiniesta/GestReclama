# TAREAS TÉCNICAS PENDIENTES DE HACER / EVALUAR

<!-- TOC -->

- [OBSERVACIONES TÉCNICAS URGENTES](#observaciones-técnicas-urgentes)
  - [1. Sustituir IDs de estados codificados por referencias dinámicas](#1-sustituir-ids-de-estados-codificados-por-referencias-dinámicas)
  - [2. Revisar flujo de asignación de reclamaciones](#2-revisar-flujo-de-asignación-de-reclamaciones)
- [OBSERVACIONES TÉCNICAS IMPORTANTES](#observaciones-técnicas-importantes)
  - [1. Centralizar acceso a parámetros HTTP](#1-centralizar-acceso-a-parámetros-http)
  - [2. Migrar frontend a arquitectura CSS modular](#2-migrar-frontend-a-arquitectura-css-modular)
  - [3. Revisar responsabilidades de ReclamacionController](#3-revisar-responsabilidades-de-reclamacioncontroller)
  - [4. Revisar estrategia de roles del sistema](#4-revisar-estrategia-de-roles-del-sistema)
  - [5. Revisar aislamiento por franquicias](#5-revisar-aislamiento-por-franquicias)
- [OBSERVACIONES TÉCNICAS DE BAJA PRIORIDAD](#observaciones-técnicas-de-baja-prioridad)
  - [1. Revisar estrategia de gestión de rutas CSS](#1-revisar-estrategia-de-gestión-de-rutas-css)
  - [2. Evaluar menú dinámico por rol](#2-evaluar-menú-dinámico-por-rol)
  - [3. Unificar estrategia de resolución de vistas](#3-unificar-estrategia-de-resolución-de-vistas)
  - [4. Revisar consultas SQL residuales en controladores](#4-revisar-consultas-sql-residuales-en-controladores)
  - [5. Unificar acceso a estados del sistema](#5-unificar-acceso-a-estados-del-sistema)
  - [6. Revisar permisos sobre acciones de reclamaciones](#6-revisar-permisos-sobre-acciones-de-reclamaciones)
  - [7. Evaluar trazabilidad completa de cambios de estado](#7-evaluar-trazabilidad-completa-de-cambios-de-estado)

## OBSERVACIONES TÉCNICAS URGENTES

### 1. Sustituir IDs de estados codificados por referencias dinámicas

Eliminar comparaciones directas contra valores fijos como:

- `estado_id == 1`
- `estado_id == 2`
- etc.

Utilizar siempre `EstadosReclamacion::obtenerReferencias()` para obtener los IDs reales desde la base de datos.

Objetivos:

- Evitar dependencias ocultas con los datos iniciales.
- Permitir cambios en la base de datos sin romper la aplicación.
- Mantener coherencia con la arquitectura actual del backend.

Estado: Implementado. Mantener vigilancia en futuras funcionalidades.

### 2. Revisar flujo de asignación de reclamaciones

Analizar y simplificar `ReclamacionController::asignar()`.

Actualmente el método mezcla dos responsabilidades:

- Asignación de responsables de tramitación.
- Registro de acciones y comentarios.

Evaluar si la creación de acciones debe permanecer en este flujo o trasladarse al flujo de seguimiento de reclamaciones (`show()`), dejando `asignar()` dedicado exclusivamente a la asignación de responsables.

Estado: Pendiente de análisis funcional y técnico.

---

## OBSERVACIONES TÉCNICAS IMPORTANTES

### 1. Centralizar acceso a parámetros HTTP

Evaluar la creación de una capa común para la lectura de parámetros de entrada.

Actualmente se accede directamente a `$_GET` y `$_POST` desde distintos puntos de la aplicación.

Objetivos:

- Reducir duplicación de código.
- Unificar validaciones básicas.
- Facilitar mantenimiento y pruebas futuras.
- Evitar dependencias directas de superglobales en controladores y puntos de entrada.

Posible ámbito inicial:

- `frontend/public/index.php`
- Controladores del módulo de reclamaciones.
- Controladores de autenticación.

Estado: Mejora de arquitectura a valorar cuando finalice la funcionalidad principal.

### 2. Migrar frontend a arquitectura CSS modular

Existe un prototipo CSS previo compuesto por:

- base.css
- layout.css
- components.css
- pages.css

La estructura es compatible con la mayoría de pantallas actuales de GestReclama.

Una vez finalizada la revisión funcional del proyecto:

- Migrar las vistas actuales a dicha arquitectura.
- Reutilizar componentes existentes.
- Reducir CSS específico por pantalla.
- Aproximar la interfaz a los wireframes definidos en la memoria.

Estado: Pendiente hasta finalizar la revisión funcional.

### 3. Revisar responsabilidades de ReclamacionController

Actualmente ReclamacionController contiene lógica que debería estar delegada en servicios especializados.

Casos detectados:

- Gestión de archivos adjuntos.
- Validaciones repetidas entre create() y edit().
- Consultas SQL ejecutadas directamente desde el controlador.
- Construcción manual de arrays de datos para servicios.

Objetivos:

- Reducir tamaño del controlador.
- Mejorar separación de responsabilidades.
- Facilitar mantenimiento y pruebas.

Estado: Pospuesto hasta finalizar la entrega funcional.

### 4. Revisar estrategia de roles del sistema

Actualmente la aplicación almacena los roles reales mediante:

- `$_SESSION['rol_id']`

pero simplifica los permisos funcionales mediante:

- `$_SESSION['rol']`

con los valores:

- `encargado`
- `trabajador`

Esta simplificación es suficiente para el flujo actualmente implementado, pero no aprovecha completamente los roles definidos en la base de datos:

- ADMINISTRADOR
- RESPONSABLE_GENERAL
- RESPONSABLE_TRAMITACION
- ENCARGADO
- EMPLEADO

Evaluar en el futuro si los permisos deben basarse directamente en `rol_id` o `rol_clave`.

Estado: Pendiente de revisión global de permisos.

### 5. Revisar aislamiento por franquicias

Actualmente el sistema almacena relaciones entre usuarios y franquicias mediante:

- `usuario_franquicia`

Sin embargo, la creación y consulta de reclamaciones todavía no aplica de forma completa el aislamiento por franquicias.

Aspectos a revisar:

- Obtención automática de franquicias del usuario autenticado.
- Validación de pertenencia mediante `usuario_franquicia`.
- Restricción de acceso a reclamaciones de otras franquicias.
- Restricción de listados según franquicia.

Objetivos:

- Garantizar aislamiento entre franquicias.
- Cumplir las reglas de negocio.
- Evitar accesos cruzados.

Estado: Pendiente de revisión global de seguridad y permisos.

---

## OBSERVACIONES TÉCNICAS DE BAJA PRIORIDAD

### 1. Revisar estrategia de gestión de rutas CSS

Actualmente existen dos formas de referenciar hojas de estilo:

- Rutas directas.
- Constantes centralizadas.

Revisar y unificar el criterio utilizado en todo el proyecto.

Estado: Baja prioridad.

### 2. Evaluar menú dinámico por rol

Actualmente el panel principal y la navegación muestran las mismas opciones a todos los usuarios autenticados.

Evaluar en el futuro si determinadas opciones deben mostrarse u ocultarse según el rol.

Archivos afectados:

- `frontend/views/partials/sidebar.php`
- `frontend/views/panel/panel.php`
- `frontend/views/reclamaciones/index.php`
- `frontend/views/reclamaciones/pendientes_asignacion.php`

Estado: Pendiente de análisis funcional.

### 3. Unificar estrategia de resolución de vistas

Actualmente los layouts soportan dos formatos distintos para cargar vistas:

- Rutas absolutas basadas en `VIEWS_PATH`.
- Rutas relativas procesadas desde el propio layout.

Objetivos:

- Utilizar un único formato de rutas.
- Simplificar layouts.
- Reducir lógica de resolución de archivos.

Estado: Baja prioridad.

### 4. Revisar consultas SQL residuales en controladores

Durante la revisión de ReclamacionController se detecta una consulta SQL directa en el método `show()`.

Objetivos:

- Mantener consultas fuera de los controladores.
- Centralizar acceso a datos en servicios o modelos.
- Mejorar coherencia arquitectónica.

Estado: Baja prioridad.

### 5. Unificar acceso a estados del sistema

Actualmente conviven dos mecanismos:

- Consultas SQL directas sobre la tabla `estados`.
- Uso de `EstadosReclamacion::obtenerReferencias()`.

Evaluar la unificación en una única estrategia.

Objetivos:

- Reducir duplicación.
- Centralizar referencias de estados.
- Facilitar mantenimiento.

Estado: Baja prioridad.

### 6. Revisar permisos sobre acciones de reclamaciones

Actualmente cualquier usuario autenticado puede acceder al formulario de acciones y registrar comentarios.

Evaluar qué perfiles deben poder:

- Registrar acciones.
- Resolver reclamaciones.
- Consultar determinadas reclamaciones.

Archivos afectados:

- `frontend/views/reclamaciones/show.php`
- `backend/controllers/ReclamacionController.php`

Estado: Pendiente de revisión funcional.

### 7. Evaluar trazabilidad completa de cambios de estado

Actualmente algunos cambios importantes del workflow no generan automáticamente registros en:

```sql
acciones_reclamacion
```

Casos a revisar:

- Validación de reclamaciones.
- Asignación de responsable.
- Otros cambios automáticos de estado.

Objetivos:

- Mejorar trazabilidad.
- Mantener histórico completo del proceso.
- Facilitar auditoría funcional.

Estado: Mejora futura de bajo impacto funcional.
