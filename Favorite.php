<?php
class Favorite {
    private $conn;
    private $table_name = "favorites";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addFavorite($userId, $articleId) {
        // Check if already exists
        if ($this->isFavorite($userId, $articleId)) {
            return false;
        }

        $query = "INSERT INTO favorites (idUser, article_id) VALUES (:userId, :articleId)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":articleId", $articleId);
        
        return $stmt->execute();
    }

    public function removeFavorite($userId, $articleId) {
        $query = "DELETE FROM favorites WHERE idUser = :userId AND article_id = :articleId";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":articleId", $articleId);
        
        return $stmt->execute();
    }

    public function isFavorite($userId, $articleId) {
        $query = "SELECT COUNT(*) FROM favorites WHERE idUser = :userId AND article_id = :articleId";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":articleId", $articleId);
        
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function getUserFavorites($userId) {
        $query = "SELECT a.* FROM articles a 
                  INNER JOIN favorites f ON a.article_id = f.article_id 
                  WHERE f.idUser = :userId 
                  ORDER BY a.created_at DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}