-- Crear la tabla LoginLogs
CREATE OR REPLACE TABLE LoginLogs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,      -- Identificador único para cada registro
    user_id INT NOT NULL,                       -- ID del usuario (clave foránea)
    login_time DATETIME DEFAULT CURRENT_TIMESTAMP, -- Fecha y hora del inicio de sesión
    screen_resolution VARCHAR(50),             -- Resolución de pantalla del usuario
    os VARCHAR(100)                            -- Sistema operativo del usuario
);

-- Agregar la relación con la tabla users
ALTER TABLE LoginLogs
ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(user_id)
ON DELETE CASCADE; -- Elimina registros de LoginLogs si el usuario correspondiente es eliminado.
