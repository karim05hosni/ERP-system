<?php 
include_once __DIR__."\..\database\config.php";
include_once __DIR__."\..\database\ops.php";
class product extends config implements ops {

    private $id;
    public $name_en;
    private $status;
    private $subcategory_id;

    private $brand_id;
    private $quantity;
    private $created_at;
    private $updated_at;
    private $image;
    private $cost_per_unit;

    public function creat(){

    }
    public function read(){
        $subid = NULL;
        if (!empty($this->subcategory_id)){
            $subid = "AND subcate_id = '$this->subcategory_id'";
        }
        $pid = NULL;
        if(!empty($this->id)){
            $pid = "AND id = '$this->id'";
        }
        $brand_id= NULL;
        if(!empty($this->brand_id)){
            $brand_id = "AND brand_id = '$this->brand_id'";
        }
        $query = "SELECT name_en, price, image, id, quantity,subcate_id,brand_id,cost_per_unit FROM products WHERE status = 1 $subid $pid $brand_id  ORDER BY price DESC, quantity DESC, name_en ASC";
        return $this->runDQL($query);
    }
    public function update(){
        $query="UPDATE `products` SET `image`='$this->image' WHERE name_en = '$this->name_en'";
        return $this->runDML($query);
    }
    public function update_qty(){
        $query = "UPDATE `products` SET `quantity`='$this->quantity' WHERE id = '$this->id'";
        return $this->runDML($query);
    }
    
    public function delete(){

    }
    public function setid($id){
        $this->id = $id;
    }
    public function setimage($image){
        $this->image = $image;
    }
    public function getimage(){
        return $this->image;
    }
    public function set_sub_cate_id($subcate_id){
        $this->subcategory_id = $subcate_id;
    }
    public function getrelated(){
        $query = "SELECT image,name_en,price FROM products WHERE subcate_id='$this->subcategory_id'";
        return $this->runDQL($query);
    }

    public function get_brand_id() {
        return $this->brand_id;
    }
    public function set_brand_id($brand_id){
        $this->brand_id = $brand_id;
    }
    public function set_quantity($quantity){
        $this->quantity = $quantity;
    }
}