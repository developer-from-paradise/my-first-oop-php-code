<?php

// This class provides methods for creating a Database object, registering users, and checking for existing users.
class Database {
    // Variable initialization
    public $db_host;
    public $db_user;
    public $db_pass;
    public $db_name;

    public function __construct(string $db_host, string $db_user, string $db_pass, string $db_name){
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }
    
    // This method registers user into database
    public function register(string $oauth_uid, string $email): bool{
        // Connecting to database
        $conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if(!$conn) {
            die("Connection failed: ".mysqli_connect_error());
        }
        // Checking if user exist's in database
        if($this->check($email)){
            return true;
        } else {
            // If user doesn't exists add them
            $sql = "INSERT INTO users(oauth_uid, email) VALUES('{$oauth_uid}', '{$email}')";
            
            $result = mysqli_query($conn, $sql); // Making a query
            mysqli_close($conn); // Closing connection to database

            // Checking result
            if (!$result) {
                return false;
            } else {
                return true;
            }
        }
    }
    // Method of checking user in the database by email
    public function check($email) {
        // Connectiong into database
        $conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if (!$conn) {
            die("Connection failed: ".mysqli_connect_error());
        }
        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        
        $result = mysqli_query($conn, $sql); // Making a query
        mysqli_close($conn); // Closing connection to database
        
        // Checking if it returned any data
        if (mysqli_num_rows($result)==0) {
            return false;
        } else {
            return true;
        }
    }
}