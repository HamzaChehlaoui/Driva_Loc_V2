<?php
// classes/Comment.php
class Comment {
    private $conn;
    private $table_name = "comments";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getArticleComments($article_id) {
        $query = "SELECT c.*, u.nom as user_name 
                 FROM " . $this->table_name . " c 
                 LEFT JOIN user u ON c.idUser = u.idUser 
                 WHERE c.article_id = ? 
                 ORDER BY c.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $article_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createComment($article_id, $user_id, $content) {
        $query = "INSERT INTO " . $this->table_name . " 
                 (article_id, idUser, content) 
                 VALUES (?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $article_id);
        $stmt->bindParam(2, $user_id);
        $stmt->bindParam(3, $content);
        return $stmt->execute();
    }

    public function updateComment($comment_id, $content) {
        $query = "UPDATE " . $this->table_name . " 
                 SET content = ? 
                 WHERE comment_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $content);
        $stmt->bindParam(2, $comment_id);
        return $stmt->execute();
    }

    public function deleteComment($comment_id) {
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE comment_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $comment_id);
        return $stmt->execute();
    }

    public function getCommentById($comment_id) {
        $query = "SELECT c.*, u.nom as user_name 
                 FROM " . $this->table_name . " c 
                 LEFT JOIN user u ON c.idUser = u.idUser 
                 WHERE c.comment_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $comment_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isCommentOwner($comment_id, $user_id) {
        $query = "SELECT 1 FROM " . $this->table_name . " 
                 WHERE comment_id = ? AND idUser = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $comment_id);
        $stmt->bindParam(2, $user_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}