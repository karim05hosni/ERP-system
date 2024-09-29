<?php
include_once __DIR__."\..\database\config.php";
include_once __DIR__."\..\database\ops.php";
class sales extends config implements ops{
    private $id;
    private $product_id;
    private $quantity;
    private $price_per_unit;
    private $sale_date;
    private $total_price;
    private $cost_per_unit;

    // Getters
     // Getters
     public function getId(){
        return $this->id;
    }
    
    public function getProductId(){
        return $this->product_id;
    }
    
    public function getQuantity(){
        return $this->quantity;
    }
    
    public function getPricePerUnit(){
        return $this->price_per_unit;
    }
    
    public function getSaleDate(){
        return $this->sale_date;
    }
    
    public function getTotalPrice(){
        return $this->total_price;
    }

    // Setters
    public function setId($id){
        $this->id = $id;
    }
    
    public function setProductId($product_id){
        $this->product_id = $product_id;
    }
    
    public function setQuantity($quantity){
        $this->quantity = $quantity;
    }
    
    public function setPricePerUnit($price_per_unit){
        $this->price_per_unit = $price_per_unit;
    }
    
    public function setSaleDate($sale_date){
        $this->sale_date = $sale_date;
    }
    
    public function setTotalPrice($total_price){
        $this->total_price = $total_price;
    }
    public function setCostPerUnit($cost_per_unit){
        $this->cost_per_unit = $cost_per_unit;
    }

    public function creat(){
        // Add sale
        // query
        $query = "INSERT INTO sales(product_id,quantity,price_per_unit,sale_date,total_price,cost_per_unit) VALUES('$this->product_id','$this->quantity','$this->price_per_unit','$this->sale_date','$this->total_price','$this->cost_per_unit')";
        return $this->runDML($query);
    }
    public function read(){

    }
    public function update(){

    }
    public function delete(){
    }
}