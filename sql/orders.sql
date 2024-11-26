DROP TABLE IF EXISTS Orders;

CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) NOT NULL,
    cart_id INT NOT NULL,
    shipping ENUM('DPD', 'DHL', 'DHL Express') NOT NULL,
    total_amount FLOAT NOT NULL,   
    FOREIGN KEY (cart_id) REFERENCES Cart(cart_id)
);