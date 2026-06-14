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
  DROP TABLE IF EXISTS prioridades;

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
    descripcion VARCHAR(100) NOT NULL,
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
-- TABLA: prioridades
-- ============================================
  CREATE TABLE prioridades (
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
    tipo_id INT NOT NULL,
    prioridad_id INT NOT NULL,
    estado_id INT NOT NULL,
    franquicia_id INT NOT NULL,

    adjunto VARCHAR(255) NOT NULL,

    nombre_apellidos VARCHAR(150),
    fecha_incidente DATE,
    canal_entrada VARCHAR(50),
    solicitud_cliente VARCHAR(50),
    dni VARCHAR(20),
    direccion VARCHAR(255),
    codigo_postal VARCHAR(20),
    ciudad VARCHAR(100),
    provincia VARCHAR(100),
    observaciones_internas TEXT,
    informacion_seguimiento TEXT,

    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP NULL DEFAULT NULL,

    telefono VARCHAR(20),
    email VARCHAR(100),
    importe DECIMAL(10,2),
    otros_datos TEXT,

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

  -- Prioridades básicas
    INSERT INTO prioridades (clave, nombre) VALUES
      ("BAJA", "Baja"),
      ("MEDIA", "Media"),
      ("ALTA", "Alta")
    ;