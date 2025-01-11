<?php
class Favorite {
    private $conn;
    private $table_name = "favorites";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserFavorites($user_id) {
        $query = "SELECT a.* 
                 FROM articles a
                 INNER JOIN " . $this->table_name . " f ON a.article_id = f.article_id 
                 WHERE f.idUser = ? 
                 ORDER BY f.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addFavorite($user_id, $article_id) {
        if(!$this->isFavorite($user_id, $article_id)) {
            $query = "INSERT INTO " . $this->table_name . " 
                     (idUser, article_id) 
                     VALUES (?, ?)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $user_id);
            $stmt->bindParam(2, $article_id);
            return $stmt->execute();
        }
        return false;
    }

    public function removeFavorite($user_id, $article_id) {
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE idUser = ? AND article_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $article_id);
        return $stmt->execute();
    }

    public function isFavorite($user_id, $article_id) {
        $query = "SELECT COUNT(*) as count 
                 FROM " . $this->table_name . " 
                 WHERE idUser = ? AND article_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $article_id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }
}