<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "test1";
    protected $connection;

    public function connect() {
        if (!isset($this->connection)) {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->connection->connect_error) {
                die('Lỗi kết nối: ' . $this->connection->connect_error);
            }
            $this->connection->set_charset("utf8");
        }
        return $this->connection;
    }
}   
?> 