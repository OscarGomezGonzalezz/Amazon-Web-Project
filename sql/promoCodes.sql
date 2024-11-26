DROP TABLE IF EXISTS PromoCodes;

CREATE TABLE PromoCodes (
    code_id INT AUTO_INCREMENT PRIMARY KEY,       
    code_name VARCHAR(50) NOT NULL,
    discount_amount INT NOT NULL,
    is_active INT NOT NULL DEFAULT 0
);

insert into PromoCodes(code_name, discount_amount) values('10BLACKFRIDAY', 10);