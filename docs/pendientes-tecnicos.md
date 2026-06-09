# TAREAS TÉCNICAS PENDIENTES DE HACER / EVALUAR

<!-- TOC -->
- [OBSERVACIONES TÉCNICAS URGENTES](#observaciones-técnicas-urgentes)
  - [1. Sustituir IDs de estados codificados por referencias dinámicas](#1-sustituir-ids-de-estados-codificados-por-referencias-dinámicas)
  - [2. Revisar flujo de asignación de reclamaciones](#2-revisar-flujo-de-asignación-de-reclamaciones)
- [OBSERVACIONES TÉCNICAS IMPORTANTES](#observaciones-técnicas-importantes)
  - [1. Centralizar acceso a parámetros HTTP](#1-centralizar-acceso-a-parámetros-http)
  - [2. Definir arquitectura CSS definitiva](#2-definir-arquitectura-css-definitiva)
- [OBSERVACIONES TÉCNICAS DE BAJA PRIORIDAD](#observaciones-técnicas-de-baja-prioridad)
  - [1. Revisar estrategia de gestión de rutas CSS](#1-revisar-estrategia-de-gestión-de-rutas-css)
  - [2. Evaluar menú dinámico por rol](#2-evaluar-menú-dinámico-por-rol)
  - [3. Unificar estrategia de resolución de vistas](#3-unificar-estrategia-de-resolución-de-vistas)


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

Estado: Parcialmente implementado. Revisar todas las vistas y controladores para completar la migración.

### 2. Revisar flujo de asignación de reclamaciones

Analizar y simplificar `ReclamacionController::asignar()`.

Actualmente el método mezcla dos responsabilidades:

- Asignación de responsables de tramitación.
- Registro de acciones y comentarios.

Evaluar si la creación de acciones debe permanecer en este flujo o trasladarse al flujo de seguimiento de reclamaciones (`show()`), dejando `asignar()` dedicado exclusivamente a la asignación de responsables.

Estado: Pendiente de análisis funcional y técnico.

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

### 2. Definir arquitectura CSS definitiva

Actualmente la aplicación utiliza hojas de estilo independientes asociadas a cada pantalla (`login.css`, `panel.css`, `reclamacion.index.css`, `reclamacion.create.css`, etc.).

Existe además una referencia visual procedente de un prototipo anterior que utilizaba una arquitectura CSS basada en:

- `base.css`
- `layout.css`
- `components.css`
- `pages.css`

Una vez finalizada la revisión funcional completa del proyecto, evaluar la migración hacia una arquitectura CSS común.

Objetivos:

- Centralizar estilos compartidos.
- Evitar duplicación de reglas entre pantallas.
- Separar claramente estructura, componentes y estilos específicos de página.
- Facilitar el mantenimiento y la evolución visual de la aplicación.
- Mejorar la coherencia entre todas las vistas.

Estructura candidata:

assets/css/
│
├── base.css
├── layout.css
├── components.css
├── pages.css
└── main.css

Estado: Pendiente de análisis tras finalizar la revisión funcional completa del proyecto.

## OBSERVACIONES TÉCNICAS DE BAJA PRIORIDAD

### 1. Revisar estrategia de gestión de rutas CSS

Actualmente existen dos formas de referenciar hojas de estilo:

- Rutas directas (ej.: `/css/panel.css`)
- Constantes centralizadas (ej.: `CSS_PATH . '/archivo.css'`)

Revisar y unificar el criterio utilizado en todo el proyecto para mejorar la consistencia y facilitar futuros cambios en la estructura de recursos estáticos.

Estado: Mejora de mantenibilidad. Baja prioridad.

### 2. Evaluar menú dinámico por rol

Actualmente el panel principal muestra las mismas opciones a todos los usuarios autenticados.

Revisar en el futuro si determinadas opciones deben mostrarse u ocultarse según el rol del usuario para mejorar la experiencia de uso y alinearse con el diseño funcional previsto.

Objetivos:

- Adaptar la navegación al rol autenticado.
- Mostrar únicamente acciones relevantes para cada perfil.
- Reducir opciones innecesarias en la interfaz.

Observación:

- Actualmente el menú lateral (sidebar.php) muestra todas las opciones de navegación a todos los usuarios autenticados.
- Cuando finalice el desarrollo funcional deberá revisarse si cada opción debe mostrarse únicamente a los roles autorizados según las reglas de negocio.

Estado: Pendiente de análisis funcional cuando finalice el desarrollo principal.

### 3. Unificar estrategia de resolución de vistas

Actualmente los layouts soportan dos formatos distintos para cargar vistas:

- Rutas absolutas basadas en `VIEWS_PATH`.
- Rutas relativas procesadas desde el propio layout.

Ejemplos actuales:

    $vista = VIEWS_PATH . '/reclamaciones/index.php';
    $vista = '/../auth/login.php';

Esta dualidad obliga a mantener lógica adicional en los layouts:

    if (file_exists($vista)) {
    require_once $vista;
    } else {
    require_once __DIR__ . $vista;
    }

Objetivos:

- Utilizar un único formato de rutas para todas las vistas.
- Simplificar los layouts.
- Reducir lógica de resolución de archivos.
- Mejorar la mantenibilidad del sistema.

Posible estrategia:

- Todos los controladores y puntos de entrada devolverán rutas absolutas basadas en VIEWS_PATH.
- Los layouts se limitarán a ejecutar directamente require_once $vista.

Estado: Mejora de arquitectura. Baja prioridad.