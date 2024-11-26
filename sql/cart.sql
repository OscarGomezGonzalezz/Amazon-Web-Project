DROP TABLE IF EXISTS Cart;

CREATE TABLE Cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,    
    user_id INT NOT NULL,        
    article_id INT NOT NULL,                 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    quantity INT NOT NULL,
    FOREIGN KEY (article_id) REFERENCES articles(article_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)        
);
