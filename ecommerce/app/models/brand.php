<?php 
include_once __DIR__."\..\database\config.php";
include_once __DIR__."\..\database\ops.php";
class brand extends config implements ops {
    private $id;
    private $name_en;
    private $status;

    private $created_at;
    private $updated_at;


    // Getters
    
    public function getId()
    {
        return $this->id;
    }

    public function getNameEn()
    {
        return $this->name_en;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNameEn($name_en)
    {
        $this->name_en = $name_en;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }


    function creat(){

    }
    function read(){
        $query = "SELECT name_en, id FROM brands WHERE status = 1";
        return $this->runDQL($query);
    }

    function update(){

    }

    function delete(){

    }

}