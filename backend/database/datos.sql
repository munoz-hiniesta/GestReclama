
INSERT INTO usuarios (nombre, email, password, rol_Id)
       VALUES
      ("nombre_001",
      "email_001@gestreclama.com",
      "$2y$10$DJAMSFPlG9ahlHfMAGEzCeXKkluXA3gaNtLjCqj90W0AKLYXGeePe", 
      1);

INSERT INTO franquicias (nombre, ubicacion)
       VALUES ("franquicia_001", "ubicacion franquicia_001");

INSERT INTO reclamaciones (usuario_creador_id, usuario_responsable_id, descripcion)
       VALUES (1, 1, "descripción reclamación 001");