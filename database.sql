-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS notes_app;

-- Usar la base de datos
USE notes_app;

-- Crear la tabla 'notes'
CREATE TABLE IF NOT EXISTS notes (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    body TEXT,
    classification VARCHAR(50) DEFAULT 'personal'
);

-- Insertar 3 registros de ejemplo
INSERT INTO notes (title, author, body, classification) VALUES
('Reunión de proyecto', 'Juan Pérez', 'Discutir los avances del sprint 3 y planificar las siguientes tareas. La reunión será a las 10 AM en la sala de juntas.', 'work'),
('Lista de compras', 'Ana Gómez', 'Leche, huevos, pan integral, y aguacates.', 'personal'),
('Ideas para vacaciones', 'Juan Pérez', 'Posibles destinos: Costa Rica, Italia o Japón. Investigar costos de vuelos y alojamiento.', 'personal');
