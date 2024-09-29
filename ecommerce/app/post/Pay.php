<?php 
session_start();
include __DIR__."\\..\\sevices\\Payment.php";
include __DIR__."\\..\\models\\product.php";


if($_POST){
    $pay = new payment();
    $product = new product();
    $product->setid($_POST['product_id']);
    $product_details = $product->read()->fetch_object();
    $_SESSION['product']=[
        'id'=>$_POST['product_id'],
        'quantity'=>$_POST['quantity']
    ];
    $pay->checkout([
        'name'=>$product_details->name_en,
        'price'=>$product_details->price,
        'quantity'=>$_POST['quantity']
    ]);
}