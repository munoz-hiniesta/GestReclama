-- Usuarios básicos
  INSERT INTO usuarios (nombre, email, password, rol_Id) VALUES
    ("nombre_001", "email_001@gestreclama.com", "$2y$10$DJAMSFPlG9ahlHfMAGEzCeXKkluXA3gaNtLjCqj90W0AKLYXGeePe", 1),
    ("nombre_002", "email_002@gestreclama.com", "$2y$10$Rqji33gzVVRocPUrgC1EROaJLLBgbzkMtVu.JpuAfsDNkicG3/YmW", 2),
    ("nombre_003", "email_003@gestreclama.com", "$2y$10$qB3XivQs7U37.tCPMRLel.Q3G27tT8/P3J0XoIJn3Rev.LeeLbxFW", 3), 
    ("nombre_004", "email_004@gestreclama.com", "$2y$10$QER7CY06gl8b.DiYdspSYOWy.JJ0ng5dYUGa4IHDDbq/ATkwM3lMy", 4),
    ("nombre_005", "email_005@gestreclama.com", "$2y$10$a3nOYe7UUyosYuwhiYgc1e8IEs6.bZKU1AN09m0frSudazQBCo1GC", 5)
  ;

-- Franquicias básicas
  INSERT INTO franquicias (clave, nombre, ubicacion) VALUES 
    ("FRANQUICIA_001", "franquicia_001", "ubicacion franquicia_001"),
    ("FRANQUICIA_002", "franquicia_002", "ubicacion franquicia_002"),
    ("FRANQUICIA_003", "franquicia_003", "ubicacion franquicia_003")
  ;

-- Usuarios - franquicias
    INSERT INTO usuario_franquicia (usuario_id, franquicia_id) VALUES
      (1,1),
      (2,1),
      (3,1),
      (4,1),
      (5,1)
    ;

-- Reclamaciones básicas
  INSERT INTO reclamaciones (usuario_creador_id, usuario_responsable_id, descripcion, tipo_id, prioridad_id, estado_id, franquicia_id, adjunto) VALUES
    (5, NULL, "descripción reclamación 001 - borrador", 1, 2, 1, 1, "Adjunto_001"),
    (5, NULL, "descripción reclamación 002 - pendiente", 2, 3, 2, 1, "Adjunto_002"),
    (5, 3, "descripción reclamación 003 - en trámite", 1, 2, 3, 1, "Adjunto_003"),
    (5, 3, "descripción reclamación 004 - resuelta", 3, 1, 4, 1, "Adjunto_004")
  ;

-- Acciones de reclamación básicas
  INSERT INTO acciones_reclamacion (reclamacion_id, usuario_id, estado_id, comentario) VALUES
    (3, 3, 3, "Inicio de la tramitación de la reclamación"),
    (3, 3, 3, "Solicitud de información adicional al encargado"),
    (4, 3, 3, "Inicio de la tramitación de la reclamación"),
    (4, 3, 4, "Reclamación analizada y resuelta")
  ;