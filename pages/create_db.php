<?php
include_once("classes.php");

$pdo = Tools::connect();

$roles = "CREATE TABLE roles(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(50) NOT NULL UNIQUE
) DEFAULT CHARSET='utf8'";

$users = "CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    pass VARCHAR(120) NOT NULL,
    role_id INT,
    FOREIGN KEY(role_id) REFERENCES roles(id) ON DELETE CASCADE,
    discount INT,
    total INT,
    image_path VARCHAR(100)
) DEFAULT CHARSET='utf8'";

$category = "CREATE TABLE categories(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(100) NOT NULL UNIQUE
) DEFAULT CHARSET='utf8'";

$subCategory = "CREATE TABLE sub_category(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sub_category VARCHAR(100) NOT NULL UNIQUE,
    category_id INT,
    FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE CASCADE
) DEFAULT CHARSET='utf8'";

$products = "CREATE TABLE products(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INT,
    FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE CASCADE,
    price FLOAT NOT NULL,
    sale_price FLOAT,
    info TEXT,
    rate FLOAT,
    image_path VARCHAR(100),
    qty INT DEFAULT(0)
) DEFAULT CHARSET='utf8'";

$images = "CREATE TABLE images(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE,
    image_path VARCHAR(100)
) DEFAULT CHARSET='utf8'";

$sales = "CREATE TABLE sales(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100),
    product_id INT,
    FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE,
    price FLOAT NOT NULL,
    sale_price FLOAT,
    date DATE
) DEFAULT CHARSET='utf8'";

$pdo->exec($roles);
$pdo->exec($users);
$pdo->exec($category);
$pdo->exec($subCategory);
$pdo->exec($products);
$pdo->exec($images);
$pdo->exec($sales);