<?php
class DBController {
    private $host = "localhost";
    private $user = "root";
    private $password = "root";
    private $database = "modiste(1)";
    private $conn;

    function __construct() {
        $this->conn = $this->connectDB();
    }

    function connectDB() {
        $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        return $conn;
    }

    function runQuery($query) {
        $result = $this->conn->query($query);
        $resultset = [];
        while($row = $result->fetch_assoc()) {
            $resultset[] = $row;
        }
        return $resultset;
    }
}

$db_handle = new DBController();
?>
