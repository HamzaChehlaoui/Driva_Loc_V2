<?php
require 'conn.php';

class theme {
    public $conn;
    public $table_name = "themes";  
    public $table_name2 = "articles";
    private $table_name3 = "comments";
    public $name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addtheme() {
        if (empty($this->name)) {
            echo "Name is required.";
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to insert theme.");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function gettheme() {
        try {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getArticles() {
        try {
            $query = "SELECT * FROM " . $this->table_name2;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getcommit() {
        try {
            $query = "SELECT article_id, content FROM " . $this->table_name3; 
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    
    
}
?>
