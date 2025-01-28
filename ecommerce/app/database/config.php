<?php
require __DIR__ . "/../../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../../");
$dotenv->load();

// print_r($_COOKIE);die;
// Example usage


class config
{
    private $hostname;
    private $username;
    private $password;
    private $database;
    protected $con;
    public function __construct()
    {
        // print_r(date('Y-m-d G:i:s'));die;
        $host = $_SERVER['HTTP_HOST'];
        $subdomain = explode('.', $host)[0];
        // echo $subdomain;die;
        if ($subdomain != 'enterprisesoftware') {
            $db = $_COOKIE['tenant_db'];
        } else {
            $db = $_ENV['DB_DATABASE'];
        }
        $this->hostname = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->database = $db;
        $this->con = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if ($this->con->connect_error) {
            die("failed" . $this->con->connect_error);
        }
    }
    public function runDML(string $query, array $params = [])
    {
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $this->con->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // All params are treated as strings by default
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt;
    }

    public function runDQL(string $query, array $params = [])
    {
        try {
            //code...
            $stmt = $this->con->prepare($query);
        } catch (\Throwable $th) {
            //throw $th;
            die("Prepare failed: " . $this->con->error);
            // header('location:layout/errors/404.php');die;
        }


        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // All params are treated as strings by default
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 0) {
            return $result;
        } else {
            // echo 'sssss';die;
            return [];
        }
    }

    // public function runDML(string $query) 
    // {
    //     $result = $this->con->query($query);
    //     return $result;
    // }
    // public function runDQL(string $query) {
    //     $resultdql = $this->con->query($query);
    //     if ($resultdql->num_rows > 0) {
    //         return $resultdql;
    //     } else {
    //         return [];
    //     }
    // }
}
