DROP TABLE IF EXISTS OrderItems;

CREATE TABLE OrderItems (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,  -- Identificador único para cada artículo del pedido
    order_id INT NOT NULL,                   -- Identificador del pedido al que pertenece el artículo
    article_name VARCHAR(255) NOT NULL,      -- Nombre del producto
    quantity INT NOT NULL,                   -- Cantidad del producto en el pedido
    price DECIMAL(10, 2) NOT NULL,           -- Precio por unidad del producto
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) -- Relación con la tabla Orders
);
