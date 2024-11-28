ALTER DATABASE amazondb CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;


DROP TABLE IF EXISTS Orders;
CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único para cada pedido
    user_id INT NOT NULL,                    -- Identificador del usuario que realiza el pedido
    first_name VARCHAR(50) NOT NULL,         -- Nombre del cliente
    last_name VARCHAR(50) NOT NULL,          -- Apellido del cliente
    email VARCHAR(100) NOT NULL,             -- Correo del cliente
    address TEXT NOT NULL,                   -- Dirección de envío
    shipping_method VARCHAR(50) NOT NULL,    -- Método de envío elegido
    total_price DECIMAL(10, 2) NOT NULL,     -- Precio total del pedido
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha de creación del pedido
    FOREIGN KEY (user_id) REFERENCES Users(user_id) -- Relación con la tabla Users
);