# GestReclama · Reglas de negocio

<!-- TOC  -->
- [GestReclama · Reglas de negocio](#gestreclama--reglas-de-negocio)
  - [Workflow principal de reclamaciones](#workflow-principal-de-reclamaciones)
  - [Estados funcionales](#estados-funcionales)
  - [Reglas de negocio](#reglas-de-negocio)
  - [Restricciones funcionales generales](#restricciones-funcionales-generales)
<!--/TOC  -->

## Workflow principal de reclamaciones

El flujo principal de estados de una reclamación es:

BORRADOR → PENDIENTE → EN_TRAMITE → RESUELTA

---

## Estados funcionales

### BORRADOR

- La reclamación ha sido creada por un trabajador de franquicia, pero todavía no forma parte del flujo operativo del sistema.
- Mientras permanezca en estado BORRADOR:
  - puede modificarse
  - puede corregirse
  - no puede asignarse
  - no participa en seguimiento
  - no inicia gestión activa

### PENDIENTE

La reclamación ha sido validada por el encargado de franquicia y queda disponible para su asignación y gestión.

### EN_TRAMITE

- La reclamación:
  - ha sido asignada a un responsable de tramitación
  - se encuentra en gestión activa
  - permite seguimiento y registro de acciones

### RESUELTA

La reclamación ha finalizado su ciclo de gestión y se considera cerrada.

---

## Reglas de negocio

### RN-001 · Creación de borradores

El trabajador no encargado puede crear reclamaciones en estado BORRADOR.

### RN-002 · Persistencia inicial

Toda reclamación creada por un trabajador se almacena inicialmente en estado BORRADOR.

### RN-003 · Validación de reclamaciones

El encargado de franquicia es el único autorizado para validar reclamaciones en estado BORRADOR.

### RN-004 · Transición de registro

La validación de una reclamación provoca la transición:

BORRADOR → PENDIENTE

### RN-005 · Registro definitivo

El registro definitivo representa una acción funcional de validación y no un estado persistente independiente.

### RN-006 · Edición de borradores

- El trabajador puede:
  - abrir
  - editar
  - modificar
- únicamente reclamaciones en estado BORRADOR.

### RN-007 · Restricción tras validación

Una reclamación que deja de estar en estado BORRADOR pasa a modo consulta para el trabajador.

### RN-008 · Restricción de visibilidad por franquicia

Los usuarios solo pueden consultar reclamaciones asociadas a sus franquicias autorizadas, salvo roles con permisos globales.

### RN-009 · Restricciones trabajador

- El trabajador no encargado:
  - no puede validar reclamaciones
  - no puede cambiar estados
  - no puede asignar reclamaciones
  - no puede consultar reclamaciones de otras franquicias

### RN-010 · Restricciones encargado

- El encargado de franquicia:
  - solo puede gestionar reclamaciones de sus franquicias
  - puede validar borradores
  - no puede realizar asignaciones globales
  - no puede acceder al listado completo del sistema

### RN-011 · Asignación de reclamaciones

Una reclamación en estado PENDIENTE puede ser asignada por el responsable general a un responsable de tramitación.

### RN-012 · Inicio de gestión activa

La asignación de responsable provoca la transición: PENDIENTE → EN_TRAMITE

### RN-013 · Seguimiento de reclamaciones

- Las reclamaciones en estado EN_TRAMITE permiten:
  - actualización de estado
  - registro de acciones
  - seguimiento operativo

### RN-014 · Cierre de reclamaciones

Una reclamación puede pasar a estado RESUELTA cuando finaliza su gestión.

### RN-015 · Datos mínimos obligatorios para BORRADOR

- Para permitir el almacenamiento de una reclamación en estado BORRADOR el sistema exigirá:
  - Datos obligatorios:
    - descripción
    - tipo
    - prioridad
    - documento adjunto firmado asociado a la reclamación
  - Datos asignados automáticamente por el sistema:
    - franquicia asociada al usuario autenticado
    - usuario creador
    - fecha de creación
    - estado inicial BORRADOR
  - Datos no obligatorios inicialmente:
    - teléfono
    - email
    - importe
    - otros datos complementarios

### RN-016 · Transición BORRADOR → PENDIENTE

- La transición de una reclamación desde el estado BORRADOR al estado PENDIENTE únicamente puede ser realizada por un usuario con rol de encargado asociado a la franquicia de la reclamación.
- Condiciones necesarias para permitir la transición:
  - la reclamación debe encontrarse en estado BORRADOR
  - debe existir un documento adjunto firmado asociado a la reclamación
  - el usuario debe tener permisos de encargado
  - la reclamación debe pertenecer a una franquicia asociada al encargado
  - los datos mínimos obligatorios del estado PENDIENTE deben ser válidos
- Datos mínimos obligatorios para pasar a PENDIENTE
  - Datos del reclamante
    - nombre y apellidos
    - al menos una vía de contacto: teléfono o email
  - Datos de la reclamación
    - fecha del incidente
    - canal de entrada: presencial, teléfono, email, web, app
  - solicitud del cliente: devolución, reparación, compensación, informaciónl, otra
- Datos opcionales durante la validación
  - Datos del reclamante
    - DNI
    - dirección
    - código postal
    - ciudad
    - provincia
  - Otros datos complementarios
    - observaciones internas
    - información ampliada de seguimiento
    - datos adicionales extraídos del documento adjunto
- Durante el proceso de validación el encargado podrá completar información operativa adicional extraída del documento adjunto.
- El documento adjunto firmado constituye la fuente documental oficial de la reclamación.
- El sistema almacenará únicamente los datos necesarios para:
  - gestión operativa
  - búsqueda
  - filtrado
  - seguimiento de reclamaciones

### RN-017 · Comportamiento ante validación fallida

- Si la validación necesaria para realizar la transición de una reclamación desde el estado BORRADOR al estado PENDIENTE falla, el sistema deberá bloquear la transición y mantener la reclamación en estado BORRADOR.
- Ante una validación fallida el sistema:
  - mostrará mensajes de error al usuario indicando los datos inválidos o incompletos
  - conservará la información ya introducida en la reclamación
  - permitirá corregir los datos necesarios
  - impedirá el cambio de estado hasta completar correctamente la validación
- Una reclamación con validaciones pendientes o errores de integridad no podrá incorporarse al flujo operativo del sistema.

---

## Restricciones funcionales generales

### RFN-001 · Control combinado de acceso

- El acceso a funcionalidades y datos depende de
  - rol del usuario
  - franquicias asociadas
  - estado de la reclamación

### RFN-002 · Separación funcional del workflow

- El sistema separa:
  - captura preliminar de información
  - validación
  - asignación
  - gestión operativa
  - cierre
- para mantener trazabilidad y control del proceso.



