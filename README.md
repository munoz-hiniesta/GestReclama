# GestReclama

Aplicación web para la gestión de reclamaciones en un entorno de franquicias. Desarrollada como **Proyecto Final de CFGS DAW** (Desarrollo de Aplicaciones Web).

---

## 1. Descripción del proyecto

GestReclama permite a los usuarios autenticados registrar, consultar, validar, asignar y realizar el seguimiento de reclamaciones. El sistema gestiona un flujo de estados que va desde el borrador inicial hasta la resolución de la reclamación.

La aplicación está construida con PHP sin frameworks, siguiendo una organización MVC propia, con persistencia en MySQL y presentación en HTML y CSS.

---

## 2. Objetivos

- Centralizar la gestión de reclamaciones de franquicia en una única aplicación web.
- Controlar el acceso mediante autenticación con sesión PHP.
- Permitir el registro de reclamaciones en estado borrador y su posterior validación.
- Facilitar la asignación de responsables de tramitación.
- Registrar el histórico de acciones y el seguimiento de cada reclamación.
- Aplicar reglas de negocio sobre los estados: BORRADOR, PENDIENTE, EN_TRAMITE y RESUELTA.

Las reglas de negocio detalladas se documentan en `docs/reglas-negocio.md`.

---

## 3. Tecnologías utilizadas

| Tecnología | Uso en el proyecto |
|------------|-------------------|
| PHP 8.x | Lógica de aplicación, controladores, servicios y vistas |
| MySQL | Base de datos relacional |
| HTML5 | Estructura de las vistas |
| CSS3 | Estilos de la interfaz |
| Apache | Servidor web (entorno LAMP) |
| PDO | Acceso a base de datos |

El proyecto no utiliza frameworks PHP ni librerías de frontend. No hay archivos JavaScript en el repositorio.

---

## 4. Arquitectura

La aplicación sigue una arquitectura MVC propia con dos puntos de entrada HTTP:

| Capa            | Ubicación                         | Responsabilidad                                                 |
|-----------------|-----------------------------------|-----------------------------------------------------------------|
| Entrada         | `frontend/public/index.php`       | Front controller: resuelve la acción (`action`) por GET o POST  |
| Entrada         | `frontend/public/panel.php`       | Acceso directo al panel principal autenticado                   |
| Controladores   | `backend/controllers/`            | Coordinan servicios y preparan datos para la vista              |
| Servicios       | `backend/services/`               | Lógica de negocio y consultas SQL mediante PDO                  |
| Modelos         | `backend/models/`                 | Clases de acceso a datos (uso limitado en el flujo actual)      |
| Vistas          | `frontend/views/`                 | Presentación HTML                                               |
| Layouts         | `frontend/views/layouts/`         | Estructura común de página                                      |
| Partials        | `frontend/views/partials/`        | Fragmentos reutilizables (`sidebar.php`, `mensaje.php`)         |
| Middleware      | `backend/middleware/auth.php`     | Comprueba sesión activa y redirige al login                     |
| Bootstrap       | `backend/bootstrap/bootstrap.php` | Constantes de rutas, `session_start()` y conexión PDO           |

### Flujo de una petición

**Desde `index.php`:**

1. Se carga el bootstrap y se obtiene la acción solicitada.
2. Si la acción está en la lista de rutas protegidas, se ejecuta `auth.php`.
3. Un `switch` resuelve la acción: controlador, variables de vista (`$vista`, `$pageTitle`, `$css`) o redirección (`logout`).
4. Se carga el layout según el tipo de acción:
   - `auth.layout.php` — login y acciones no autenticadas.
   - `app.layout.php` — acciones del array `$protectedActions` en `index.php`.

**Desde `panel.php`:**

1. Se carga el bootstrap y `auth.php`.
2. Se definen `$vista`, `$pageTitle` y `$css`.
3. Se carga siempre `app.layout.php`.

### Layouts en uso

| Layout | Cargado desde | Uso actual |
|--------|---------------|------------|
| `auth.layout.php` | `index.php` | Pantalla de login y acciones no privadas |
| `app.layout.php` | `index.php` (rutas protegidas) y `panel.php` | Pantallas autenticadas con cabecera, menú lateral y área principal |

El archivo `public.layout.php` existe en `frontend/views/layouts/`, pero ningún punto de entrada del proyecto lo utiliza.

### Roles en sesión

Tras un login correcto, la sesión almacena `id`, `nombre`, `rol_id` y un rol funcional simplificado:

- `encargado` — si el usuario tiene rol `ENCARGADO` en base de datos.
- `trabajador` — para el resto de roles.

Este rol funcional condiciona acciones como la validación de borradores.

---

## 5. Estructura de directorios

```text
gestreclama/
├── backend/
│   ├── bootstrap/          # Constantes y arranque (sesión, PDO)
│   ├── config/             # database.php (local, no versionado), database.example.php
│   ├── controllers/        # AuthController.php, ReclamacionController.php
│   ├── database/           # schema.sql, datos.sql, connection.php
│   ├── helpers/            # crearHash.sql (utilidad para generar hashes)
│   ├── middleware/         # auth.php
│   ├── models/             # Estado.php, Reclamacion.php
│   ├── services/           # AuthService, ReclamacionService, AccionesReclamacionService, EstadosReclamacion
│   └── tests/              # Scripts de validación técnica (CLI)
├── docs/
│   ├── reglas-negocio.md
│   └── tests/              # Pruebas funcionales documentadas
├── frontend/
│   ├── public/             # DocumentRoot del servidor web
│   │   ├── assets/css/     # login.css, reclamacion.index.css
│   │   ├── index.php
│   │   ├── panel.php
│   │   └── uploads/        # Archivos adjuntos (generados en ejecución)
│   └── views/
│       ├── auth/
│       ├── layouts/        # app.layout.php, auth.layout.php, public.layout.php
│       ├── panel/
│       ├── partials/
│       └── reclamaciones/
├── README.md
├── README_01.md
└── README_02.md
```

---

## 6. Casos de uso implementados

| Código | Caso de uso                                   |
|--------|-----------------------------------------------|
| CU01   | Registro de usuario                           |
| CU02   | Inicio de sesión                              |
| CU03   | Registro de reclamación                       |
| CU04   | Asignación de responsable de tramitación      |
| CU05   | Seguimiento de la reclamación                 |
| CU06   | Consulta de reclamaciones                     |
| CU07   | Cierre de sesión                              |
| CU08   | Consulta de usuarios                          |
| CU09   | Registro y consulta de franquicias            |
| CU10   | Búsqueda individual de reclamaciones por ID   |

### Acciones protegidas en `index.php`

Las siguientes acciones requieren sesión activa y cargan `app.layout.php`:

`reclamaciones.index`, `reclamaciones.show`, `reclamaciones.edit`, `reclamaciones.pendientes_asignacion`, `reclamaciones.asignar`, `reclamaciones.create.view`, `reclamaciones.create`, `reclamaciones.validar`.

### Menú lateral (`sidebar.php`)

Incluido en `app.layout.php`:

- Panel principal → `panel.php`
- Crear reclamación → `reclamaciones.create.view`
- Consulta reclamaciones → `reclamaciones.index`
- Pendientes de asignación → `reclamaciones.pendientes_asignacion`
- Cerrar sesión → `logout`

### Flujo de estados

```text
BORRADOR → PENDIENTE → EN_TRAMITE → RESUELTA
```

---

## 7. Instalación y ejecución

### Requisitos

- PHP 8.x con extensiones PDO y MySQL
- MySQL
- Apache (o servidor compatible con PHP)

### Pasos

1. Clonar el repositorio en el entorno local.

2. Crear la base de datos e importar el esquema con datos iniciales:

   ```bash
   mysql -u usuario -p nombre_base_datos < backend/database/schema.sql
   ```

   El archivo `schema.sql` crea las tablas e inserta roles, estados, tipos, prioridades, usuarios, franquicias y reclamaciones de ejemplo.

3. Configurar la conexión a la base de datos:

   - Copiar `backend/config/database.example.php` como `backend/config/database.php`.
   - Editar host, nombre de base de datos, usuario y contraseña.

4. Configurar Apache con `DocumentRoot` apuntando a `frontend/public/`:

   ```apache
   <VirtualHost *:80>
     ServerName gestreclama.local
     DocumentRoot /ruta/al/proyecto/frontend/public
     <Directory /ruta/al/proyecto/frontend/public>
       AllowOverride All
       Require all granted
     </Directory>
   </VirtualHost>
   ```

5. Añadir la entrada local en `/etc/hosts`:

   ```text
   127.0.0.1 gestreclama.local
   ```

6. Reiniciar Apache y acceder desde el navegador:

   ```text
   http://gestreclama.local
   ```

### Usuarios de prueba

`schema.sql` inserta cinco usuarios. Contraseñas verificadas contra los hashes del propio script:

| Email | Rol en BD | Contraseña |
|-------|-----------|------------|
| `email_001@gestreclama.com` | Administrador | `001` |
| `email_002@gestreclama.com` | Responsable General | `001` |
| `email_003@gestreclama.com` | Responsable Tramitación | `003` |
| `email_004@gestreclama.com` | Encargado | `003` |
| `email_005@gestreclama.com` | Empleado | `005` |

El usuario con rol **Encargado** (`email_004@gestreclama.com`) dispone del rol funcional `encargado` en sesión y puede validar borradores.

El script `backend/tests/test_login.php` utiliza `email_001@gestreclama.com` con contraseña `001`.

### Pruebas

- Pruebas funcionales documentadas: `docs/tests/`
- Scripts técnicos de validación: `backend/tests/`

---

## 8. Estado actual del proyecto

GestReclama dispone de un módulo de reclamaciones operativo que cubre el ciclo principal: creación de borrador, consulta, edición, validación, asignación y seguimiento con registro de acciones.

La autenticación por sesión PHP está integrada. Las rutas privadas de `index.php` están protegidas mediante `auth.php`, y `panel.php` aplica la misma protección de forma directa.

La interfaz privada utiliza `app.layout.php` (cabecera, menú lateral y contenido principal). La pantalla de login utiliza `auth.layout.php`.

Las hojas de estilo presentes en el repositorio son `frontend/public/assets/css/login.css` y `frontend/public/assets/css/reclamacion.index.css`. Otras rutas CSS referenciadas en el código (`panel.css`, `reclamacion.create.css`) no tienen archivo correspondiente en el repositorio actual.

La documentación de reglas de negocio y de pruebas se encuentra en `docs/`.

---

*Proyecto Final de CFGS DAW — GestReclama*
