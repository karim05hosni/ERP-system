<?php 
include_once __DIR__."\..\database\config.php";
include_once __DIR__."\..\database\ops.php";


class cart extends config implements ops {
    private $product_id;
    private $user_id;
    private $quantity;

    // Setters
    public function setProductId($product_id) {
        $this->product_id = $product_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    // Getters
    public function getProductId() {
        return $this->product_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    // ---- END SETTERS & GETTERS ------

    public function creat(){

    }
    public function read(){

    }
    public function update(){

    }
    public function delete(){

    }
}