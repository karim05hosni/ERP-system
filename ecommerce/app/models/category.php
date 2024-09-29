<?php 
include_once __DIR__."\..\database\config.php";
include_once __DIR__."\..\database\ops.php";
class Category extends config implements ops {

    private $id;
    private $name_en;
    private $status;
    private $created_at;
    private $updated_at;
    private $image;

    public function creat(){

    }
    public function read(){
        $query = "SELECT * FROM category WHERE status = 1";
        return $this->runDQL($query);
    }
    public function update(){

    }
    public function delete(){

    }
}