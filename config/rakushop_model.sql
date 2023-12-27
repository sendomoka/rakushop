DROP DATABASE IF EXISTS rakushop;
CREATE DATABASE rakushop;
USE rakushop;

CREATE TABLE IF NOT EXISTS banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255)
);
INSERT INTO banners VALUES (1, 'hsr.jpg');

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    role enum('owner', 'admin'),
    created_at DATETIME,
    updated_at DATETIME
);
INSERT INTO users VALUES (1, 'admin', 'admin@gmail.com', 'admin', 'admin', NOW(), NOW());

CREATE TABLE IF NOT EXISTS mitras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    country VARCHAR(255),
    created_at DATETIME,
    updated_at DATETIME
);
INSERT INTO mitras VALUES
(1, 'miHoYo', 'China',NOW(), NOW()),
(2, 'HyperGryph', 'China',NOW(), NOW()),
(3, 'Manjuu', 'China', NOW(), NOW()),
(4, 'Lippo Group', 'Indonesia', NOW(), NOW()),
(5, 'Sinarmas Multiartha', 'Indonesia', NOW(), NOW()),
(6, 'Telkomsel', 'Indonesia', NOW(), NOW()),
(7, 'Gojek', 'Indonesia', NOW(), NOW()),
(8, 'Bank Indonesia', 'Indonesia', NOW(), NOW());

CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mitra_id INT,
    name VARCHAR(255),
    cover VARCHAR(255),
    image VARCHAR(255),
    credit_name VARCHAR(255),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (mitra_id) REFERENCES mitras(id)
);
INSERT INTO games VALUES
(1, 1, 'Honkai: Star Rail', 'hsr-cover.jpg', 'hsr.jpg', 'Oneiric Shards', NOW(), NOW()),
(2, 1, 'Genshin Impact', 'genshin-cover.jpg', 'genshin.jpg', 'Genesis Crystals', NOW(), NOW()),
(3, 2, 'Arknights', 'arknights-cover.jpg', 'arknights.jpg', 'Originium', NOW(), NOW()),
(4, 3, 'Azur Lane', 'azur-cover.jpg', 'azur.jpg', 'Gems', NOW(), NOW()),
(5, 1, 'Honkai Impact 3rd', 'hi3-cover.jpg', 'hi3.jpg', 'Crystals', NOW(), NOW());

CREATE TABLE IF NOT EXISTS game_credits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    game_id INT,
    amount VARCHAR(255),
    price INT,
    FOREIGN KEY (game_id) REFERENCES games(id)
);
INSERT INTO game_credits VALUES
(1, 1, '60', 16000),
(2, 1, '300+30', 72000),
(3, 1, '980+110', 240000),
(4, 1, '1980+260', 450000),
(5, 1, '6480+1600', 1500000);

CREATE TABLE IF NOT EXISTS ewallets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mitra_id INT,
    name VARCHAR(255),
    image VARCHAR(255),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (mitra_id) REFERENCES mitras(id)
);
INSERT INTO ewallets VALUES
(1, 4, 'OVO', 'ovo.png', NOW(), NOW()),
(2, 5, 'DANA', 'dana.png', NOW(), NOW()),
(3, 6, 'LinkAja', 'linkaja.png', NOW(), NOW()),
(4, 7, 'GoPay', 'gopay.png', NOW(), NOW()),
(5, 8, 'QRIS', 'qris.png', NOW(), NOW());

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    game_id INT,
    game_credits_id INT,
    ewallet_id INT,
    userid VARCHAR(255),
    server enum('Asia', 'America', 'Europe', 'China'),
    email VARCHAR(255),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (game_id) REFERENCES games(id),
    FOREIGN KEY (game_credits_id) REFERENCES game_credits(id),
    FOREIGN KEY (ewallet_id) REFERENCES ewallets(id)
);
INSERT INTO orders VALUES
(1, 1, 1, 2, '808897256', 'Asia', 'bagus@gmail.com', NOW(), NOW());

CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    phone_number VARCHAR(255),
    status enum('pending', 'success', 'failed'),
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);
INSERT INTO transactions VALUES
(1, 1, '08123456789', 'success', NOW(), NOW());

CREATE TABLE IF NOT EXISTS faq (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255),
    answer TEXT
);
INSERT INTO faq VALUES
(1, 'Apa itu RakuShop?', 'RakuShop adalah sebuah website yang menyediakan layanan top up untuk game-game mobile.'),
(2, 'Apa saja game yang tersedia?', 'Saat ini, RakuShop menyediakan layanan top up untuk game Honkai Impact 3rd, Honkai: Star Rail, Genshin Impact, Arknights, dan Azur Lane.'),
(3, 'Apa saja metode pembayaran yang tersedia?', 'RakuShop menyediakan metode pembayaran melalui OVO, DANA, LinkAja, GoPay, dan QRIS.'),
(4, 'Bagaimana cara melakukan top up?', 'Pilih game yang ingin kamu top up, pilih jumlah kredit yang kamu inginkan, pilih metode pembayaran, lalu masukkan nomor telepon yang kamu gunakan untuk akun game kamu.'),
(5, 'Berapa lama waktu yang dibutuhkan untuk top up?', 'Top up akan diproses dalam waktu 1x24 jam.'),
(6, 'Apakah ada biaya tambahan?', 'Tidak ada biaya tambahan.'),
(7, 'Apakah ada refund?', 'Tidak ada refund.'),
(8, 'Apakah ada garansi?', 'Tidak ada garansi.'),
(9, 'Apakah ada batasan jumlah top up?', 'Tidak ada batasan jumlah top up.');