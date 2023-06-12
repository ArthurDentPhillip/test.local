<?php

include_once("classes.php");

$cat = $_POST["cat"];
$pdo = Tools::connect();

var_dump($cat);

$products = Product::getProducts($cat);

if ($products == null) exit();

foreach($products as $prod) {
    $prod->draw();
}
