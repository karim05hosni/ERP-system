<?php 
// include __DIR__."\..\\database\\config.php";
class validation {
    private $name;
    private $value;
    public function __construct($name, $value){
        $this->name = $name;
        $this->value = $value;
    }
    public function required(){
        return (empty($this->value)) ? "<div class='alert alert-danger'>enter your $this->name</div>" : "";
    }
    public function regex($pattern){
        return (preg_match($pattern, $this->value)) ? "" : "your $this->name is not valid";
    }
    public function unique($table){
        $query = "SELECT * FROM `$table` WHERE `$this->name` = '$this->value'";
        $config = new config();
        $result = $config->runDQL($query);
        if(empty($result)) {return '';} else{return  "$this->name already exists";};
    }
    public function confirm($confirm){
        return ($this->value == $confirm) ? "":"$this->name not confirmed";
    }
};