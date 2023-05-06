<?php
class Database {
    private $host = "localhost";
    private $username = "username";
    private $password = "password";
    private $dbname = "name";

    public function connect() {
        try {
            $conn = new PDO("pgsql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
?>
