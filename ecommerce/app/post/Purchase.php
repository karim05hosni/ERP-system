<?php
session_start();
// use function PHPSTORM_META\type;
include __DIR__ . "\\..\\requests\\validation.php";
include __DIR__ . "\\..\\models\\sales.php";
include __DIR__ . "\\..\\models\\product.php";

// Add sales record into DB
$product = new product();
$product->setid($_SESSION['product']['id']);
$product_details = $product->read()->fetch_object();
$sale = new sales();
$sale->setProductId($product_details->id);
$sale->setPricePerUnit($product_details->price);
$sale->setQuantity($_GET['qty']);
$sale->setTotalPrice(($product_details->price) * $_GET['qty']);
$sale->setSaleDate(date('Y-m-d'));
$sale->setCostPerUnit($product_details->cost_per_unit);
$sale->creat();
// set quantity value
$product->set_quantity($product_details->quantity - $_GET['qty']);
// update quantity value
$product->update_qty();
header('location:../../shop.php?s=1');
