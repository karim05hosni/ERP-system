<?php 
include_once __DIR__."\..\database\config.php";
include_once __DIR__."\..\database\ops.php";

class user extends config implements ops{
    // insert
    // update
    // delete
    // select
    private$id;
    private $name;
    private $email;
    private $password;
    private $code;
    private $status;
    private $img;
    private $email_verified_at;
    private $phone_no;
    private $gender;
    private $created_at;
    private $updated_at;
    private $rem_me;
    

    // ------GETTERS------
    public function getid(){
        return $this->id;
    }

    public function getn(){
        return $this->name;
    }

    public function getemail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getCode(){
        return $this->code;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getimg(){
        return $this->img;
    }
    public function getEmailVerifiedAt(){
        return $this->email_verified_at;
    }
    public function getGender(){
        return $this->gender;
    }
    public function getCreatedAt(){
        return $this->created_at;
    }
    public function getUpdatedAt(){
        return $this->updated_at;
    }

    public function getrem_me(){
        return $this->rem_me;
    }


    // -----SETTERS------

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }


    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = sha1($password);
    }
    public function setCode($code) {
        $this->code = $code;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setImg($img) {
        $this->img = $img;
    }

    public function setEmailVerifiedAt($email_verified_at) {
        $this->email_verified_at = $email_verified_at;
    }

    public function setPhoneNo($phone_no) {
        $this->phone_no = $phone_no;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function setrem_me($rem_me){
        $this->rem_me = $rem_me;
    }

    // ----END SETTERS----

    public function creat() {
        $query = "INSERT INTO users(name, email, phone, password, gender, code, created_at) VALUES('$this->name', '$this->email','$this->phone_no', '$this->password', '$this->gender', '$this->code', '$this->created_at')";
        
        $result= $this->runDML($query);
                // Debugging: Check if the query was successful
                // if ($result === false) {
                //     echo "Error executing query: " . $this->con->error . "\n";
                // }
        return $result; 
    }
    public function read(){

    }
    public function update(){
        $img = NULL;
        if(!empty($this->img)){
            $img = ", `img`='$this->img'" ;
        }
        $query = "UPDATE users SET  `name` = '$this->name', `phone` = '$this->phone_no', `gender` = '$this->gender' $img, `updated_at`='$this->updated_at' WHERE email = '$this->email'";
        return $this->runDML($query);
    }
    public function delete(){

    }

    public function updatepassword(){
        $query = "UPDATE users SET `password` = '$this->password' WHERE email = '$this->email'";
        return $this->runDML($query);
    }

    public function updatecode(){
        $query = "UPDATE users SET `code` = $this->code WHERE email = '$this->email'";
        return $this->runDML($query);
    }

    public function verifyCode(){
        $query = "SELECT * FROM `users` WHERE email = '$this->email' AND code = '$this->code' ";
        return $this->runDQL($query);
    }

    public function verifyUser(){
        $query = "UPDATE users SET `status` = $this->status, email_verified_at = '$this->email_verified_at' WHERE email = '$this->email'";
        return $this->runDML($query);
    }

    public function login(){
        $query = "SELECT * FROM `users` WHERE email = '$this->email' AND password = '$this->password' ";
        return $this->runDQL($query);
    }

    
    public function get_user_by_email(){
        $query = "SELECT * FROM `users` WHERE email = '$this->email'";
        return $this->runDQL($query);
    }
    public function get_user_by_rm(){
        $query = " SELECT * FROM users WHERE remember_token = '$this->rem_me' ";
        return $this->runDQL($query);
    }
    public function generat_rem_me(){
        $query = "UPDATE users SET remember_token = (UUID()) WHERE email = '$this->email'";
        return $this->runDML($query);
    }

    public function get_rem(){
        $query = " SELECT remember_token from users WHERE email = '$this->email' ";
        return $this->runDQL($query);
    }

    public function del_rem_code(){
        $query = "UPDATE users SET remember_token = NULL WHERE remember_token = '$this->rem_me' ";
        return $this->runDML($query);
    }
}
// $i = new user;
// $i->setrem_me("7529327ef10117bdac2429ededbbdc07cc585f7d");
// print_r($i->get_user_by_rm());
