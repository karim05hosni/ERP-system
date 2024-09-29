<?php 
include_once __DIR__."\..\database\config.php";
include_once __DIR__."\..\database\ops.php";
class SubCategory extends config implements ops {

    private $id;
    private $name_en;
    private $status;
    private $category_id;
    private $created_at;
    private $updated_at;
    private $image;
    private $query;

    

    public function creat(){

    }
    public function read(){
        $query = "SELECT name_en, id FROM subcategories WHERE category_id = $this->id";
        return $this->runDQL($query);
    }
    public function update(){

    }
    public function delete(){

    }

    public function setid($id){
        $this->id = $id;
    }
    public function setquery($query){
        $this->query = $query;
    }
    
}