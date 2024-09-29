<?php 
class config {
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "nti_laravel";
    protected $con;
    public function __construct() {
        $this->con = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if ($this->con->connect_error) {
            die("failed". $this->con->connect_error);
        }
    }

    public function runDML(string $query) 
    {
        $result = $this->con->query($query);
        return $result;
    }
    public function runDQL(string $query) {
        $resultdql = $this->con->query($query);
        if ($resultdql->num_rows > 0) {
            return $resultdql;
        } else {
            return [];
        }
        
        
                // Debug: Check if query execution was successful
                // if (!$resultdql) {
                //     echo "Error: " . $this->con->error . "\n";
                //     return [];
                // }
        
                // // Debug: Check if result is not false
                // if ($resultdql === false) {
                //     echo "Query failed to execute.\n";
                //     return [];
                // }
    }
}
// $test= new config;
// $c = $test->runDML("SELECT * FROM users WHERE rem_me = '3f6a3d9581dc27ee4049f658d5c29d6648778f79' ");
// $c->fetch_all();