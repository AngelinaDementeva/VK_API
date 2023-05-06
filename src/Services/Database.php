<?php
class Database {
    private $host = "localhost";
    private $username = "your_username";
    private $password = "your_password";
    private $dbname = "your_database_name";

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
