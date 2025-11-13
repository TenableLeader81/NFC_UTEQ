

-- base de datos
CREATE DATABASE IF NOT EXISTS asistencia_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE asistencia_db;

-- Tabla de Roles
CREATE TABLE roles (
  id_rol INT AUTO_INCREMENT PRIMARY KEY,
  nombre_rol VARCHAR(50) NOT NULL
);

INSERT INTO roles (nombre_rol) VALUES 
('Direccion'),
('Maestro');

-- Tabla de Usuarios 
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(100) UNIQUE,
  contrasena VARCHAR(255),
  id_rol INT,
  FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

INSERT INTO usuarios (nombre, correo, contrasena, id_rol) VALUES
('Admin Direccion', 'admin@uteq.edu.mx', '12345', 1),
('Jesus', 'jesus@uteq.edu.mx', '12345', 2),
('fredy', 'fredy@uteq.edu.mx', '12345', 2);

-- Tabla de Salones (cada uno asociado a un ESP32)
CREATE TABLE salones (
  id_salon INT AUTO_INCREMENT PRIMARY KEY,
  nombre_salon VARCHAR(50) NOT NULL,
  id_esp32 VARCHAR(50) NOT NULL UNIQUE,  -- Identificador físico del dispositivo ESP32
  ubicacion VARCHAR(100)
);

INSERT INTO salones (nombre_salon, id_esp32, ubicacion) VALUES
('K11', '001', 'Edificio K'),
('K12', '002', 'Edificio K');


-- Tabla de Alumnos (UID en formato hexadecimal limpio)
CREATE TABLE alumnos (
  id_alumno INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  ApellidoP VARCHAR(100) NOT NULL,
  ApellidoM VARCHAR(100) NOT NULL,
  matricula VARCHAR(50) UNIQUE,
  uid_nfc VARCHAR(50) UNIQUE  -- UID de la tarjeta NFC, ejemplo: 9F244C68
);

INSERT INTO alumnos (nombre,ApellidoP,ApellidoM, matricula, uid_nfc) VALUES
('Edgar','Cuervo','Fajardo', '2020171001', '0x9F 0x24 0x4C 0x68');
UPDATE alumnos
SET uid_nfc = '9F244C68'
WHERE matricula = '2020171001';
select * from alumnos;


-- Tabla de Asistencias (registros automáticos por ESP32)
CREATE TABLE asistencias (
  id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
  id_alumno INT,
  id_salon INT,
  fecha DATE DEFAULT (CURRENT_DATE),
  hora TIME DEFAULT (CURRENT_TIME),
  estado ENUM('puntual','retardo','falta') DEFAULT 'puntual',
  FOREIGN KEY (id_alumno) REFERENCES alumnos(id_alumno),
  FOREIGN KEY (id_salon) REFERENCES salones(id_salon)
);

show tables;
select * from asistencias;
select * from roles;
select * from usuarios;



INSERT INTO alumnos (id_alumno, nombre, ApellidoP, ApellidoM, matricula, uid_nfc) VALUES
(2, 'Miguel', 'Cruz', 'May', '2020171002', '8A15B2C4'),
(3, 'Fernando', 'Gonzalez', 'Cristino', '2020171003', 'AB1234F9'),
(4, 'Arisai', 'Luna', 'Perez', '2020171004', 'CD1298E7'),
(5, 'Sofia', 'Lopez', 'Martinez', '2020171005', 'EF1284B2');



INSERT INTO asistencias (id_asistencia, id_alumno, id_salon, fecha, hora, estado) VALUES
(2, 2, 1, '2025-11-12', '17:30:00', 'retardo'),
(3, 3, 1, '2025-11-12', '17:45:00', 'puntual'),
(4, 4, 1, '2025-11-12', '18:10:00', 'falta'),
(5, 5, 1, '2025-11-12', '18:20:00', 'puntual'),

(6, 1, 2, '2025-11-12', '19:05:00', 'retardo'),
(7, 2, 2, '2025-11-12', '19:30:00', 'puntual'),
(8, 3, 2, '2025-11-12', '20:15:00', 'puntual'),
(9, 4, 2, '2025-11-12', '20:25:00', 'falta'),
(10, 5, 2, '2025-11-12', '20:50:00', 'retardo');

select * from alumnos;
ALTER TABLE alumnos ADD COLUMN estatus ENUM('activo', 'inactivo') DEFAULT 'activo';
UPDATE alumnos SET estatus = 'activo';



