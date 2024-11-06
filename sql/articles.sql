DROP TABLE IF EXISTS Articles;

CREATE TABLE Articles (
    article_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price FLOAT NOT NULL,
    quantity INT NOT NULL,
    image_url VARCHAR(255) NOT NULL
);

INSERT INTO Articles (name, price, quantity, image_url) VALUES
('Küchenmaschine', 49.99, 100, 'https://example.com/images/echo_dot.jpg'),
('Fire TV Stick 4K', 59.99, 150, 'https://example.com/images/fire_tv_stick.jpg'),
('Kindle Paperwhite', 129.99, 80, 'https://example.com/images/kindle_paperwhite.jpg'),
('Ring Video Doorbell', 99.99, 120, 'https://example.com/images/ring_doorbell.jpg'),
('Instant Pot Duo 7-in-1', 89.99, 75, 'https://example.com/images/instant_pot.jpg'),
('Echo Show 5', 84.99, 90, 'https://example.com/images/echo_show_5.jpg'),
('Fire HD 10 Tablet', 149.99, 60, 'https://example.com/images/fire_hd_10.jpg'),
('AmazonBasics AA Batteries', 12.99, 200, 'https://example.com/images/amazon_basics_batteries.jpg'),
('Chalkboard Labels (Set of 48)', 10.99, 300, 'https://example.com/images/chalkboard_labels.jpg'),
('Wireless Charging Pad', 29.99, 110, 'https://example.com/images/wireless_charger.jpg'),
('Anker PowerCore Portable Charger', 39.99, 150, 'https://example.com/images/powercore.jpg'),
('Smart Wi-Fi Plug', 24.99, 130, 'https://example.com/images/smart_plug.jpg'),
('Beats Solo3 Wireless On-Ear Headphones', 199.99, 50, 'https://example.com/images/beats_headphones.jpg'),
('Jabra Elite 75t Wireless Earbuds', 149.99, 70, 'https://example.com/images/jabra_earbuds.jpg'),
('Fitbit Charge 4', 149.95, 65, 'https://example.com/images/fitbit_charge_4.jpg');
