Durante el desarrollo del sistema se detectaron distintas dependencias entre funcionalidades, lo que permitió reorganizar determinadas tareas para mantener una arquitectura coherente y escalable.

Una de las principales dependencias identificadas fue la implementación de la protección de rutas. Aunque inicialmente se planteó de forma independiente, se comprobó que esta funcionalidad requería previamente la existencia de una zona privada autenticada (panel o dashboard), sobre la que aplicar las restricciones de acceso mediante sesión.

Asimismo, el desarrollo incremental del sistema permitió detectar y corregir pequeñas incidencias relacionadas con el flujo de autenticación, el routing básico de la aplicación y la gestión de sesiones, ajustando progresivamente la estructura del proyecto para mejorar la separación entre frontend, backend y controladores.

Estas mejoras y reorganizaciones facilitaron mantener una arquitectura más modular y preparada para futuras ampliaciones del sistema.

Durante la implementación del backend también se detectó la necesidad de centralizar progresivamente la carga de dependencias y las rutas base del sistema. Inicialmente, algunos archivos utilizaban inclusiones mediante rutas relativas directas, válidas para las primeras iteraciones del proyecto, pero que comenzaban a dificultar la mantenibilidad a medida que aumentaba la modularización del backend.

Como mejora técnica, se decidió preparar una estructura común de bootstrap y paths reutilizables, reduciendo acoplamientos entre módulos y facilitando futuras ampliaciones de la arquitectura.
