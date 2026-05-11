-- ============================================
-- SCHEMA: GestReclama
-- ============================================

  -- eliminar tablas en orden seguro
  DROP TABLE IF EXISTS acciones_reclamacion;
  DROP TABLE IF EXISTS reclamaciones;
  DROP TABLE IF EXISTS usuario_franquicia;
  DROP TABLE IF EXISTS usuarios;
  DROP TABLE IF EXISTS franquicias;
  DROP TABLE IF EXISTS estados;
  DROP TABLE IF EXISTS roles;
  DROP TABLE IF EXISTS tipos;

-- ============================================
-- TABLA: roles
-- ============================================
  CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    activo BOOLEAN DEFAULT TRUE
  ) ENGINE=InnoDB;

-- ============================================
-- TABLA: estados
-- ============================================
  CREATE TABLE estados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(100) NOT NULL DEFAULT "Aún no registrada definitivamente",
    activo BOOLEAN DEFAULT TRUE
  ) ENGINE=InnoDB;

-- ============================================
-- TABLA: franquicias
-- ============================================
  CREATE TABLE franquicias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(150) NOT NULL,
    activo BOOLEAN DEFAULT TRUE
  ) ENGINE=InnoDB;

-- ============================================
-- TABLA: tipos
-- ============================================
  CREATE TABLE tipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    activo BOOLEAN DEFAULT TRUE
  ) ENGINE=InnoDB;

-- ============================================
-- TABLA: usuarios
-- ============================================
  CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_email (email),

    FOREIGN KEY (rol_id)
      REFERENCES roles(id)
      ON DELETE RESTRICT
  ) ENGINE=InnoDB;

-- ============================================
-- TABLA: usuario_franquicia (N:M)
-- ============================================
  CREATE TABLE usuario_franquicia (
    usuario_id INT NOT NULL,
    franquicia_id INT NOT NULL,

    PRIMARY KEY (usuario_id, franquicia_id),

    FOREIGN KEY (usuario_id)
      REFERENCES usuarios(id)
      ON DELETE CASCADE,

    FOREIGN KEY (franquicia_id)
      REFERENCES franquicias(id)
      ON DELETE CASCADE
  ) ENGINE=InnoDB;

-- ============================================
-- TABLA: reclamaciones
-- ============================================
  CREATE TABLE reclamaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_creador_id INT NOT NULL,
    usuario_responsable_id INT DEFAULT NULL,

    descripcion TEXT NOT NULL,
    
    tipo_id INT NOT NULL DEFAULT 1,
    estado_id INT NOT NULL DEFAULT 1,
    franquicia_id INT NOT NULL DEFAULT 1,

    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP NULL DEFAULT NULL,

    FOREIGN KEY (usuario_creador_id)
      REFERENCES usuarios(id)
      ON DELETE RESTRICT,

    FOREIGN KEY (tipo_id)
      REFERENCES tipos(id)
      ON DELETE RESTRICT,

    FOREIGN KEY (usuario_responsable_id)
      REFERENCES usuarios(id)
      ON DELETE SET NULL,

    FOREIGN KEY (estado_id)
      REFERENCES estados(id)
      ON DELETE RESTRICT,

    FOREIGN KEY (franquicia_id)
      REFERENCES franquicias(id)
      ON DELETE RESTRICT,

    INDEX idx_recl_estado (estado_id),
    INDEX idx_recl_franquicia (franquicia_id),
    INDEX idx_recl_responsable (usuario_responsable_id),
    INDEX idx_recl_creador (usuario_creador_id),
    INDEX idx_recl_tipo (tipo_id)
  ) ENGINE=InnoDB;

-- ============================================
-- TABLA: acciones_reclamacion
-- ============================================
  CREATE TABLE acciones_reclamacion (
    id INT AUTO_INCREMENT PRIMARY KEY,

    reclamacion_id INT NOT NULL,
    usuario_id INT NOT NULL,
    estado_id INT NOT NULL,

    comentario TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (reclamacion_id)
      REFERENCES reclamaciones(id)
      ON DELETE CASCADE,

    FOREIGN KEY (usuario_id)
      REFERENCES usuarios(id)
      ON DELETE RESTRICT,

    FOREIGN KEY (estado_id)
      REFERENCES estados(id)
      ON DELETE RESTRICT
  ) ENGINE=InnoDB;

-- ============================================
-- DATOS INICIALES
-- ============================================

  -- Roles básicos
    INSERT INTO roles (clave, nombre) VALUES
      ("ADMINISTRADOR", "Administrador"),
      ("RESPONSABLE_GENERAL", "Responsable General"),
      ("RESPONSABLE_TRAMITACION", "Responsable Tramitación"),
      ("ENCARGADO", "Encargado"),
      ("EMPLEADO", "Empleado")
    ;

  -- Estados básicos
    INSERT INTO estados (clave, nombre, descripcion) VALUES
      ("BORRADOR", "Borrador", "Aún no registrada definitivamente"),
      ("PENDIENTE", "Pendiente", "Registrada pero sin gestión activa"),
      ("EN_TRAMITE", "En trámite", "Asignada o siendo gestionada"),
      ("RESUELTA", "Resuelta", "Proceso finalizado")
    ;

  -- Tipos básicos
    INSERT INTO tipos (clave, nombre) VALUES
      ("SERVICIO", "Servicio"),
      ("PRODUCTO", "Producto"),
      ("ATENCION_AL_CLIENTE", "Atención al cliente")
    ;

  -- Usuarios básicos
    INSERT INTO usuarios (nombre, email, password, rol_Id) VALUES
      ("nombre_001", "email_001@gestreclama.com", "$2y$10$DJAMSFPlG9ahlHfMAGEzCeXKkluXA3gaNtLjCqj90W0AKLYXGeePe", 1),
      ("nombre_002", "email_002@gestreclama.com", "$2y$10$Rqji33gzVVRocPUrgC1EROaJLLBgbzkMtVu.JpuAfsDNkicG3/YmW", 2),
      ("nombre_003", "email_003@gestreclama.com", "$2y$10$qB3XivQs7U37.tCPMRLel.Q3G27tT8/P3J0XoIJn3Rev.LeeLbxFW", 3)
    ;

  -- Franquicias básicas
    INSERT INTO franquicias (clave, nombre, ubicacion) VALUES 
      ("FRANQUICIA_001", "franquicia_001", "ubicacion franquicia_001"),
      ("FRANQUICIA_002", "franquicia_002", "ubicacion franquicia_002"),
      ("FRANQUICIA_003", "franquicia_003", "ubicacion franquicia_003")
    ;

  
  -- Reclamaciones básicas
    INSERT INTO reclamaciones (usuario_creador_id, usuario_responsable_id, descripcion) VALUES
      (1, 1, "descripción reclamación 001"),
      (1, 2, "descripción reclamación 002"),
      (2, 3, "descripción reclamación 003")
    ;