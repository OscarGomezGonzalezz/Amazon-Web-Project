DROP TABLE IF EXISTS Articles;

CREATE OR REPLACE TABLE Articles (
    article_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price FLOAT NOT NULL,
    quantity INT NOT NULL,
    image_url VARCHAR(255) NOT NULL
);

INSERT INTO Articles (name, price, quantity, image_url) VALUES
('Küchenmaschine', 49.99, 100, './images/articles/küchemaschine.jpeg'),
('Fire TV Stick 4K', 59.99, 150, './images/articles/fire_tv_stick.jpeg'),
('Kindle Paperwhite', 129.99, 80, './images/articles/kindle_paperwhite.jpeg'),
('Ring Video Doorbell', 99.99, 120, './images/articles/ring_video_doorbell.jpeg'),
('Instant Pot Duo 7-in-1', 89.99, 75, './images/articles/instant_pot.jpeg'),
('Echo Show 5', 84.99, 90, './images/articles/echo_show_5.jpeg'),
('Fire HD 10 Tablet', 149.99, 60, './images/articles/fire_hd_10.jpeg'),
('AmazonBasics AA Batteries', 12.99, 200, './images/articles/amazon_basics_batteries.jpeg'),
('Chalkboard Labels (Set of 48)', 10.99, 300, './images/articles/chalkboard_labels.jpeg'),
('Wireless Charging Pad', 29.99, 110, './images/articles/wireless_charger.jpeg'),
('Anker PowerCore Portable Charger', 39.99, 150, './images/articles/powercore.jpeg'),
('Smart Wi-Fi Plug', 24.99, 130, './images/articles/smart_plug.jpeg'),
('Beats Solo3 Wireless On-Ear Headphones', 199.99, 50, './images/articles/beats_headphones.jpeg'),
('Jabra Elite 75t Wireless Earbuds', 149.99, 70, './images/articles/jabra_earbuds.jpeg'),
('Fitbit Charge 4', 149.95, 65, './images/articles/fitbit_charge_4.jpeg');
