# GestReclama

  Aplicación web para la gestión de reclamaciones en empresas con múltiples franquicias.

## Estado del proyecto

  Proyecto en fase inicial de desarrollo.

  Actualmente se está implementando la base técnica del sistema:

    - Estructura del proyecto
    - Configuración del entorno
    - Base de datos (en progreso)
    - Sistema de autenticación (en desarrollo)

## Tecnologías utilizadas

  PHP 8.2
  MySQL
  HTML5
  CSS3
  JavaScript (vanilla)
  Entorno LAMP (Linux, Apache, MySQL, PHP)

## Estructura del proyecto

  backend/
  │
  ├── auth/                 # login, logout, control sesión
  ├── config/               # conexión BD (PDO), config general
  ├── controllers/          # lógica de cada acción (login, registro, etc.)
  ├── models/               # acceso a datos (usuario, reclamación…)
  ├── database/             # scripts SQL (tablas, inserts)
  ├── helpers/              # funciones reutilizables (opcional)
  │
  frontend/
  │
  ├── views/
  │   ├── auth/             # login
  │   ├── panel/            # dashboard
  │   ├── reclamaciones/    # listados, detalle
  │   ├── layout/           # header, footer
  │   └── partials/         # componentes pequeños
  │
  ├── public/
  │   ├── css/
  │   └── js/
  │
  .gitignore
  README.md

## Configuración básica

  1. Clonar el repositorio:
    git clone <URL_DEL_REPOSITORIO>
  2. Configurar la base de datos:
    - Crear una base de datos en MySQL
    - Importar los scripts desde `backend/database/`
  3. Configurar la conexión:
    - Editar o crear el archivo: `backend/config/database.php` con los datos de conexión a la base de datos

## Configurador del servidor (Apache)

  El proyecto está diseñado para ejecutarse mediante un VirtualHost que apunta al directorio frontend/public.

  1. Crear un VirtualHost en Apache:
    sudo nano /etc/apache2/sites-available/gestreclama.conf
      Contenido:
        <VirtualHost *:80>
          ServerName gestreclama.local
          DocumentRoot /ruta/al/proyecto/frontend/public
          <Directory /ruta/al/proyecto/frontend/public>
            AllowOverride All
            Require all granted
          </Directory>
        </VirtualHost>
  2. Activar el sitio: sudo a2ensite gestreclama.conf
  3. Añadir entrada en /etc/hosts: 127.0.0.1 gestreclama.local
  4. Reiniciar Apache: sudo systemctl restart apache2
  
  > Nota: Alternativamente, el proyecto puede ejecutarse desde el DocumentRoot de Apache, aunque se recomienda el uso de VirtualHost para una configuración más limpia y segura.

## Ejecución

  Ejecutar el proyecto en un entorno LAMP (Apache + PHP + MySQL).
  Acceder desde el navegador: `http://gestreclama.local`

## Funcionalidades previstas

  Autenticación de usuarios
  Gestión de usuarios
  Registro de reclamaciones
  Asignación de responsables
  Seguimiento de reclamaciones
  Consultas y filtrado

## Pruebas

  Las pruebas funcionales se documentarán en: `pruebas.md`

## Notas

Este proyecto forma parte de un desarrollo académico y se está construyendo de forma progresiva siguiendo un enfoque ágil.
