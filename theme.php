<?php
require 'conn.php';

class theme {
    private $conn;
    const TABLE_NAME_THEMES = "themes";  
    const TABLE_NAME_ARTICLES = "articles";
    const TABLE_NAME_COMMENTS = "comments";
    public $name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addtheme() {
        if (empty($this->name)) {
            echo "Name is required.";
            return false;
        }

        $query = "INSERT INTO " . self::TABLE_NAME_THEMES . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to insert theme.");
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo "An error occurred. Please try again later.";
            return false;
        }
    }

    public function gettheme() {
        try {
            $query = "SELECT * FROM " . self::TABLE_NAME_THEMES;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return [];
        }
    }

    public function getArticles($searchTerm = '') {
        $query = "SELECT * FROM " . self::TABLE_NAME_ARTICLES;
        
        if ($searchTerm) {
            $query .= " WHERE title LIKE :searchTerm OR contents LIKE :searchTerm";
        }
        
        $stmt = $this->conn->prepare($query);
        
        if ($searchTerm) {
            $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getcommit() {
        try {
            $query = "SELECT article_id, content FROM " . self::TABLE_NAME_COMMENTS;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return [];
        }
    }
}
?>
