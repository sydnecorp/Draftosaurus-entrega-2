-- Crear base de datos
CREATE DATABASE IF NOT EXISTS draftosaurus;
USE draftosaurus;

-- Tabla usuarios
CREATE TABLE usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL
);

-- Tabla partidas
CREATE TABLE partidas (
    partida_id INT AUTO_INCREMENT PRIMARY KEY,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cantidad_jugadores INT NOT NULL,
    estado VARCHAR(20) DEFAULT 'en curso'
);

-- Tabla jugadores
CREATE TABLE jugadores (
    partida_id INT NOT NULL,
    usuario_id INT NOT NULL,
    puntos_totales INT DEFAULT 0,
    PRIMARY KEY (partida_id, usuario_id),
    FOREIGN KEY (partida_id) REFERENCES partidas(partida_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id)
);

-- Tabla recintos
CREATE TABLE recintos (
    nombre VARCHAR(50) PRIMARY KEY,
    zona VARCHAR(20),
    lado VARCHAR(10),
    puntos_base INT DEFAULT 0
);

-- Tabla dinosaurios
CREATE TABLE dinosaurios (
    nombre VARCHAR(50) PRIMARY KEY,
    color VARCHAR(20) NOT NULL,
    puntos INT DEFAULT 0
);

-- Tabla jugadas
CREATE TABLE jugadas (
    jugada_id INT AUTO_INCREMENT PRIMARY KEY,
    partida_id INT NOT NULL,
    usuario_id INT NOT NULL,
    recinto_nombre VARCHAR(50) NOT NULL,
    dino_nombre VARCHAR(50) NOT NULL,
    turno INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (partida_id) REFERENCES partidas(partida_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id),
    FOREIGN KEY (recinto_nombre) REFERENCES recintos(nombre),
    FOREIGN KEY (dino_nombre) REFERENCES dinosaurios(nombre)
);

-- Tabla manos (dinos en mano de cada jugador)
CREATE TABLE manos (
    partida_id INT NOT NULL,
    usuario_id INT NOT NULL,
    dino_nombre VARCHAR(50) NOT NULL,
    PRIMARY KEY (partida_id, usuario_id, dino_nombre),
    FOREIGN KEY (partida_id) REFERENCES partidas(partida_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id),
    FOREIGN KEY (dino_nombre) REFERENCES dinosaurios(nombre)
);

-- Insertar dinosaurios iniciales
INSERT INTO dinosaurios (nombre, color, puntos) VALUES
('T-Rex', 'rojo', 1),
('Triceratops', 'verde', 0),
('Velociraptor', 'naranja', 0),
('Parasaurio', 'amarillo', 0),
('Diplodocus', 'azul', 0),
('Estegosaurio', 'rosa', 0);

-- Insertar recintos iniciales
INSERT INTO recintos (nombre, zona, lado, puntos_base) VALUES
('Bosque Izq 1', 'bosque', 'izq', 2),
('Bosque Izq 2', 'bosque', 'izq', 2),
('Roca Izq', 'roca', 'izq', 2),
('Bosque Der T-Rex', 'bosque', 'der', 5),
('Roca Der 1', 'roca', 'der', 2),
('Roca Der 2', 'roca', 'der', 2),
('Rio', 'rio', 'centro', 0);
