<?php
require 'conn.php';

class theme {
    private $conn;
    private $table_name = "themes";  
    public $name;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function addtheme() {
        
        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
