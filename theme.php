<?php
require 'conn.php';

class theme {
    public $conn;
    public $table_name = "themes";  
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
    public function gettheme() {
        if (!$this->conn instanceof PDO) {
            echo 'Connection is not a valid PDO object';
            return [];
        }
    
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);  
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
