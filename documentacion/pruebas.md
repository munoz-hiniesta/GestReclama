# PRUEBAS GESTRECLAMA

## CU02 – Login

- Caso: Login correcto  
  Entrada: email válido + contraseña correcta  
  Resultado esperado: acceso al sistema  
  Resultado obtenido: OK  

- Caso: Contraseña incorrecta  
  Entrada: email válido + contraseña incorrecta  
  Resultado esperado: mensaje de error  
  Resultado obtenido: OK  

- Caso: Usuario no existente  
  Entrada: email no registrado  
  Resultado esperado: mensaje de error  
  Resultado obtenido: OK  


## CU03 – Registro de reclamación

- Caso: Guardar borrador  
  Entrada: datos válidos  
  Resultado esperado: guardado como borrador  
  Resultado obtenido: OK  

- Caso: Registro definitivo  
  Entrada: validación por encargado  
  Resultado esperado: reclamación registrada  
  Resultado obtenido: OK  

- Caso: Campo obligatorio vacío  
  Entrada: sin descripción  
  Resultado esperado: error validación  
  Resultado obtenido: OK  


## CU04 – Asignación

- Caso: Asignación correcta  
  Entrada: reclamación pendiente + responsable válido  
  Resultado esperado: asignación realizada  
  Resultado obtenido: OK  

- Caso: Sin seleccionar responsable  
  Entrada: campo vacío  
  Resultado esperado: error  
  Resultado obtenido: OK  


## CU05 – Seguimiento

- Caso: Actualización de estado  
  Entrada: cambio de estado válido  
  Resultado esperado: estado actualizado  
  Resultado obtenido: OK  

- Caso: Registro de acción  
  Entrada: comentario válido  
  Resultado esperado: acción registrada  
  Resultado obtenido: OK  


## CU06 – Consulta de reclamaciones

- Caso: Consulta general  
  Entrada: acceso al listado  
  Resultado esperado: listado de reclamaciones mostrado  
  Resultado obtenido: OK  

- Caso: Filtrado por estado  
  Entrada: estado seleccionado  
  Resultado esperado: solo reclamaciones con ese estado  
  Resultado obtenido: OK  

- Caso: Filtrado por franquicia  
  Entrada: franquicia seleccionada  
  Resultado esperado: reclamaciones filtradas correctamente  
  Resultado obtenido: OK  

- Caso: Filtrado por fechas  
  Entrada: rango de fechas válido  
  Resultado esperado: resultados dentro del rango  
  Resultado obtenido: OK  


## CU07 – Cierre de sesión

- Caso: Logout correcto  
  Entrada: usuario autenticado → cerrar sesión  
  Resultado esperado: sesión finalizada y redirección a login  
  Resultado obtenido: OK  

- Caso: Acceso tras logout  
  Entrada: intento de acceso sin sesión  
  Resultado esperado: redirección a login  
  Resultado obtenido: OK  


## CU08 – Consulta de usuarios

- Caso: Visualización de usuarios  
  Entrada: acceso como administrador  
  Resultado esperado: listado de usuarios mostrado  
  Resultado obtenido: OK  

- Caso: Acceso sin permisos  
  Entrada: usuario no administrador  
  Resultado esperado: acceso denegado  
  Resultado obtenido: OK  


## CU09 – Gestión de franquicias

- Caso: Registro de franquicia  
  Entrada: datos válidos  
  Resultado esperado: franquicia registrada  
  Resultado obtenido: OK  

- Caso: Consulta de franquicias  
  Entrada: acceso al listado  
  Resultado esperado: listado mostrado correctamente  
  Resultado obtenido: OK  

- Caso: Asociación usuario-franquicia  
  Entrada: usuario + franquicia  
  Resultado esperado: asociación creada  
  Resultado obtenido: OK  


## CU10 – Búsqueda de reclamación por ID

- Caso: Búsqueda correcta  
  Entrada: ID existente  
  Resultado esperado: reclamación encontrada  
  Resultado obtenido: OK  

- Caso: ID inexistente  
  Entrada: ID no registrado  
  Resultado esperado: mensaje de no encontrado  
  Resultado obtenido: OK  