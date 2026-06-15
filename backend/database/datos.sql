
-- ============================================
-- DATOS INICIALES DE DEMOSTRACIÓN
-- GESTRECLAMA
-- Ejecutar después de schema.sql
-- ============================================

-- ============================================
-- USUARIOS
-- Contraseñas:
-- Laura Medina Ruiz: lmr
-- Antonio Romero Gil: arg
-- Marta Sánchez León: msl
-- Daniel Torres Vega: dtv
-- Carmen Ortega Martín: com
-- Javier Navarro Díaz: jnd
-- Elena Cruz Pérez: ecp
-- Sergio Molina Castro: smc
-- Nuria Herrera Soto: nhs
-- Pablo Jiménez Ríos: pjr
-- ============================================

INSERT INTO usuarios (nombre, email, password, rol_id, activo) VALUES
  ("Laura Medina Ruiz", "laura.medina.ruiz@gmail.com", "$2y$10$REuXevRoxlxca9YF3rPqnO078qqc9ucIHk6VN8voF7EMuduVakSua", 1, TRUE),
  ("Antonio Romero Gil", "antonio.romero.gil@gmail.com", "$2y$10$Mp5/g4rVY9Uf4qvM1tQKZO4VycelY/mZjzUWvD86WYxkJe5safFiW", 2, TRUE),
  ("Marta Sánchez León", "marta.sanchez.leon@gmail.com", "$2y$10$KhEavesRRq0AE3woH2EaeO3uw20n6KlJGuyWcUxVwZv8k9k4KVxKi", 3, TRUE),
  ("Daniel Torres Vega", "daniel.torres.vega@gmail.com", "$2y$10$.za8TRHUWySN3pyPCcOp8OBy/7GtGgFrYb4WOc/ZlM9QdZibnwNf2", 3, TRUE),
  ("Carmen Ortega Martín", "carmen.ortega.martin@gmail.com", "$2y$10$SxPq5H0w/Fc2BrOymop7FecklMx8QEon3qXIAeeU.4duauPeLDNyu", 4, TRUE),
  ("Javier Navarro Díaz", "javier.navarro.diaz@gmail.com", "$2y$10$dGbj8CJc7G37RiW3wT.5kuaId2nWmjaoVD59pSohof53z/kuzLglC", 4, TRUE),
  ("Elena Cruz Pérez", "elena.cruz.perez@gmail.com", "$2y$10$1H4qxpPrgXpeNarCmqEKv.3j/wuCdWVXrhITy77BcaK9CRsfmDSnW", 5, TRUE),
  ("Sergio Molina Castro", "sergio.molina.castro@gmail.com", "$2y$10$IBoqnKgOfiI0IxneQtKQk.AWqVXUAucvrOvOkYlbZNzLDVcxEwoB6", 5, TRUE),
  ("Nuria Herrera Soto", "nuria.herrera.soto@gmail.com", "$2y$10$NF.zhIJBcxvvfGPBQlLjNuR/42ck2ThENJpVtLFazuQl.SNGJLl3i", 5, TRUE),
  ("Pablo Jiménez Ríos", "pablo.jimenez.rios@gmail.com", "$2y$10$2C5OW.OwdzJ.GijMmZgFOupuniDsANc4a/cSvRQHpesQcjG32UD8W", 5, FALSE);

-- ============================================
-- FRANQUICIAS
-- ============================================

INSERT INTO franquicias (clave, nombre, ubicacion) VALUES
  ("CADIZ_CENTRO", "Cádiz Centro", "Cádiz"),
  ("SAN_FERNANDO", "San Fernando", "San Fernando"),
  ("JEREZ", "Jerez", "Jerez de la Frontera"),
  ("PUERTO_REAL", "Puerto Real", "Puerto Real");

-- ============================================
-- USUARIOS - FRANQUICIAS
-- ============================================

INSERT INTO usuario_franquicia (usuario_id, franquicia_id) VALUES
  (2,1), (2,2), (2,3), (2,4),
  (3,1), (3,2),
  (4,3), (4,4),
  (5,1), (5,2),
  (6,3), (6,4),
  (7,1), (7,2),
  (8,2), (8,3),
  (9,3), (9,4),
  (10,4);

-- ============================================
-- RECLAMACIONES
-- Estados:
-- 1 BORRADOR
-- 2 PENDIENTE
-- 3 EN_TRAMITE
-- 4 RESUELTA
-- ============================================

INSERT INTO reclamaciones (
  usuario_creador_id,
  usuario_responsable_id,
  descripcion,
  tipo_id,
  prioridad_id,
  estado_id,
  franquicia_id,
  adjunto,
  nombre_apellidos,
  fecha_incidente,
  canal_entrada,
  solicitud_cliente,
  dni,
  direccion,
  codigo_postal,
  ciudad,
  provincia,
  observaciones_internas,
  informacion_seguimiento,
  telefono,
  email,
  importe,
  otros_datos
) VALUES
  (7, NULL, "Cliente comunica que el producto comprado no enciende después del primer uso.", 2, 2, 1, 1, "borrador_producto_no_enciende.pdf", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, "Borrador pendiente de completar.", NULL, NULL, NULL, NULL, NULL),

  (8, NULL, "Cliente informa de una posible incidencia en una devolución pendiente de revisar.", 1, 1, 1, 2, "borrador_devolucion_pendiente.pdf", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, "Borrador iniciado por empleado de tienda.", NULL, NULL, NULL, NULL, NULL),

  (9, NULL, "Cliente indica que desea registrar una reclamación por atención recibida en tienda.", 3, 2, 1, 3, "borrador_atencion_cliente.pdf", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, "Falta completar datos del reclamante.", NULL, NULL, NULL, NULL, NULL),

  (8, NULL, "Cliente indica que se le ha cobrado dos veces el mismo servicio.", 1, 3, 2, 2, "hoja_reclamacion_cobro_duplicado.pdf", "María López García", "2026-03-18", "Presencial", "Devolución", "45872136A", "Calle Real, 24", "11100", "San Fernando", "Cádiz", "El encargado verifica el justificante de pago.", "Pendiente de asignación.", "654123987", "maria.lopez.garcia@gmail.com", 79.90, "Aporta justificante bancario."),

  (10, NULL, "Cliente indica que el servicio contratado no se realizó en la fecha acordada.", 1, 2, 2, 4, "reclamacion_servicio_no_realizado.pdf", "Rafael Gómez Núñez", "2026-03-28", "Presencial", "Compensación", "28745196B", "Avenida de la Constitución, 5", "11510", "Puerto Real", "Cádiz", "Incidencia registrada por empleado.", "Pendiente de asignación.", "677412589", "rafael.gomez.nunez@gmail.com", 120.00, "Solicita compensación por retraso."),

  (7, NULL, "Cliente solicita información sobre una devolución no tramitada.", 1, 2, 2, 1, "solicitud_informacion_devolucion.pdf", "Francisco Javier Pérez Luna", "2026-03-21", "Teléfono", "Información", "65478932C", "Calle Rosario, 11", "11003", "Cádiz", "Cádiz", "Reclamación registrada tras llamada telefónica.", "Pendiente de revisión.", "622147895", "francisco.perez.luna@gmail.com", 35.00, "El cliente indica que entregó el producto en tienda."),

  (9, NULL, "Cliente reclama falta de respuesta a una incidencia comunicada por correo.", 3, 1, 2, 3, "reclamacion_sin_respuesta_previa.pdf", "Isabel Martín Serrano", "2026-02-15", "Email", "Información", "78965412D", "Plaza Mina, 3", "11402", "Jerez de la Frontera", "Cádiz", "Se localiza comunicación previa pendiente.", "Pendiente de asignación.", "644789123", "isabel.martin.serrano@gmail.com", NULL, "Existía una consulta anterior registrada por correo."),

  (9, 4, "Cliente reclama retraso en la reparación de un producto entregado en garantía.", 2, 2, 3, 3, "incidencia_garantia_reparacion.pdf", "José Manuel Ruiz Torres", "2026-03-10", "Email", "Reparación", "48963215E", "Avenida de Europa, 18", "11405", "Jerez de la Frontera", "Cádiz", "Reclamación validada por encargado.", "Se está esperando respuesta del servicio técnico.", "600458721", "jose.ruiz.torres@gmail.com", 149.50, "Producto dentro del periodo de garantía."),

  (9, 4, "Cliente comunica que recibió un producto distinto al solicitado.", 2, 3, 3, 3, "producto_distinto_solicitado.pdf", "Lucía Fernández Romero", "2026-03-25", "Email", "Devolución", "53698741F", "Calle Larga, 42", "11402", "Jerez de la Frontera", "Cádiz", "Pedido revisado en sistema.", "Se solicita comprobación a almacén.", "611258963", "lucia.fernandez.romero@gmail.com", 89.99, "Adjunta fotografía del producto recibido."),

  (7, 3, "Cliente reclama que el producto presenta daños visibles al abrir el embalaje.", 2, 3, 3, 1, "producto_danado_entrega.pdf", "Claudia Benítez Ramos", "2026-04-02", "Web", "Devolución", "32165498G", "Calle Ancha, 16", "11001", "Cádiz", "Cádiz", "Se revisan fotografías aportadas.", "Pendiente de confirmar reposición o devolución.", "699874512", "claudia.benitez.ramos@gmail.com", 64.95, "Daños comunicados el mismo día de la entrega."),

  (8, 3, "Cliente solicita revisión por diferencia entre el precio anunciado y el importe cobrado.", 1, 2, 3, 2, "diferencia_precio_ticket.pdf", "Manuel Prieto Vargas", "2026-04-04", "Presencial", "Devolución", "74125896H", "Calle San Rafael, 7", "11100", "San Fernando", "Cádiz", "Se adjunta ticket de compra.", "Responsable revisando promoción aplicada.", "655987412", "manuel.prieto.vargas@gmail.com", 12.50, "Reclama devolución de la diferencia."),

  (10, 4, "Cliente comunica incidencia por demora en la atención de una solicitud registrada en tienda.", 3, 1, 3, 4, "demora_atencion_solicitud.pdf", "Patricia Molina Suárez", "2026-04-06", "Teléfono", "Información", "96325874J", "Calle Nueva, 21", "11510", "Puerto Real", "Cádiz", "Solicitud localizada en registro interno.", "Se está revisando el motivo de la demora.", "688741236", "patricia.molina.suarez@gmail.com", NULL, "La clienta solicita información sobre el estado."),

  (7, 3, "Cliente informa de una atención incorrecta recibida en el establecimiento.", 3, 1, 4, 1, "reclamacion_atencion_cliente.pdf", "Ana Belén Castro Moreno", "2026-02-27", "Web", "Compensación", "75842136K", "Calle Columela, 8", "11004", "Cádiz", "Cádiz", "Se revisó la incidencia con el personal del turno.", "Reclamación resuelta con comunicación final al cliente.", "689741236", "ana.castro.moreno@gmail.com", NULL, "Cliente solicitaba disculpa formal y revisión interna."),

  (7, 3, "Cliente reclama que no ha recibido respuesta a una incidencia anterior.", 3, 2, 4, 1, "cierre_incidencia_previa.pdf", "Isabel Martín Serrano", "2026-02-15", "Web", "Información", "65478932C", "Plaza Mina, 3", "11004", "Cádiz", "Cádiz", "Se localizó una comunicación previa sin cerrar.", "Se informó al cliente y se cerró la incidencia.", "644789123", "isabel.martin.serrano@gmail.com", NULL, "Consulta previa registrada por correo."),

  (10, 4, "Cliente solicita compensación por cancelación de servicio sin aviso previo.", 1, 3, 4, 4, "compensacion_servicio_cancelado.pdf", "Alberto Romero Salas", "2026-03-05", "Presencial", "Compensación", "14785236L", "Avenida Andalucía, 30", "11510", "Puerto Real", "Cádiz", "Se comprobó la planificación del servicio.", "Reclamación cerrada tras acuerdo con el cliente.", "633214789", "alberto.romero.salas@gmail.com", 95.00, "Se ofreció compensación parcial.");

-- ============================================
-- ACCIONES DE RECLAMACIÓN
-- ============================================

INSERT INTO acciones_reclamacion (reclamacion_id, usuario_id, estado_id, comentario) VALUES
  (8, 6, 2, "El encargado valida la reclamación y comprueba los datos obligatorios."),
  (8, 4, 3, "El responsable asume la tramitación de la reclamación."),
  (8, 4, 3, "Se contacta con el servicio técnico para comprobar el estado de la reparación."),

  (9, 6, 2, "El encargado valida la reclamación y confirma que pertenece a la franquicia."),
  (9, 4, 3, "El responsable inicia la revisión con almacén."),
  (9, 4, 3, "Se solicita fotografía del producto recibido y comprobante de compra."),

  (10, 5, 2, "El encargado valida la documentación aportada por la clienta."),
  (10, 3, 3, "El responsable inicia la revisión de la incidencia."),
  (10, 3, 3, "Se solicita valoración para devolución o reposición del producto."),

  (11, 5, 2, "El encargado comprueba el ticket aportado por el cliente."),
  (11, 3, 3, "El responsable revisa la promoción aplicada en la fecha de compra."),
  (11, 3, 3, "Se solicita confirmación del importe correcto al departamento correspondiente."),

  (12, 6, 2, "El encargado valida los datos de la reclamación."),
  (12, 4, 3, "El responsable revisa el historial de atención registrado."),
  (12, 4, 3, "Se solicita información adicional al personal de la franquicia."),

  (13, 5, 2, "El encargado valida la información aportada por la clienta."),
  (13, 3, 3, "El responsable revisa la incidencia con el personal del establecimiento."),
  (13, 3, 3, "Se comunica al cliente que se han tomado medidas internas."),
  (13, 3, 4, "Reclamación resuelta tras informar a la clienta y registrar la actuación realizada."),

  (14, 5, 2, "El encargado comprueba que la reclamación contiene los datos obligatorios."),
  (14, 3, 3, "El responsable revisa el historial de comunicaciones previas."),
  (14, 3, 4, "Se informa al cliente del resultado de la revisión y se cierra la reclamación."),

  (15, 6, 2, "El encargado valida la reclamación y la documentación aportada."),
  (15, 4, 3, "El responsable comprueba la planificación del servicio cancelado."),
  (15, 4, 3, "Se contacta con el cliente para proponer una solución."),
  (15, 4, 4, "Reclamación resuelta tras acordar una compensación parcial con el cliente.");

