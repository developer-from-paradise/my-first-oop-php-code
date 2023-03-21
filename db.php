<?php


class Database {
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
    
    
    public function register(string $oauth_uid, string $email): bool{
        $conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if(!$conn) {
            die("Connection failed: ".mysqli_connect_error());
        }

        if($this->check($email)){
            return true;
        } else {
            $sql = "INSERT INTO users(oauth_uid, email) VALUES('{$oauth_uid}', '{$email}')";
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);
            if (!$result) {
                return false;
            } else {
                return true;
            }
        }
    }
    
    public function check($email) {
        $conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if (!$conn) {
            die("Connection failed: ".mysqli_connect_error());
        }
        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        if (mysqli_num_rows($result)==0) {
            return false;
        } else {
            return true;
        }
    }
}