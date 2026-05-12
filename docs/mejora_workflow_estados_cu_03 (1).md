# Ajustes de redacción recomendados · GestReclama

Este documento recoge los ajustes recomendados para alinear:
- flujo funcional real
- estados de reclamación
- roles
- CU03
- RF09/RF10
- wireframes
- implementación futura

El objetivo es eliminar ambigüedades entre:
- “registrar” como acción
- y los estados persistentes reales del sistema.

---

# 1. Página 5 · Objetivos específicos

## Texto actual

```md
• Permitir el registro de reclamaciones por los encargados de cada franquicia.
```

## Sustituir por

```md
• Permitir la creación de reclamaciones en estado borrador por trabajadores de franquicia y su validación posterior por los encargados correspondientes.
```

---

# 2. Página 20 · RF10 – Registro de reclamaciones

## Texto actual

```md
• RF10 – Registro de reclamaciones: El encargado de una franquicia podrá revisar las reclamaciones en estado borrador para registrarlas en el sistema. Cada reclamación quedará asociada a la franquicia donde se ha producido la incidencia.
```

## Sustituir por

```md
• RF10 – Registro de reclamaciones: El encargado de una franquicia podrá revisar las reclamaciones en estado borrador y validarlas para su registro definitivo. Esta validación provocará el cambio de estado de la reclamación desde BORRADOR a PENDIENTE, quedando disponible para su posterior asignación y tramitación. Cada reclamación quedará asociada a la franquicia donde se ha producido la incidencia.
```

---

# 3. Página 23 · Actor “Encargado de franquicia”

## Texto actual

```md
• Registra nuevas reclamaciones.
```

## Sustituir por

```md
• Valida reclamaciones en estado borrador y realiza su registro definitivo dentro del sistema.
```

---

# 4. Página 23 · Actor “Trabajador no encargado de franquicia”

## Texto actual

```md
• Comunica reclamaciones al encargado.
```

## Sustituir por

```md
• Introduce reclamaciones en estado borrador para su posterior validación por el encargado.
```

---

# 5. Página 25 · CU03 · Descripción

## Texto actual

```md
Permite registrar una reclamación en el sistema a partir de un borrador ya creado por un trabajador. El encargado de franquicia revisa lo revisa y valida su registro definitivo.
```

## Sustituir por

```md
Permite gestionar el registro de una reclamación mediante un flujo dividido en dos fases. En la primera, un trabajador de franquicia introduce la información y guarda la reclamación en estado BORRADOR. Posteriormente, el encargado de franquicia revisa la información introducida y valida el registro definitivo, provocando la transición de la reclamación al estado PENDIENTE.
```

---

# 6. Página 25 · CU03 · Postcondición

## Texto actual

```md
La reclamación queda registrada en el sistema y pendiente de asignación.
```

## Sustituir por

```md
La reclamación cambia del estado BORRADOR al estado PENDIENTE y queda disponible para su posterior asignación a un responsable de tramitación.
```

---

# 7. Página 39 · Pantalla “Registro de reclamaciones” · Flujo de navegación

## Texto actual

```md
Una vez registrada la reclamación, esta queda almacenada en la base de datos, asociada a la franquicia correspondiente y pendiente de asignación a un responsable de tramitación.
```

## Sustituir por

```md
Una vez validada por el encargado, la reclamación cambia del estado BORRADOR al estado PENDIENTE, quedando almacenada en la base de datos, asociada a la franquicia correspondiente y disponible para su posterior asignación a un responsable de tramitación.
```

---

# 8. Página 39 · Pantalla “Registro de reclamaciones” · Wireframe

## Texto actual

```md
• El encargado puede validar y registrar la reclamación
```

## Sustituir por

```md
• El encargado puede validar el borrador y registrar definitivamente la reclamación, realizando la transición BORRADOR → PENDIENTE
```

---

# 9. Página 39 · Pantalla “Registro de reclamaciones” · Relación con el Modelo de Datos

## Texto actual

```md
El sistema asigna un estado inicial a la reclamación y permite su posterior gestión, incluyendo la asignación a un responsable de tramitación en fases posteriores del flujo.
```

## Sustituir por

```md
El sistema asigna inicialmente el estado BORRADOR a la reclamación. Tras la validación realizada por el encargado de franquicia, la reclamación cambia al estado PENDIENTE y continúa su ciclo de gestión dentro del sistema.
```

---

# 10. Página 44 · Módulo de gestión de reclamaciones

## Texto actual

```md
Permite registrar reclamaciones en estado borrador, validarlas y almacenarlas de forma definitiva, iniciando su ciclo de vida.
```

## Sustituir por

```md
Permite crear reclamaciones en estado BORRADOR, validarlas posteriormente mediante el encargado de franquicia y realizar la transición al estado PENDIENTE, iniciando así el ciclo de vida operativo de la reclamación.
```

---

# 11. Página 45 · Funciones principales · Registro de reclamaciones

## Texto actual

```md
• Registro de reclamaciones: Creación de reclamaciones en estado borrador y registro definitivo tras validación.
```

## Sustituir por

```md
• Registro de reclamaciones: Creación de reclamaciones en estado BORRADOR y transición al estado PENDIENTE tras la validación realizada por el encargado de franquicia.
```

---

# 12. Página 47 · Ajustes realizados durante el diseño

## Texto actual

```md
• Separación del registro de reclamaciones en dos fases (borrador y registro definitivo), mejorando el control del proceso.
```

## Sustituir por

```md
• Separación del flujo de reclamaciones en dos fases diferenciadas: creación en estado BORRADOR por trabajadores de franquicia y validación posterior por encargados, provocando la transición al estado PENDIENTE.
```

---

# Resultado funcional final alineado

Tras estos ajustes:
- BORRADOR pasa a ser un estado real y persistente.
- PENDIENTE representa el inicio operativo de la reclamación.
- “Registrar” deja de interpretarse como estado y pasa a representar una acción/transición funcional.
- Los roles quedan claramente diferenciados.
- CU03, RF09, RF10 y el wireframe quedan alineados con el flujo real del sistema.
- El workflow del sistema queda definido de forma coherente:

```md
BORRADOR
↓
PENDIENTE
↓
ASIGNADA
↓
EN_TRAMITACIÓN
↓
CERRADA
```

